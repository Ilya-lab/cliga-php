<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocApiController extends Controller
{
    public function index() {return view('api.index');}

    public function sports() {return view('api.sports');}

    public function leagues() {return view('api.leagues');}

    public function tournaments() {return view('api.tournaments');}
    public function tournamentsAll() {return view('api.tournaments_all');}
    public function tournamentsSeasonSport() {return view('api.tournaments_sportseason');}
    public function tournamentsTeams() {return view('api.tournaments_teams');}
    public function tournamentsStages() {return view('api.tournaments_stages');}
    public function tournamentsStruct() {return view('api.tournaments_struct');}
    public function tournamentsTable() {return view('api.tournaments_table');}
    public function tournamentsPlace() {return view('api.tournaments_place');}

    public function seasons() {return view('api.seasons');}
    public function seasonsAll() {return view('api.seasons_all');}
    public function seasonsLeague() {return view('api.seasons_league');}

    public function matches() {return view('api.matches');}
    public function lastfirst() {return view('api.matches_lastfirst');}
}
