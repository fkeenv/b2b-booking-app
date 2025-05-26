<?php

namespace App\Filament\Resources\BookTransportationResource\Pages;

use App\Filament\Resources\BookTransportationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookTransportations extends ListRecords
{
    protected static string $resource = BookTransportationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
