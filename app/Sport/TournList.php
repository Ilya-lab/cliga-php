<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournList extends Model
{
    protected $table = 'sport.tb_tournlist';

    public function league()
    {
        return $this->belongsTo('App\Sport\Leagues');
    }

    public function logo()
    {
        return $this->belongsTo('App\Images\Images', 'image_id', 'id');
    }
}
