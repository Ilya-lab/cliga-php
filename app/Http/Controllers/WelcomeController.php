<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Sport\TournamentController;
use App\Http\Controllers\Sport\TournMatchesController;
use App\Http\Controllers\Sport\SeasonsController;
use App\Http\Controllers\Sport\TournPlayersController;
use App\Sport\TournMatches;
use Illuminate\Http\Request;
use App\Menu;

class WelcomeController extends Controller
{
    /**
     * Главная страница
     */
    public function index() {

        $tournaments = TournamentController::tournamentsSeasonSport(1,1,11);
        $currentTournamentId = 0;
        $currentTournament = null;
        foreach ($tournaments as $tournament) {
            if($tournament->id == 403) {
                $currentTournamentId = 403;//$tournament->id;
                $currentTournament = $tournament;
                break;
            }
        }
        $players = array();
        $players['forwards'] = TournPlayersController::topPlayers($currentTournamentId);
        $players['assistants'] = TournPlayersController::topAssistants($currentTournamentId);
        $players['bombardirs'] = TournPlayersController::topBombardirs($currentTournamentId);
        $players['defenders'] = TournPlayersController::topDefenders($currentTournamentId);
        $players['bestPlayers'] = TournPlayersController::topBestPlayers($currentTournamentId);
        //return $players['forwards'];

        //return TournMatchesController::matches($currentTournamentId, 0, true);
        return view('welcome', [
            'sports' => TournamentController::sports(),
            'seasons' => SeasonsController::league(1),
            'currentSeason' => 11,
            'tournaments' => $tournaments,
            'tournament' => $currentTournament,
            'table' => TournamentController::format($currentTournament),
            'currentTournament' => $currentTournamentId,
            'matches' => TournMatchesController::matches($currentTournamentId, 0, true),
            'players' => $players,
            'news' =>  NewsController::main(),
        ]);
    }

    static public function menu() {
        return Menu::with(['child' => function($query) {
            $query->orderBy('priority');
        }])
            ->main()->orderBy('priority')->get();
    }

    public function redirect($to) {
        switch ($to) {
            case "vk": {
                return redirect('https://vk.com/corliga');
                break;
             };
            case "youtube": {
                return redirect('https://www.youtube.com/channel/UCoDhQy4pEeOOCxcxQTzjBTQ');
                break;
            };
            case "instagram": {
                return redirect('https://instagram.com/corliga');
                break;
            };
            case "whatsapp": {
                return redirect('https://api.whatsapp.com/send?phone=79031497232');
                break;
            }
        }
    }
}
