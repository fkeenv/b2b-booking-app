<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Models\Staff;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $pluralLabel = "staffs";
    protected static ?string $slug = "staffs";
    protected static ?string $navigationGroup = "User Management";

    protected static ?string $navigationIcon = "heroicon-o-user-group";

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make("name")->required(),
            TextInput::make("email")->required(),
            TextInput::make("phone")->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("staffable.name")
                    ->label("Organization")
                    ->searchable(),
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("user.email")
                    ->label("Email")
                    ->searchable(),
                Tables\Columns\TextColumn::make("phone"),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                //
            ])
            ->modifyQueryUsing(function (Builder $query) {
                /** @var User $user */
                $user = auth()->user();
                $user->isSuperAdmin() && $user->can("viewAny", Staff::class)
                    ? $query->where("staffable_id", $user->id)
                    : $query
                        ->where("user_id", "!=", $user->id)
                        ->where("staffable_type", $user->staff->staffable_type)
                        ->where("staffable_id", $user->staff->staffable_id);
            });
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VehiclesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListStaff::route("/"),
            "create" => Pages\CreateStaff::route("/create"),
            "edit" => Pages\EditStaff::route("/{record}/edit"),
        ];
    }
}
