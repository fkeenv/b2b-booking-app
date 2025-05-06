<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasFactory;

    protected $table = 'staffs';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function staffable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'staff_vehicle')
            ->withPivot('staff_id', 'vehicle_id', 'starts_at', 'ends_at', 'created_at');
    }
}
