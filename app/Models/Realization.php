<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Realization extends Model
{
    use HasFactory;
    public $table = 'Осуществление';
    public $primaryKey = 'Номер_осуществления';
    public $timestamps = false;

    public function inclusion(): BelongsTo {
        return $this->belongsTo(Inclusion::class, 'Номер_применения', 'Номер_применения');
    }

    public function personal(): BelongsTo {
        return $this->belongsTo(Personal::class, 'Номер_работника', 'Номер_работника');
    }
    }
