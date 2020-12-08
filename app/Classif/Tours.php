<?php

namespace App\Classif;

use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    protected $table = 'classif.tk_tours';

    /**
     * Вернуть не товарищеские игры
     * @param $query
     */
    public function scopeNoFriendly($query) {
        $query->where('id','<>',0);
    }
}
