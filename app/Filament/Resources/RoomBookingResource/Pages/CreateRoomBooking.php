<?php

namespace App\Filament\Resources\RoomBookingResource\Pages;

use App\Filament\Resources\RoomBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRoomBooking extends CreateRecord
{
    protected static string $resource = RoomBookingResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['accommodation_id'] = auth()->user()->staff->staffable_id;

        return $data;
    }
}
