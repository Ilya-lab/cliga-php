<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class BidArena extends Model
{
    protected $table = 'sport.tb_bidarena';

    /**
     * Ссылка на площадку
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('App\Sport\ArenaFields', 'field_id', 'id');
    }

}
