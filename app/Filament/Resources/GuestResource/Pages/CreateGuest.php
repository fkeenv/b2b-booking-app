<?php

namespace App\Filament\Resources\GuestResource\Pages;

use App\Filament\Resources\GuestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGuest extends CreateRecord
{
    protected static string $resource = GuestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['accommodation_id'] = auth()->user()->staff->staffable_id;

        return $data;
    }
}
