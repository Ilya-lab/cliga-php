<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class Tournaments extends Model
{
    protected $table = 'sport.tb_tournaments';

    /**
     * Загрузить турниры опред.типа
     * @param $query
     * @param $id - идентификатор типат урнира
     */
    public function scopeTournament($query, $id = 1) {
        $query->where('tournament_id', $id);
    }

    /**
     * Поиск соревнования по URL
     * @param $query
     * @param $url
     */
    public function scopeURL($query, $url) {
        $query->where('url', $url);
    }

    /**
     * Загрузить только текущие турниры
     * @param $query
     */
    public function scopeActive($query) {
        $query->where('status_id', 1);
    }

    /**
     * Загрузить по виду спорта
     * @param $query
     * @param $sport_id - идентификатор вида спорта
     */
    public function scopeSport($query, $sport_id) {
        $query->where('sport_id', $sport_id);
    }

    /**
     * Загрузить соревнования в сезоне
     * @param $query
     * @param $season_id - идентификатор сезона
     */
    public function scopeSeason($query, $season_id) {
        $query->where('season_id', $season_id);
    }

    /**
     * Статус турнира
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Classif\Status', 'status_id', 'id');
    }

    /**
     * Ссылка на вид спорта
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo('App\Sport\Sport', 'sport_id', 'id');
    }

    /**
     * Ссылка на тип соревнования
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo('App\Classif\Levels', 'level_id', 'id');
    }

    /**
     * Ссылка на сезон
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo('App\Sport\Seasons', 'season_id', 'id');
    }

    public function basketball()
    {
        return $this->belongsTo('App\Sport\TournamentsBasketball', 'id', 'tourn_id');
    }
}
