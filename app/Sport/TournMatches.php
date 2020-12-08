<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournMatches extends Model
{
    protected $table = 'sport.tb_tournmatches';

    /**
     * Выбор игр за этап
     * @param $query
     * @param $stage - идентификатор этапа
     * @return mixed
     */
    public function scopeStage($query, $stage) {
        return $query->where('stage_id', $stage);
    }

    /**
     * выбрать матчи команды
     * @param $query
     * @param $team - идентификатор команды в турнире
     * @return mixed
     */
    public function scopeTeam($query, $team) {
        return $query->where('home_id',$team)->orWhere('away_id',$team);
    }

    /**
     * выбрать матчи команды после даты
     * @param $query
     * @param $date - дата и время
     */
    public function scopeAfterDate($query, $date) {
        $query->whereDate('datetime','>',$date);
    }


    public function matches()
    {
        return $this->hasMany('App\Sport\TournMatches', 'mainstage_id', 'id');
    }

    /**
     * ссылка на команду хозяина
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function home()
    {
        return $this->belongsTo('App\Sport\TournTeams', 'home_id', 'id');
    }

    /**
     * Ссылка на команду гостей
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function away()
    {
        return $this->belongsTo('App\Sport\TournTeams', 'away_id', 'id');
    }

    /**
     * Ссылка на тур
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tour()
    {
        return $this->belongsTo('App\Classif\Tours', 'tour_id', 'id');
    }

    /**
     * Ссылка на заявленную площадку
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo('App\Sport\BidArena', 'arena_id', 'id');
    }

    /**
     * Ссылка на текущий этап соревнования
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stage()
    {
        return $this->belongsTo('App\Sport\Stage', 'stage_id', 'id');
    }

    /**
     * ссылка на этап
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mainstage()
    {
        return $this->belongsTo('App\Sport\Stage', 'mainstage_id', 'id');
    }

    /**
     * Ссылка на статус игры
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Classif\Status', 'status_id', 'id');
    }

    /**
     * Ссылка на футбольный матч
     */
    public function football()
    {
        return $this->hasOne('App\Sport\TournMatches_Football','id','id');
        /* $query->join('sport.tb_tournmatches_football','sport.tb_tournmatches.id','sport.tb_tournmatches_football.id');
                       //->select('sport.tb_tournmatches_football.*');*/
    }

    /**
     * Вернуть сообытия в матче
     */
    public function events()
    {
        return $this->hasMany('App\Sport\MatchEvents','match_id','id');
    }
}
