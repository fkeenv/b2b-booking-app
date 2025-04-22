<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Name')
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email')
                    ->unique()
                    ->maxLength(255),
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->label('Password')
                    ->dehydrated(fn ($state) => !empty($state))
                    ->maxLength(255)
                    ->confirmed()
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->visible(fn ($record) => !$record || !$record->exists),
                TextInput::make('password_confirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->dehydrated(false)
                    ->visible(fn ($record) => !$record || !$record->exists),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('staff.staffable.name')
                    ->label('Organization')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
