<?php

namespace App\Filament\Cinema\Resources;

use App\Filament\Cinema\Resources\OrderResource\Pages;
use App\Filament\Cinema\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                // Tables\Columns\TextColumn::make('cinemas.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('cinemas.city_name')
                //     ->label('Cinema City')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('movie.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version.version_name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\IconColumn::make('downloaded')
                //     ->boolean(),
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
                // Tables\Filters\SelectFilter::make('cinema')
                //     ->relationship('cinemas', 'name')
                //     ->searchable()
                //     ->preload(),
                Tables\Filters\SelectFilter::make('movie')
                    ->relationship('movie', 'name')
                    ->searchable()
                    ->preload(),
                // Tables\Filters\TernaryFilter::make('downloaded'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->accessSelectedRecords()
                    ->action(function (Model $record, Collection $selectedRecords) {
                        // dd($record->load('order_cinemas'));
                        $orderCinema = $record->order_cinemas()->where('cinema_id', auth('cinema')->id())->first();
                        return redirect(route('cinema.movie.download') . "?token={$orderCinema?->download_token}&order={$record->id}");
                    }),
            ])
            ->headerActions([
                //
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrders::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.order_mng');
    }

    public static function getModelLabel(): string
    {
        return __('resource.order');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('order_cinemas', function ($query) {
            $query->where('cinema_id', auth('cinema')->id());
        });
    }
}
