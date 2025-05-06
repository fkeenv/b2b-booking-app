<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function transportation(): BelongsTo
    {
        return $this->belongsTo(Transportation::class);
    }
    
    public function staffs(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)
            ->withPivot('staff_id', 'vehicle_id', 'starts_at', 'ends_at', 'created_at');
    }
    
    public function getFullNameAttribute(): string
    {
        return "[{$this->license_plate}] {$this->year} {$this->color} {$this->make} {$this->model}";
    }
}
