<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Transportation extends Model
{
    /** @use HasFactory<\Database\Factories\TransportationFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function staffs(): MorphMany
    {
        return $this->morphMany(Staff::class, 'staffable');
    }
}
