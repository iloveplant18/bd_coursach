<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    public $table = 'images';
    public $timestamps = false;
    public $guarded = [];

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class, ownerKey: 'Номер_комнаты');
    }
}
