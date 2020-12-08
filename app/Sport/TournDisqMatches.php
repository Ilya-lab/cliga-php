<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class TournDisqMatches extends Model
{
    protected $table = 'sport.tb_tourndisq_matches';

    public function scopeDisq($query, $disq_id)
    {
        $query->where('disq_id', $disq_id);
    }
}
