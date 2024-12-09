<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personal extends Model
{
    use HasFactory;

    public $table = 'Персонал';
    public $primaryKey = 'Номер_работника';
    public $timestamps = false;

    public function user(): HasOne {
        return $this->hasOne(User::class, 'personal_number', 'Номер_работника');
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class, 'Номер_работника', 'Номер_работника');
    }

    public function realizations(): HasMany {
        return $this->hasMany(Realization::class, 'Номер_работника', 'Номер_работника');
    }


}
