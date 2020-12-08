<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class BidCoach extends Model
{
    protected $table = 'sport.tb_bidcoach';

    /**
     * За конкретную заявку
     * @param $query
     * @param $bid - идентификатор заявки
     */
    public function scopeBid($query, $bid) {
        $query->where('bid_id', $bid);
    }

    /**
     * Отзаявленные представители
     * @param $query
     * @param $bid - идентификатор заявки
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
     * Ссылка на пост в клубе
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Classif\Post', 'post_id', 'id');
    }
}
