<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt(Str::random(10)),
        ]);

        $data["user_id"] = $user->id;
        $data["staffable_type"] = auth()->user()->staff->staffable_type;
        $data["staffable_id"] = auth()->user()->staff->staffable_id;

        return $data;
    }
}
