<?php

namespace App\Sport;

use App\Classif\Settings;
use Illuminate\Database\Eloquent\Model;

class TournSettings extends Model
{
    protected $table = 'sport.tb_tournsettings';
    //protected $primaryKey = 'flight_id';

    /**
     * Ссылка на настройки
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function settings()
    {
        return $this->belongsTo('App\Classif\Settings', 'key_id', 'key');
    }

    /**
     * Показать настройки за чемпионат
     * @param $query
     * @param $tourn_id - идентификатор соревнования
     */
    public function scopeTournament($query, $tourn_id) {
        $query->where('tourn_id', $tourn_id);
    }

    /**
     * Показать настройку
     * @param $query
     * @param $key_id - ключ настройки
     */
    public function scopeKey($query, $key_id) {
        $query->where('key_id', $key_id);
    }

    /**
     * Возвращает настройку, если за турнир настройки нет, то
     * будет возвращено значение поумолчании.
     * Если будет возвращено NULL, значит настройка не существует в принципе.
     * @param $tourn_id - идентификатор турнира
     * @param $key - ключ настройки.
     */
    static public function setting($tourn_id, $key) {

        $result = Settings::find($key);
        if(!$result) return null;

        $st = TournSettings::tournament($tourn_id)->key($key)->get();
        foreach ($st as $setting) {
            return $setting->value;
        }
        return $result->default;
    }
}
