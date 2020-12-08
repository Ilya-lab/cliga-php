<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class MatchEvents extends Model
{
    protected $table = 'sport.tb_matchevents';
    public $timestamps = false;

    /**
     * ССылка на ассистента
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assist()
    {
        return $this->belongsTo('App\Sport\TournPlayers', 'assist_id', 'id');
    }

    /**
     * Ссылка на игрока турнира
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo('App\Sport\TournPlayers', 'player_id', 'id');
    }

    /**
     * События в игре
     * @param $query
     * @param $match_id - Идентификатор матча
     * @param $event_id - Идентификатор типа события
     * @param $player_id - идентификатор заявленного игрока
     */
    public function scopePlayerCard($query, $match_id, $event_id, $player_id) {
        $query->where('match_id', $match_id)->where('event_id', $event_id)->where('player_id', $player_id);
    }
}
