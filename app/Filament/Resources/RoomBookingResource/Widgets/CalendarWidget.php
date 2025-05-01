<?php

namespace App\Filament\Resources\RoomBookingResource\Widgets;

use App\Filament\Resources\RoomBookingResource;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        $start = Carbon::parse($fetchInfo['start'])->format('Y-m-d');
        $end = Carbon::parse($fetchInfo['end'])->format('Y-m-d');

        return RoomBooking::query()
            ->where('starts_on', '>=', $start)
            ->where('ends_on', '<=', $end)
            ->get()
            ->map(function (RoomBooking $roomBooking) {
                return EventData::make()
                    ->id($roomBooking->id)
                    ->title("{$roomBooking->guest->name} in {$roomBooking->room->room_code} - {$roomBooking->room->name}")
                    ->start(Carbon::parse($roomBooking->starts_on)->startOfDay())
                    ->end(Carbon::parse($roomBooking->ends_on)->endOfDay())
                    ->url(url: RoomBookingResource::getUrl(name: 'edit', parameters: ['record' => $roomBooking]));
            })
            ->toArray();
    }
}
