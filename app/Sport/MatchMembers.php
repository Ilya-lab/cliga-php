<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class MatchMembers extends Model
{
    protected $table = 'sport.tb_matchmembers';

    /**
     * Выбрать за конкретный матч
     * @param $query
     * @param $match_id - идентификатор матча
     */
    public function scopeMatch($query, $match_id) {
        $query->where('match_id', $match_id);
    }

    /**
     * Выбрать конкретного игрока в заявке на турнир
     * @param $query
     * @param $player_id - идентификатор игрока в турнире
     */
    public function scopePlayer($query, $player_id) {
        $query->where('player_id', $player_id);
    }

    /**
     * Выбрать за заявленную команду
     * @param $query
     * @param $team_id - идентификатор команду в турнире
     */
    public function scopeTeam($query, $team_id) {
        $query->where('team_id', $team_id);
    }

    /**
     * Связь с игроком турнира
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function playerInfo()
    {
        return $this->belongsTo('App\Sport\TournPlayers', 'player_id', 'id');
    }
}
