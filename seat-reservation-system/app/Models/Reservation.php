<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reserve_id';  // If your PK is named reserve_id

    // If your PK is not named 'id', and is an integer and auto-incrementing:
    public $incrementing = true;
    protected $keyType = 'int';

    // Fillable columns for mass assignment (optional)
    protected $fillable = [
        'intern_id',
        'seat_id',
        'reservation_date',
        'time_slot',
        'status',
    ];

    public function seat()
  {
    return $this->belongsTo(Seat::class, 'seat_id', 'seat_id');
  }

   public function intern()
   {
    return $this->belongsTo(User::class, 'intern_id', 'user_id');
   }


    // Add relationships if needed (e.g. to User and Seat models)
}
