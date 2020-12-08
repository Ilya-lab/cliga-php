<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournBids extends Model
{
    protected $table = 'sport.tb_tournbids';

    public function scopeTournament($query, $id) {
         $query->where('tourn_id', $id);
    }

    public function bidplayers() {
        return $this->hasMany('App\Sport\BidPlayer','bid_id','id');
    }
}
