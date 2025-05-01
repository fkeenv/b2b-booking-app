<?php

namespace App\Filament\Resources;

use App\Models\Room;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\RoomResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $navigationGroup = 'Accommodation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Room Name')
                    ->placeholder('Enter room name'),
                TextInput::make('room_code')
                    ->required()
                    ->label('Room Code')
                    ->placeholder('Enter room code'),
                TextInput::make('description')
                    ->label('Description')
                    ->placeholder('Enter room description'),
                TextInput::make('capacity')
                    ->required()
                    ->numeric()
                    ->label('Capacity')
                    ->placeholder('Enter room capacity'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->label('Price')
                    ->placeholder('Enter room price'),
                Select::make('type')
                    ->required()
                    ->label('Room Type')
                    ->options([
                        'single' => 'Single',
                        'double' => 'Double',
                        'suite' => 'Suite',
                        'family' => 'Family',
                    ])
                    ->placeholder('Select room type'),
                FileUpload::make('image_url')
                    ->label('Room Image')
                    ->image()
                    ->disk('public')
                    ->directory('room-images')
                    ->preserveFilenames()
                    ->placeholder('Upload room image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Room Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room_code')
                    ->label('Room Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->sortable(),
                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('php', true)
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Room Type')
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            'single' => 'success',
                            'double' => 'info',
                            'suite' => 'warning',
                            'family' => 'danger',
                        };
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
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
            ])
            ->modifyQueryUsing(function (Builder $query) {
                /** @var User $user */
                $user = auth()->user();
                if ($user->can('viewAny', Room::class))
                    $query->when(!$user->isSuperAdmin(), function (Builder $query) use ($user) {
                        $query->where('accommodation_id', $user->staff->staffable_id);
                    });
            });;
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
