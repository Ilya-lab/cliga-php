<?php

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'sport.tb_person';
    public $timestamps = false;

    /*protected $casts = [
       // 'email' => 'json',
        'phone' => 'json'
    ];*/

    /*
     * активный ли пользователь */
    public function scopeActive($query) {
        return $query->where('active', TRUE);
    }

    public function scopeNoactive($query) {
        return $query->where('active', FALSE);
    }

    /*public function scopeSex($query, $sex) {
        return $query->where('sex_id', $sex);
    }*/

    public function scopeStartWith($query, $text)
    {
        return $query->where('fio', 'ILIKE', $text.'%');
    }

    public function scopeURL($query, $text)
    {
        return $query->where('url', $text);
    }

    public function country()
    {
        return $this->belongsTo('App\Classif\Country', 'country_id', 'id');
    }

    public function photo()
    {
        return $this->belongsTo('App\Images\Images', 'photo_id', 'id');
        //return $this->hasMany('App\Images\Images', 'photo_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany('App\Images\Images', 'object_id', 'id');
    }

    public function sex()
    {
        return $this->belongsTo('App\Classif\Sex', 'sex_id', 'id');
    }
}
