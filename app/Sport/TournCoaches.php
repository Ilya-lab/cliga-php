<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournCoaches extends Model
{
    protected $table = 'sport.tb_tourncoaches';

    /**
     * Тренерский штаб за турнир
     * @param $query
     * @param $tourn - идентификатор турнира
     */
    public function scopeTourn($query, $tourn) {
        $query->where('tb_tourncoaches.tourn_id', $tourn);
    }

    /**
     * Пост
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Classif\Post', 'post_id', 'id');
    }

    /**
     * Ссылка на человека
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Sport\Person', 'person_id', 'id');
    }
}
