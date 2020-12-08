<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournPlayers_Football extends Model
{
    protected $table = 'sport.tb_tournplayers_football';

    public function scopeHasMVPDefenders($query) {
        $query->where('mvpdefenders','>',0);
    }
}
