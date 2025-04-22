<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verify_email')
                ->label('Mark as verified')
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check-badge')
                ->visible(function () {
                    return ! $this->record->email_verified_at;
                })
                ->action(function () {
                    $this->record->markEmailAsVerified();
                    Notification::make()
                        ->title('Email has been marked as verified.')
                        ->success()
                        ->send();
                }),
            Action::make('unverify_email')
                ->label('Mark as unverified')
                ->requiresConfirmation()
                ->color('warning')
                ->icon('heroicon-o-exclamation-triangle')
                ->visible(function () {
                    return $this->record->email_verified_at;
                })
                ->action(function () {
                    $this->record->update(['email_verified_at' => null]);
                    $this->record->save();
                    Notification::make()
                        ->title('Email has been marked as unverified.')
                        ->warning()
                        ->send();
                }),
        ];
    }
}
