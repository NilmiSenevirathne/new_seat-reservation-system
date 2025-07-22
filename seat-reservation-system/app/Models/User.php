<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Reservation; // Ensure you import the Reservation model
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the primary key name here:
    protected $primaryKey = 'user_id';

    // If the primary key is an integer and auto-incrementing, keep this true (default)
    public $incrementing = true;

    // If your PK type is integer (default), you can omit $keyType, else specify as needed
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    public function reservations(): HasMany
   {
    return $this->hasMany(Reservation::class, 'intern_id', 'user_id');
    // Uses 'intern_id' on reservations table and 'user_id' on users table
   }

}
