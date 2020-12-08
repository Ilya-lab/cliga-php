<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $table = 'sport.tb_teams';


    /**
     * Ссылка на основной цвет команды
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maincolor()
    {
        return $this->belongsTo('App\Classif\ColorForms', 'maincolor_id', 'id');
    }

    /**
     * Ссылка на вспомогательный цвет команды
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo('App\Classif\ColorForms', 'color_id', 'id');
    }

    public function alt_maincolor()
    {
        return $this->belongsTo('App\Classif\ColorForms', 'alt_maincolor_id', 'id');
    }

    public function alt_color()
    {
        return $this->belongsTo('App\Classif\ColorForms', 'alt_color_id', 'id');
    }
}
