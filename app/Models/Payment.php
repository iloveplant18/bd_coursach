<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Booking;

class Payment extends Model
{
    public $table = 'Оплата';
    public $primaryKey = 'Номер_транзакции';
    public $timestamps = false;

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class, 'Номер_бронирования', 'Номер_бронирования');
    }
}
