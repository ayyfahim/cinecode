<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistributorResource\Pages;
use App\Filament\Resources\DistributorResource\RelationManagers;
use App\Models\Distributor;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DistributorResource extends Resource
{
    protected static ?string $model = Distributor::class;

    // protected static ?string $modelLabel = 'customer';

    // protected static ?string $title = 'Customer Management';

    protected static ?string $navigationLabel = 'Distributor Management';

    // protected static ?string $heading = 'Customer Management';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(1)
                    ->schema(
                        [
                            Forms\Components\TextInput::make('distributor_name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Toggle::make('allow_credit')
                                ->live()
                                ->required(),
                            Forms\Components\TextInput::make('credits')
                                ->visible(fn (\Filament\Forms\Get $get): bool => $get('allow_credit'))
                                ->numeric(),
                        ]
                    ),
                Forms\Components\Section::make('Emails')
                    ->description('Minimum one email is required.')
                    ->schema([
                        Forms\Components\Repeater::make('emails')
                            ->relationship('emails')
                            ->label('')
                            // ->grid(2)
                            // ->defaultItems(2)
                            ->reorderable(false)
                            ->simple(
                                Forms\Components\TextInput::make('email')->email()->required(),
                            )
                            ->minItems(1)
                            ->addActionLabel('Add Email')
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('distributor_name')
                    ->searchable()->sortable(),
                Tables\Columns\IconColumn::make('allow_credit')
                    ->boolean(),
                Tables\Columns\TextColumn::make('credits')
                    ->numeric()->placeholder('No credits given.'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDistributors::route('/'),
            'create' => Pages\CreateDistributor::route('/create'),
            'edit' => Pages\EditDistributor::route('/{record}/edit'),
        ];
    }
}
