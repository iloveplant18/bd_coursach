<?php

namespace App\Models;

use App\Observers\RoomObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([RoomObserver::class])]
class Room extends Model
{
    use HasFactory;

    public $table = 'Номер';
    public $primaryKey = 'Номер_комнаты';
    public $timestamps = false;

    public function tariff(): BelongsTo {
        return $this->belongsTo(Tariff::class, 'Код_тарифа', 'Код_тарифа');
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class, 'Номер_комнаты', 'Номер_комнаты');
    }

    public function images(): HasMany {
        return $this->hasMany(Image::class, localKey: 'Номер_комнаты');
    }
}
