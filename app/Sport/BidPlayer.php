<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class BidPlayer extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'sport.tb_bidplayer';

    /**
     * За конкретную заявку
     * @param $query
     * @param $bid - идентификатор заявочного окна
     */
    public function scopeBid($query, $bid) {
        $query->where('bid_id', $bid);
    }

    /**
     * Отзаявленные игроки
     * @param $query
     * @param $bid - идентификатор заявочного окна
     */
    public function scopeUnbid($query, $bid) {
        $query->where('unbid_id', $bid);
    }

    /**
     * @param $query
     * @param $team - идентификатор команды в заявке на турнир
     */
    public function scopeTeam($query, $team) {
        $query->where('team_id', $team);
    }

    /**
     * Свзяать с позицией игрока
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo('App\Classif\Position', 'position_id', 'id');
    }

    /**
     * Ссылка на фотографию в заявке
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Images\Images', 'photo_id', 'id');
    }

    /**
     * Ссылка на человека
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Sport\Person', 'person_id', 'id');
    }

    /**
     * ссылка на принадлежность к капитану
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function captain()
    {
        return $this->belongsTo('App\Classif\Captain', 'captain_id', 'id');
    }

    public function bid()
    {
        return $this->belongsTo('App\Sport\TournBids', 'bid_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Sport\TournTeams', 'team_id', 'id');
    }
}
