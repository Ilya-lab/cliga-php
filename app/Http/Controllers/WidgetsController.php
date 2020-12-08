<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Sport\TournMatchesController;
use Illuminate\Http\Request;
use App\Sport\Tournaments;

class WidgetsController extends Controller
{
    public function tournaments() {
        $tourn = Tournaments::/*active()->*/tournament()->orderBy('finish')->get();
        return view('widgets.tournaments', [
            'tournaments' => $tourn,
        ]);
    }

    /**
     * Загрузить контент с таблицей в турнире
     */
    public function tournamentView(Request $request) {
        if(!$request->has('tourn_id')) return 'Ошибка загрузки соревнования';
        $matches = TournMatchesController::matches($request->input('tourn_id'));
        $tourn = Tournaments::find($request->input('tourn_id'));
        return view('widgets.ajax_tournament',[
            'prevMatches' => $matches->where('status_id',2)->take(7)->sortByDesc('datetime')->all(),
            'nextMatches' => $matches->where('status_id','<', 2)->take(7)->sortBy('datetime')->all(),
            'tournament'  => $tourn,
        ])->render();
    }
}
