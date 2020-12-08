<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    protected $table = 'site.news';
    public $timestamps = true;
    //protected $dateFormat = "Y-m-d H:i:s";

    /**
     * Неудалённые новсти
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    /**
     * видимые новости
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }

    /**
     * Новости не на главной
     * @param $query
     * @return mixed
     */
    public function scopeNoTop($query)
    {
        return $query->where('top', 0);
    }

    /**
     * Новости закреплённые
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query->where('top', 1);
    }

    /**
     * Новости на главной
     * @param $query
     * @return mixed
     */
    public function scopeHead($query)
    {
        return $query->where('head', 1);
    }

    public function scopeNoHead($query)
    {
        return $query->where('head', 0);
    }

    /**
     * Выбрать новости все кроме текущей
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeNoCurrent($query, $url)
    {
        return $query->where('url', '<>', $url);
    }

    /**
     * выбрать по URL
     * @param $url
     */
    public function scopeURL($query, $url)
    {
        return $query->where('url', $url);
    }

    public function scopeCategoryNews($query, $cat)
    {
        return $query->where('cat_id', $cat);
    }

    public function category()
    {
        return $this->belongsTo('App\NewsCategory', 'cat_id', 'id');
    }
}
