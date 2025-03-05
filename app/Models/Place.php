<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model {
    use HasFactory;
    protected $fillable = ['name', 'location', 'max_capacity'];


    public function events()
{
    return $this->hasMany(Event::class, 'place_id');
}

}






