<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournTeams extends Model
{
    protected $table = 'sport.tb_tournteams';
    public $timestamps = false;

    public function scopeTournament($query, $id) {
        $query->where('tourn_id', $id);
    }

    public function logo()
    {
        return $this->belongsTo('App\Images\Images', 'logo_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Sport\Teams', 'team_id', 'id');
    }
}
