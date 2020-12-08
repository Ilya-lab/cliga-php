<?php

namespace App\Classif;

use Illuminate\Database\Eloquent\Model;

class CardReasons extends Model
{
    protected $table = 'classif.tk_cardreasons';

    /**
     * Выдать только за ЖК
     * @param $query
     */
    public function scopeYellowCards($query) {
        $query->where('event_id', 1);
    }

    /**
     * Выдать только за КК
     * @param $query
     */
    public function scopeRedCards($query) {
        $query->where('event_id', 3);
    }
}
