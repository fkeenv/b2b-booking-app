<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomBookingResource\Pages;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;

class RoomBookingResource extends Resource
{
    protected static ?string $model = RoomBooking::class;

    protected static ?string $navigationIcon = "heroicon-o-home-modern";
    protected static ?string $navigationGroup = "Accommodation";

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        
        return $form->schema([
            Select::make('room_id')
                ->label('Room')
                ->options(function () use ($user) {
                    return Room::where('accommodation_id', $user->staff->staffable->id)
                        ->get()
                        ->mapWithKeys(function ($room) {
                            return [$room->id => "{$room->room_code} - {$room->name}"];
                        });
                })
                ->searchable(),
            Select::make('guest_id')
                ->label('Guest')
                ->options(function () use ($user) {
                    return Guest::where('accommodation_id', $user->staff->staffable->id)
                        ->get()
                        ->mapWithKeys(function ($guest) {
                            return [$guest->id => "{$guest->email} - {$guest->name}"];
                        });
                })
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->required(),
                    Forms\Components\Select::make('gender')
                        ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'])
                    ->required(),
                    Forms\Components\DatePicker::make('date_of_birth')
                        ->required(),
                    Forms\Components\TextInput::make('address')
                        ->required(),
                ]),
            DatePicker::make('starts_on'),
            DatePicker::make('ends_on'),
            DateTimePicker::make('checked_in_at'),
            DateTimePicker::make('checked_out_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.room_code')
                    ->label('Room')
                    ->description(function (RoomBooking $roomBooking) {
                        return $roomBooking->room->name;
                    }),
                TextColumn::make('guest.name')
                    ->label('Guest')
                    ->description(function (RoomBooking $roomBooking) {
                        return $roomBooking->guest->email;
                    }),
                TextColumn::make('checked_in_at')
                    ->badge()
                    ->color('success')
                    ->dateTime('F d, Y H:i:s A'),
                TextColumn::make('checked_out_at')
                    ->badge()
                    ->color('warning')
                    ->dateTime('F d, Y H:i:s A'),
                TextColumn::make('stay')
                    ->badge()
                    ->color('info')
                    ->label('Stay')
                    ->state(function ($record) {
                        return Carbon::parse($record->starts_on)->diffInDays(Carbon::parse($record->ends_on)) . ' night';
                    }),
                TextColumn::make('starts_on')
                    ->date(),
                TextColumn::make('ends_on')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
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
            "index" => Pages\ListRoomBookings::route("/"),
            "create" => Pages\CreateRoomBooking::route("/create"),
            "edit" => Pages\EditRoomBooking::route("/{record}/edit"),
        ];
    }
}
