<?php

namespace App\Classif;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'classif.tk_position';

    public function scopeActive($query) {
        $query->where('id','>',0);
    }
}
