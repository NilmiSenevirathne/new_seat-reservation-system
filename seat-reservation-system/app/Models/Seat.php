<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    protected $fillable = [
        'seat_num',
        'location'
    ];

    protected $primaryKey = 'seat_id'; // Only if your DB uses seat_id PK
    public $incrementing = true; // auto-increment seat_id
    public $timestamps = false; // If your table doesn't have created_at/updated_at

    /**
     * Get all reservations for this seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'seat_id', 'seat_id');
    }
}