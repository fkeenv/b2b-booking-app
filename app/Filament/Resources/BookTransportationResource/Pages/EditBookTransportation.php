<?php

namespace App\Filament\Resources\BookTransportationResource\Pages;

use App\Filament\Resources\BookTransportationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookTransportation extends EditRecord
{
    protected static string $resource = BookTransportationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
