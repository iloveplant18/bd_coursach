<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    public $table = 'Бронирование';
    public $primaryKey = 'Номер_бронирования';
    public $timestamps = false;
    public $guarded = [];

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class, 'Номер_комнаты', 'Номер_комнаты');
    }

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class, 'Код_клиента', 'Код_клиента');
    }

    public function personal(): BelongsTo {
        return $this->belongsTo(Personal::class, 'Номер_работника', 'Номер_работника');
    }

    public function inclusions(): HasMany {
        return $this->hasMany(Inclusion::class, 'Номер_бронирования', 'Номер_бронирования');
    }

    public function payments(): HasMany {
        return $this->hasMany(Payment::class, 'Номер_бронирования', 'Номер_бронирования');
    }

    public function reformatDates(): void {

    }
}
