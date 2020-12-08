<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'site.menu';
    public $timestamps = false;

    public function scopeMain($query) {
        $query->whereNull('parent_id');
    }

    public function child()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }
}
