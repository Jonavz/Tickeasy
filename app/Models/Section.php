<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['place_id', 'name', 'price'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}

