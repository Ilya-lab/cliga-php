<?php

namespace App\Images;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'images.tb_images';
    public $timestamps = false;

    /**
     * Все обрезанные изображения
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thumb()
    {
        return $this->hasMany('App\Images\Thumbs', 'image_id', 'id');
    }

    public function thumbOne()
    {
        return $this->hasOne('App\Images\Thumbs', 'image_id', 'id');
    }
}
