<?php

namespace App\Filament\Cinema\Resources\CinemaEmailResource\Pages;

use App\Filament\Cinema\Resources\CinemaEmailResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCinemaEmails extends ManageRecords
{
    protected static string $resource = CinemaEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $data['cinema_id'] = auth('cinema')->id();

                return $data;
            }),
        ];
    }
}
