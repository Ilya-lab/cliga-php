<?php

namespace App\Classif;

use Illuminate\Database\Eloquent\Model;

class ColorForms extends Model
{
    protected $table = 'classif.tk_colorforms';

    /**
     * Ограничение. Всё, кроме манишек
     * @param $query
     */
    public function scopeActive($query) {
        $query->where('id','>',2);
    }
}
