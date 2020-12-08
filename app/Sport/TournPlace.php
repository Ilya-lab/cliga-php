<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournPlace extends Model
{
    protected $table = 'sport.tb_tournplace';

    public function scopeTournament($query, $tourn_id) {
        $query->where('sport.tb_tournplace.tourn_id', $tourn_id);
    }
}
