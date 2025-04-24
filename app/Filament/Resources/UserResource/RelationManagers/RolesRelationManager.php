<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('guard_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordTitleAttribute('roles.name')
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make()
            ]);
    }
}
