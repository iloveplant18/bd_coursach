<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inclusion extends Model
{
    public $table = 'Включение';
    public $primaryKey = 'Номер_применения';
    public $timestamps = false;

    public function service(): BelongsTo {
        return $this->belongsTo(Service::class, 'Код_услуги', 'Код_услуги');
    }

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class, 'Номер_бронирования', 'Номер_бронирования');
    }

    public function realization(): HasOne {
        return $this->hasOne(Realization::class, 'Номер_применения', 'Номер_применения');
    }
}
