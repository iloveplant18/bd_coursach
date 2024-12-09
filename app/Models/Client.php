<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    public $table = 'Клиент';
    public $primaryKey = 'Код_клиента';
    public $timestamps = false;

    public function user(): HasOne {
        return $this->hasOne(User::class, 'client_code', 'Код_клиента');
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class, 'Код_клиента', 'Код_клиента');
    }
}
