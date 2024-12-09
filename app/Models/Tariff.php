<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model
{
    use HasFactory;

    public $table = 'Тариф';
    public $primaryKey = 'Код_тарифа';
    public $timestamps = false;

    public function rooms(): HasMany {
        return $this->hasMany(Room::class, 'Код_тарифа', 'Код_тарифа');
    }
}
