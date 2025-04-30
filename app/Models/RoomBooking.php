<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomBooking extends Model
{
    /** @use HasFactory<\Database\Factories\RoomBookingFactory> */
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
