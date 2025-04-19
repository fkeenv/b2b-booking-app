<?php

namespace App\Filament\Resources\TransportationResource\Pages;

use App\Filament\Resources\TransportationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\RelationManagers\RelationGroup;

class EditTransportation extends EditRecord
{
    protected static string $resource = TransportationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Transportation Management', [
                TransportationResource\RelationManagers\StaffsRelationManager::class,
                TransportationResource\RelationManagers\VehiclesRelationManager::class,
            ]),
        ];
    }
}
