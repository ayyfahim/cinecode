<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Mail\CinemaMovieDownload;
use App\Models\Order;
use App\Observers\OrderCinemaObserver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 4;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('distributor_id')
                    ->relationship('distributor', 'id')
                    ->required(),
                Forms\Components\Select::make('cinemas')
                    ->label('Cinemas')
                    ->multiple()
                    ->preload()
                    ->relationship('cinemas', 'name')
                    ->pivotData([
                        'download_token' => substr(sha1(rand()), 0, 10),
                    ])
                    ->required(),
                Forms\Components\Select::make('version_id')
                    ->relationship('version', 'version_name')
                    ->required(),
                Forms\Components\Select::make('movie_id')
                    ->relationship('movie', 'name')
                    ->required(),
                Forms\Components\Toggle::make('downloaded')
                    ->required(),
                Forms\Components\DateTimePicker::make('validity_period_from')
                    ->required(),
                Forms\Components\DateTimePicker::make('validity_period_to')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('distributor.distributor_name')
                    ->label('Distributor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cinemas.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cinemas.city_name')
                    ->label('Cinema City')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('movie.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version.version_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('downloaded')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Order Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('validity_period_from')
                    ->dateTime()
                    ->label('Validity Period From')
                    ->sortable(),
                Tables\Columns\TextColumn::make('validity_period_to')
                    ->dateTime()
                    ->label('Validity Period To')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('distributor_name')
                    ->relationship('distributor.distributor', 'distributor_name')
                    ->label('Distributor')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('cinema')
                    ->relationship('cinemas', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('movie')
                    ->relationship('movie', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('downloaded'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('sendCinemaMails')
                    ->accessSelectedRecords()
                    ->action(function (Model $record) {
                        $orderCinemas = $record->order_cinemas;
                        foreach ($orderCinemas as $orderCinema) {
                            (new OrderCinemaObserver())->created($orderCinema);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function sendCinemaMails($orderCinema)
    {
        $orderCinema = $orderCinema->load('cinema', 'cinema.country', 'order', 'order.movie', 'order.version', 'order.distributor', 'order.distributor.distributor');
        $data = [];
        $order = $orderCinema->order;
        $data['movie_title'] = $order?->movie?->name;
        $data['version'] = $order?->version?->version_name;
        $data['distributor'] = $order?->distributor?->distributor?->distributor_name;
        $data['validity_from'] = $order?->validity_period_from?->format('d.m.Y');
        $data['validity_to'] = $order?->validity_period_to?->format('d.m.Y');

        $download_link = "https://" . config('filament.cinema_portal_url') . '/movie/download' . "?token={$orderCinema?->download_token}&order={$orderCinema?->order->id}&c={$orderCinema?->cinema?->unique_hash}";
        $data['download_link'] = $download_link;

        $mcck_file = $order?->cck_file;
        $data['mcck_file'] = $mcck_file;

        $cinema_login_link = "https://" . config('filament.cinema_portal_url') . "?c={$orderCinema?->cinema?->unique_hash}";
        $data['cinema_login_link'] = $cinema_login_link;

        $mailLocale = App::getLocale();
        switch ($orderCinema?->cinema?->country->name) {
            case 'Germany':
                $mailLocale = 'de';
                break;
            case 'Austria':
                $mailLocale = 'de';
                break;
            case 'Switzerland':
                $mailLocale = 'de';
                break;
            case 'Luxembourg':
                $mailLocale = 'de';
                break;

            default:
                break;
        }

        foreach ($orderCinema?->cinema->emails as $email) {
            Mail::to($email)->locale($mailLocale)->send(new CinemaMovieDownload($data));
            sleep(1);
            // if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
            //     sleep(1); //use usleep(500000) for half a second or less
            // }
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.manageResources');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.order_mng');
    }

    public static function getModelLabel(): string
    {
        return __('resource.order');
    }
}
