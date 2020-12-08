<?php

namespace App\Http\Controllers\Sport;

use App\Sport\Seasons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;

class SeasonsController extends Controller
{
    /**
     * Все сезоны
     * @return mixed
     */
    public function seasons() {
        return Seasons::orderBy('sport.tb_seasons.finish')->get();
    }

    /**
     * Выбрать сезоны за лигу
     * @param $id - идентификатор лиги
     * @return mixed
     */
    public static function league($id) {
        return Cache::rememberForever('seasons_league_'.$id, function () use ($id) {
            return Seasons::join('sport.tb_tournaments', 'sport.tb_seasons.id', 'sport.tb_tournaments.season_id')
                ->join('sport.tb_tournlist', 'sport.tb_tournaments.tournament_id', 'sport.tb_tournlist.id')->
                select('sport.tb_seasons.*')->
                where('sport.tb_tournlist.league_id', $id)->distinct()->orderBy('sport.tb_seasons.finish')->get();
        });
    }
}
