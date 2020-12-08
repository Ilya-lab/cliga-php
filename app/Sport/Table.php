<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'sport.tb_table';
    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo('App\Sport\TournTeams', 'team_id', 'id');
    }
}
