<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CinemaResource\Pages;
use App\Filament\Resources\CinemaResource\RelationManagers;
use App\Models\Cinema;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CinemaResource extends Resource
{
    protected static ?string $model = Cinema::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    protected static ?string $navigationLabel = 'Cinema Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('unique_hash')
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Section::make('Location')
                            ->schema([
                                Forms\Components\Select::make('country_id')
                                    ->required()
                                    ->live()
                                    ->label('Country')
                                    ->options(Country::whereIn('name', ['Germany', 'Austria', 'Switzerland', 'Luxembourg'])
                                        ->orderByRaw("FIELD(name, 'Germany', 'Austria', 'Switzerland', 'Luxembourg')")
                                        ->pluck('name', 'id')
                                        ->union(Country::whereNotIn('name', ['Germany', 'Austria', 'Switzerland', 'Luxembourg'])->pluck('name', 'id'))),

                                Forms\Components\TextInput::make('city_name')
                                    ->required()
                                    ->maxLength(255)

                                // Forms\Components\Select::make('city_id')
                                //     ->required()
                                //     ->label('City')
                                //     ->placeholder(fn (Forms\Get $get): string => empty($get('country_id')) ? 'First select country' : 'Select an option')
                                //     ->options(function (?Cinema $record, Forms\Get $get, Forms\Set $set) {
                                //         if (!empty($record) && !empty($get('country_id'))) {
                                //             $set('country_id', $record->country_id);
                                //             $set('city_id', $record->city_id);
                                //         }

                                //         return State::where('country_id', $get('country_id'))->pluck('name', 'id');
                                //     }),
                            ]),

                        Forms\Components\Section::make('Emails')
                            ->description('Minimum one email is required.')
                            ->schema([
                                Forms\Components\Repeater::make('emails')
                                    ->relationship('emails')
                                    ->label('')
                                    ->reorderable(false)
                                    ->simple(
                                        Forms\Components\TextInput::make('email')->email()->required(),
                                    )
                                    ->minItems(1)
                                    ->addActionLabel('Add Email')
                            ])
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('visible_to_all')
                                    ->default('true')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('distributor.name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('visible_to_all')
                    ->boolean(),
                Tables\Columns\IconColumn::make('downloaded_player')
                    ->getStateUsing(function ($record) {
                        return (bool) $record->downloaded_player;
                    })
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('city_name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('country')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListCinemas::route('/'),
            'create' => Pages\CreateCinema::route('/create'),
            'edit' => Pages\EditCinema::route('/{record}/edit'),
        ];
    }
}
