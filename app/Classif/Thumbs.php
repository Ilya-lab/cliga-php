<?php

namespace App\Classif;

use Illuminate\Database\Eloquent\Model;

class Thumbs extends Model
{
    protected $table = 'classif.tk_thumbs';

    public function scopeTypeImage($query, $type)
    {
        return $query->where('imagetype_id', $type);
    }
}
