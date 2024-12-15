<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    public $table = 'Услуга';
    public $primaryKey = 'Код_услуги';
    public $timestamps = false;

    public function inclusions(): HasMany {
        return $this->hasMany(Inclusion::class, 'Код_услуги', 'Код_услуги');
    }
}
