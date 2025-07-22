<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $primaryKey = 'seat_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'seat_num',
        'location',
        'status',
    ];

    // Define the one-to-many relationship with Reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'seat_id', 'seat_id');
        // hasMany(TargetModel, foreign_key_in_reservations, local_key_in_seats)
    }
}
