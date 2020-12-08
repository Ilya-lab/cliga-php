<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $table = 'sport.tb_stage';

    /**
     * За турнир
     * @param $query
     * @param $id - идентификатор турнира
     */
    public function scopeTourn($query, $id) {
        $query->where('sport.tb_stage.tourn_id', $id);
    }

    /**
     * Вывести только корневые этапы. Группы не выведутся
     * @param $query
     */
    public function scopeMain($query) {
        $query->where('parent_id', null);
    }

    /**
     * Вернуть родителей
     * @param $query
     * @param $id - идентификатор этапа
     */
    public function scopeParent($query, $id) {
        $query->where('parent_id', $id);
    }

    /**
     * Матчи этапа
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\Sport\TournMatches', 'mainstage_id', 'id');
    }

    /**
     * Турнирная таблица чемпионата
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function table()
    {
        return $this->hasMany('App\Sport\Table', 'stage_id', 'id')->orderBy('place')->orderBy('win')->orderBy('nic');
    }


    public function child()
    {
        return $this->hasMany('App\Sport\Stage', 'parent_id', 'id');
    }

    public function levels()
    {
        return $this->belongsTo('App\Classif\Levels', 'levels_id', 'id');
    }

    public function tournament()
    {
        return $this->belongsTo('App\Sport\Tournaments', 'tourn_id', 'id');
    }

    public function match()
    {
        return $this->hasOne('App\Sport\TournMatches', 'stage_id', 'id');
    }
}
