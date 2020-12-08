<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;
//use Awobaz\Compoships\Database\Eloquent\Model;

class TournPlayers extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'sport.tb_tournplayers';

    /**
     * Игроки за турнир
     * @param $query
     * @param $tourn - идентификатор турнира
     */
    public function scopeTourn($query, $tourn) {
        $query->where('tb_tournplayers.tourn_id', $tourn);
    }

    /**
     * Позиция игрока
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo('App\Classif\Position', 'position_id', 'id');
    }

    /**
     * Капитан
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function captain()
    {
        return $this->belongsTo('App\Classif\Captain', 'captain_id', 'id');
    }

    /**
     * Ссылка на человека
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Sport\Person', 'player_id', 'id');
    }

    public function bid()
    {
        return $this->belongsTo('App\Sport\BidPlayer', ['lastbid_id', 'player_id'], ['bid_id','person_id']);
    }

    public function lastbid()
    {
        return $this->belongsTo('App\Sport\TournBids', 'lastbid_id', 'id');
    }

    public function football()
    {
        return $this->belongsTo('App\Sport\TournPlayers_Football', 'id','tournplayer_id');
    }
}
