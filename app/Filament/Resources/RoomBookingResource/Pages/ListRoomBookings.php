<?php

namespace App\Filament\Resources\RoomBookingResource\Pages;

use App\Filament\Resources\RoomBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomBookings extends ListRecords
{
    protected static string $resource = RoomBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RoomBookingResource\Widgets\CalendarWidget::class
        ];
    }
}
