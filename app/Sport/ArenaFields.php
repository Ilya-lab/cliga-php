<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class ArenaFields extends Model
{
    protected $table = 'sport.tb_arenafields';

    /**
     * Ссылка на арену
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arena()
    {
        return $this->belongsTo('App\Sport\Arenas', 'arena_id', 'id');
    }
}
