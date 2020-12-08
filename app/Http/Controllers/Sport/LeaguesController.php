<?php

namespace App\Http\Controllers\Sport;

use App\Sport\Leagues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaguesController extends Controller
{
    public function all() {
        return Leagues::all();
    }
}
