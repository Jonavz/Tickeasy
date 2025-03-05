<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'description', 'price', 'category_id',
        'place_id', 'fecha_de_inicio', 'fecha_finalizacion', 'logo_image'
    ];




    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }









public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function getAvailableTicketsAttribute()
{
    return $this->place ? $this->place->max_capacity - $this->tickets()->sum('quantity') : 0;
}


public function place()
{
    return $this->belongsTo(Place::class, 'place_id');
}


}
