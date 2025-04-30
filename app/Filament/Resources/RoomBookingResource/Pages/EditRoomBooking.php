<?php

namespace App\Filament\Resources\RoomBookingResource\Pages;

use App\Filament\Resources\RoomBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoomBooking extends EditRecord
{
    protected static string $resource = RoomBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
