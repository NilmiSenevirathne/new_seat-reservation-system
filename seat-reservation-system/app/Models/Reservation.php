<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reserve_id'; // ✅ custom PK
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'intern_id',
        'seat_id',
        'reservation_date',
        'time_slot',
        'status',
    ];

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class, 'seat_id', 'seat_id');
    }

    public function intern(): BelongsTo
    {
        return $this->belongsTo(User::class, 'intern_id', 'user_id');
    }
}
?>
