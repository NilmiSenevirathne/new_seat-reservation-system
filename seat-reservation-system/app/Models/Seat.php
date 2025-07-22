<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'seat_num',
        'location'
    ];

    protected $primaryKey = 'seat_id'; // Only if your DB uses seat_id PK
    public $incrementing = true; // auto-increment seat_id
    public $timestamps = false; // If your table doesn’t have created_at/updated_at
}
