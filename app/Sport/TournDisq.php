<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournDisq extends Model
{
    protected $table = 'sport.tb_tourndisq';
    public $timestamps = false;

    public function scopeTournament($query, $tourn) {
        $query->where('sport.tb_tourndisq.tourn_id', $tourn);
    }

    public function scopePlayer($query, $player) {
        $query->where('sport.tb_tourndisq.player_id', $player);
    }

    public function scopeMatch($query, $match) {
        $query->where('sport.tb_tourndisq.match_id', $match);
    }

    public function player()
    {
        return $this->belongsTo('App\Sport\TournPlayers', 'player_id', 'id');
    }

    public function matches()
    {
        return $this->belongsToMany('App\Sport\TournMatches', 'sport.tb_tourndisq_matches','disq_id','match_id');
            //->using('App\Sport\TournDisqMatches');
    }
}
