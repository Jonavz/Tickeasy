<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_id', 'quantity', 'amount_paid', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getAvailableTicketsAttribute()
{
    return $this->place ? $this->place->max_capacity - $this->tickets()->sum('quantity') : 0;
}

}

