<?php

namespace App\Filament\Resources\StaffResource\RelationManagers;

use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VehiclesRelationManager extends RelationManager
{
    protected static string $relationship = "vehicles";
    protected static bool $shouldEagerLoadTableRelations = true;

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("make")
                ->required()
                ->maxLength(255),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("license_plate")
            ->columns([
                Tables\Columns\TextColumn::make("make"),
                Tables\Columns\TextColumn::make("model"),
                Tables\Columns\TextColumn::make("year"),
                Tables\Columns\TextColumn::make("color"),
                Tables\Columns\TextColumn::make("license_plate")
            ])
            ->inverseRelationship('staffs')
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['license_plate', 'make', 'model'])
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Vehicle')
                            ->options(function (RelationManager $livewire) {
                                return Vehicle::query()
                                    ->where("transportation_id", $livewire->getOwnerRecord()->staffable_id)
                                    ->get()
                                    ->mapWithKeys(function ($vehicle) {
                                        return [$vehicle->id => $vehicle->full_name];
                                    });
                            }),
                        DateTimePicker::make('starts_at'),
                        DateTimePicker::make('ends_at'),
                    ])
                    ->using(function (RelationManager $livewire, array $data, $pivotData = []) {
                        return $livewire->getOwnerRecord()->vehicles()->attach($data['recordId'], [
                            'staff_id' => $livewire->getOwnerRecord()->id,
                            'vehicle_id' => $data['recordId'],
                            'starts_at' => $data['starts_at'],
                            'ends_at' => $data['ends_at'],
                            'created_at' => now()
                        ]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
