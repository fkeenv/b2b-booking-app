<?php

namespace App\Filament\Resources\TransportationResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class StaffsRelationManager extends RelationManager
{
    protected static string $relationship = 'staffs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email(),
                Forms\Components\TextInput::make('phone')
                    ->nullable(),
                Forms\Components\Hidden::make('staffable_type')
                    ->default(function ($livewire) { return get_class($livewire->getOwnerRecord()); }),
                Forms\Components\Hidden::make('staffable_id')
                    ->default(function ($livewire) { return $livewire->getOwnerRecord()->id; }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {
                        $data['staffable_type'] = get_class($this->getOwnerRecord());
                        $data['staffable_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    })
                    ->using(function (array $data, $livewire) {
                        $user = User::create([
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'password' => bcrypt(Str::random(12)),
                        ]);

                        return $livewire->getRelationship()->create(array_merge($data, ['user_id' => $user->id]));
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
