<?php

namespace App\Images;

use Illuminate\Database\Eloquent\Model;

class Thumbs extends Model
{
    protected $table = 'images.tb_thumbs';
    public $timestamps = false;

    /*public function property()
    {
        return $this->belongsTo('App\Images\Images', 'image_id', 'id');
    }*/
}
