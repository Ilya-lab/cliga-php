<?php

namespace App\Http\Controllers\Sport;

use App\Sport\MatchEvents;
use App\Sport\MatchMembers;
use App\Http\Controllers\Controller;
use App\Sport\Person;
use App\Sport\Tournaments;
use App\Sport\TournPlayers;
use App\Sport\TournCoaches;
use Cache;
use DB;
use Log;

class TournPlayersController extends Controller
{
    /**
     * Вернуть запрос на получение текущих игроков команды в турнире за команду
     * @param $tourn - идентификатор турнира
     * @param $team - идентификатор команды в заявке на турнир
     * @return mixed
     */
    static public function players($tourn, $team) {
        return Cache::rememberForever('players_'.$tourn.'_'.$team, function () use ($tourn, $team) {
            return TournPlayers::select('sport.tb_tournplayers.*','sport.tb_bidplayer.*',
                'sport.tb_tournteams.name as team', 'sport.tb_tournteams.shortname as shortteamname',
                'sport.tb_tournteams.city as teamcity','sport.tb_tournplayers.id as tournplayer_id')->
            join('sport.tb_bidplayer', function ($join) {
                $join->on('sport.tb_bidplayer.bid_id', '=', 'sport.tb_tournplayers.currentbid_id')
                    ->on('sport.tb_bidplayer.person_id', '=', 'sport.tb_tournplayers.player_id');
            })
                ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','=','sport.tb_tournteams.id')
                ->with('position', 'captain','person')
                ->tourn($tourn)->where('sport.tb_bidplayer.team_id', $team)->get();
        });
    }

    /**
     * Вернуть запрос на получение Административных должностей команды
     * @param $tourn - идентификатор турнира
     * @param $team - идентификатор команды в заявке на турнир
     * @return mixed
     */
    static public function admins($tourn, $team) {
        return Cache::rememberForever('admins_'.$tourn.'_'.$team, function () use ($tourn, $team) {
            return TournCoaches::select('sport.tb_tourncoaches.*','sport.tb_bidcoach.*',
                'sport.tb_tournteams.name as team', 'sport.tb_tournteams.shortname as shortteamname',
                'sport.tb_tournteams.city as teamcity')->
            join('sport.tb_bidcoach', function ($join) {
                $join->on('sport.tb_bidcoach.bid_id', '=', 'sport.tb_tourncoaches.currentbid_id')
                    ->on('sport.tb_bidcoach.person_id', '=', 'sport.tb_tourncoaches.coach_id');

            })
            ->join('sport.tb_tournteams','sport.tb_bidcoach.team_id','=','sport.tb_tournteams.id')
            ->with('post','person')
            ->tourn($tourn)->where('sport.tb_bidcoach.team_id', $team)->get();
        });
    }

    /**
     * Вернуть информацию об игроке в турнире
     * @param $tourn_id - идентификатор турнира
     * @param $person - идентификатор игрока
     * @param $type - тип персоны: 0 - игрок, 1 - представитель
     * @return mixed
     */
    static public function person($tourn, $person, $type) {
        if($type == 0)
            return TournPlayers::select('sport.tb_tournplayers.*','sport.tb_bidplayer.*',
                'sport.tb_tournteams.name as team', 'sport.tb_tournteams.shortname as shortteamname',
                'sport.tb_tournteams.city as teamcity', 'sport.tb_tournbids.name as bidname')->
                join('sport.tb_bidplayer', function ($join) {
                    $join->on('sport.tb_bidplayer.bid_id', '=', 'sport.tb_tournplayers.currentbid_id')
                        ->on('sport.tb_bidplayer.person_id', '=', 'sport.tb_tournplayers.player_id');
                })
                ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','=','sport.tb_tournteams.id')
                ->join('sport.tb_tournbids','sport.tb_tournplayers.currentbid_id','=','sport.tb_tournbids.id')
                ->with(['position', 'captain','person','bid' => function($query) use ($person) {
                    $query->where('person_id', $person)->with(['photo' => function($query) {
                        $query->with('thumb');
                    }]);
                }])
                ->tourn($tourn)->where('sport.tb_bidplayer.person_id', $person)->get();

        return TournCoaches::select('sport.tb_tourncoaches.*','sport.tb_bidcoach.*',
            'sport.tb_tournteams.name as team', 'sport.tb_tournteams.shortname as shortteamname',
            'sport.tb_tournteams.city as teamcity')->
            join('sport.tb_bidcoach', function ($join) {
                $join->on('sport.tb_bidcoach.bid_id', '=', 'sport.tb_tourncoaches.currentbid_id')
                    ->on('sport.tb_bidcoach.person_id', '=', 'sport.tb_tourncoaches.coach_id');
            })
            ->join('sport.tb_tournteams','sport.tb_bidcoach.team_id','=','sport.tb_tournteams.id')
            ->with('position', 'captain','person')
            ->tourn($tourn)->where('sport.tb_bidcoach.person_id', $person)->get();
    }

    /**
     * Состав команды на игру
     * @param $match_id - идентификатор матча
     * @param $team - идентификатор команды в соревновании
     * @return mixed
     */
    static public function playersMatchTeam($match_id, $team) {
       // return Cache::rememberForever('players_match_'.$match_id.'_'.$team, function () use ($match_id, $team) {
            return MatchMembers::select('sport.tb_matchmembers.*','sport.tb_bidplayer.family','sport.tb_bidplayer.name',
                'classif.tk_position.name as position_name', 'classif.tk_position.shortname as position_shortname', 'classif.tk_position.id as position_id')
                ->with(['playerInfo' => function($query) {
                    $query->with(['bid' => function($query) {
                        $query->with(['photo' => function($query) {
                            $query->with('thumb');
                        }]);
                    }]);
                }])
                ->join('sport.tb_tournplayers', 'sport.tb_tournplayers.id','sport.tb_matchmembers.player_id')
                ->join('sport.tb_bidplayer', function ($join) {
                    $join->on('sport.tb_bidplayer.bid_id', '=', 'sport.tb_tournplayers.lastbid_id')
                        ->on('sport.tb_bidplayer.person_id', '=', 'sport.tb_tournplayers.player_id');
                    //$join('sport.tb_bidplayer','sport.tb_bidplayer.position_id','classif.tk_position.id');
                })
                ->join('classif.tk_position','sport.tb_bidplayer.position_id','classif.tk_position.id')
                ->where('sport.tb_matchmembers.match_id', $match_id)->where('sport.tb_matchmembers.team_id', $team)
                ->orderBy('is_goalkeeper', 'DESC')
                ->orderBy('position_id', 'ASC')
                ->orderBy('number', 'ASC')
                ->orderBy('family')
                ->orderBy('name')
                ->get();
     //   });
    }

    /**
     * Вернуть события матча
     * @param $match_id - идентификтаор матча
     */
    static public function eventsMatch($match_id) {
        //return Cache::rememberForever('events_match_'.$match_id, function () use ($match_id) {
            return MatchEvents::select('sport.tb_matchevents.*','b1.family','b1.name','m1.number',
                'b2.family as assist_family','b2.name as assist_name','m2.number as assist_number',
                'b3.family as gk_family','b3.name as gk_name','m3.number as gk_number',
                'classif.tk_events.shortname as eventname')
                ->join('sport.tb_tournplayers as t1', 't1.id','sport.tb_matchevents.player_id')
                ->join('sport.tb_bidplayer as b1', function ($join) {
                    $join->on('b1.bid_id', '=', 't1.lastbid_id')
                        ->on('b1.person_id', '=', 't1.player_id');
                })
                ->join('sport.tb_matchmembers as m1', function ($join) {
                    $join->on('m1.player_id', '=', 't1.id')
                         ->on('m1.match_id', '=', 'sport.tb_matchevents.match_id');
                })
                ->join('classif.tk_events','classif.tk_events.id','sport.tb_matchevents.event_id')
                //->leftJoin('sport.tb_tournplayers', 'sport.tb_tournplayers.id','sport.tb_matchevents.assistant_id')
                /*->with(['assist' => function($query) {
                    $query->select('*');//->join->on('sport.tb_bidplayer.bid_id', '=', 'lastbid_id')
                        //->on('sport.tb_bidplayer.person_id', '=', 'assist_id');
                    //->join('sport.tb_tournplayers as t2', 't2.id','sport.tb_matchevents.assistant_id');
                }])*/
                ->leftJoin('sport.tb_tournplayers as t2', 't2.id','sport.tb_matchevents.assist_id')
                ->leftJoin('sport.tb_bidplayer as b2', function ($join) {
                    $join->on('b2.bid_id', '=', 't2.lastbid_id')
                        ->on('b2.person_id', '=', 't2.player_id');
                })
                ->leftJoin('sport.tb_matchmembers as m2', function ($join) {
                    $join->on('m2.player_id', '=', 't2.id')
                        ->on('m2.match_id', '=', 'sport.tb_matchevents.match_id');
                })
                ->leftJoin('sport.tb_tournplayers as t3', 't3.id','sport.tb_matchevents.opponent_id')
                ->leftJoin('sport.tb_bidplayer as b3', function ($join) {
                    $join->on('b3.bid_id', '=', 't3.lastbid_id')
                        ->on('b3.person_id', '=', 't3.player_id');
                })
                ->leftJoin('sport.tb_matchmembers as m3', function ($join) {
                    $join->on('m3.player_id', '=', 't3.id')
                        ->on('m3.match_id', '=', 'sport.tb_matchevents.match_id');
                })
                /*->join('sport.tb_bidplayer t2', function ($join) {
                    $join->on('sport.tb_bidplayer.bid_id', '=', 'sport.tb_tournplayers.lastbid_id')
                        ->on('sport.tb_bidplayer.person_id', '=', 'sport.tb_tournplayers.player_id');
                })*/
                ->where('sport.tb_matchevents.match_id', $match_id)
                ->orderBy('minute', 'DESC')
                ->orderBy('m1.number', 'ASC')
                ->orderBy('b1.family')
                ->orderBy('b1.name')
                ->get();;
        //});
    }

    /**
     * Возвращает лучших игроков чемпионата
     * @param $tourn_id - идентификатор турнира
     * @param int $type - тип лучшего игрока:
     * 0 - нападающий
     * 1 - ассистент
     * 2 - гол + пас
     */
    static public function topPlayers($tourn_id, $type = 0)
    {
        //return Cache::rememberForever('topplayers_'.$tourn_id.'_type_'.$type, function () use ($tourn_id, $type) {
           /* $ret = TournPlayers::select('sport.tb_tournplayers.player_id as id', 'b1.family','b1.name','b1.surname','b1.number','sport.tb_tournplayers.goals','sport.tb_tournplayers.assists', DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'sport.tb_tournplayers.games','sport.tb_tournteams.name as teamname', 'sport.tb_tournteams.url as teamurl','sport.tb_person.url', 'b1.team_id as team_id', 'sport.tb_tournteams.shortname as teamshortname', 'classif.tk_position.name as positionname','sport.tb_tournplayers.lastbid_id', 'images.tb_thumbs.filename')
                ->join('sport.tb_bidplayer as b1', function ($join) {
                    $join->on('b1.bid_id', '=', 'lastbid_id')
                        ->on('b1.person_id', '=', 'sport.tb_tournplayers.player_id');
                })
                ->join('sport.tb_tournteams','sport.tb_tournteams.id','b1.team_id')
                ->join('classif.tk_position','classif.tk_position.id','b1.position_id')
                ->join('sport.tb_person','sport.tb_person.id','b1.person_id')
                ->leftJoin('images.tb_images','images.tb_images.id','b1.photo_id')
                ->leftJoin('images.tb_thumbs','images.tb_thumbs.image_id','images.tb_images.id')
                ->where(function ($query) {
                    $query->where('images.tb_thumbs.thumb_id',9)
                        ->orWhere('b1.photo_id',0);
                })
                ->where('sport.tb_tournplayers.tourn_id', $tourn_id);*/
           $ret = TournPlayers::with(['bid' => function($query) {
               $query->with([
                   'position',
                   'captain',
                   'person' => function($query) {
                        $query->select('id','url', 'birthdate', DB::raw('date_part(\'year\',age(birthdate)) as age'));
                   },
                   'team' => function($query) {
                        $query->with([
                            'logo' => function($query) {
                                $query->with('thumb')->select('id','object_id');
                            }
                        ])->select('id','name','shortname','city','url','logo_id');
                   },
                   'photo' => function($query) {
                        $query->with('thumb');
                   }
               ]);
           }, 'lastbid'])->select('id','player_id','currentbid_id','games','assists','goals',DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'minutes','win_team','los_team','draw_team','goal_team','prop_team','lastbid_id')
               ->tourn($tourn_id);
            switch ($type) {
                case 0: {$ret = $ret->orderByDesc('goals')->orderBy('games')->orderByDesc('win_team')->where('goals','>',0); break;}
                case 1: {$ret = $ret->orderByDesc('assists')->orderBy('games')->orderByDesc('win_team')->where('assists','>',0); break;}
                case 2: {$ret = $ret->orderByDesc('goalpass')->orderBy('games')->orderByDesc('win_team')->where('goals','>',0)->where('assists','>',0); break;}
            }
            //$ret = $ret->orderBy('b1.family')->orderBy('b1.name');
            return $ret->get();
        //});
    }

    /**
     * Показать лучших ассистентов
     * @param $tourn_id
     */
    static public function topAssistants($tourn_id) {
        return TournPlayersController::topPlayers($tourn_id, 1);
    }

    /**
     * Показать лучших по гол + пас
     * @param $tourn_id - идентификатор туринра
     * @return mixed
     */
    static public function topBombardirs($tourn_id) {
        return TournPlayersController::topPlayers($tourn_id, 2);
    }

    /**
     * Показать лучших защитников турнира
     * @param $tourn_id - идентификатор турнира
     * @return mixed
     */
    static public function topDefenders($tourn_id)
    {
        //return Cache::rememberForever('topplayers_'.$tourn_id.'_type_3', function () use ($tourn_id, $type) {
        Log::info('Загрузка лучших игроков турнира - '.$tourn_id);
        $tourn = Tournaments::findOrFail($tourn_id);

        if($tourn->sport_id <= 1) {
            /*$ret = TournPlayers::select('sport.tb_tournplayers.player_id as id', 'b1.family','b1.name','b1.surname','b1.number','sport.tb_tournplayers.games','sport.tb_tournplayers_football.mvpdefenders as points','sport.tb_tournteams.name as teamname', 'b1.team_id as team_id', 'sport.tb_tournteams.shortname as teamshortname', 'classif.tk_position.name as positionname','sport.tb_tournplayers.lastbid_id', 'images.tb_thumbs.filename')
                ->join('sport.tb_tournplayers_football','sport.tb_tournplayers.id','sport.tb_tournplayers_football.tournplayer_id')
                ->join('sport.tb_bidplayer as b1', function ($join) {
                    $join->on('b1.bid_id', '=', 'lastbid_id')
                        ->on('b1.person_id', '=', 'sport.tb_tournplayers.player_id');
                })
                ->join('sport.tb_tournteams','sport.tb_tournteams.id','b1.team_id')
                ->join('classif.tk_position','classif.tk_position.id','b1.position_id')
                ->leftJoin('images.tb_images','images.tb_images.id','b1.photo_id')
                ->leftJoin('images.tb_thumbs','images.tb_thumbs.image_id','images.tb_images.id')
                ->where(function ($query) {
                    $query->where('images.tb_thumbs.thumb_id',9)
                        ->orWhere('b1.photo_id',0);
                })
                ->where('sport.tb_tournplayers.tourn_id', $tourn_id);
            $ret = $ret->orderByDesc('points')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.mvpdefenders','>',0);
            $ret = $ret->orderBy('b1.family')->orderBy('b1.name');*/
            $ret = TournPlayers::with(['football','bid' => function($query) {
                $query->with([
                    'position',
                    'captain',
                    'person' => function($query) {
                        $query->select('id','url', 'birthdate', DB::raw('date_part(\'year\',age(birthdate)) as age'));
                    },
                    'team' => function($query) {
                        $query->with([
                            'logo' => function($query) {
                                $query->with('thumb')->select('id','object_id');
                            }
                        ])->select('id','name','shortname','city','url','logo_id');
                    },
                    'photo' => function($query) {
                        $query->with('thumb');
                    }
                ]);
            }, 'lastbid'])->leftjoin('sport.tb_tournplayers_football', 'id','=','tournplayer_id')
                ->select('id','player_id','currentbid_id','games','assists','goals',DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'minutes','win_team','los_team','draw_team','goal_team','prop_team','lastbid_id')
                ->tourn($tourn_id)->orderByDesc('mvpdefenders')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.mvpdefenders','>',0);
            return $ret->get();
        }
        return collect();
        //});
    }

    /**
     * Вернуть топ игроков, т.е. тех игроков, которые больше всего были выбраны лучшими в матче
     * @param $tourn_id
     * @return \Illuminate\Support\Collection
     */
    static public function topBestPlayers($tourn_id)
    {
        //return Cache::rememberForever('topplayers_'.$tourn_id.'_type_4', function () use ($tourn_id) {
        $tourn = Tournaments::findOrFail($tourn_id);

        if($tourn->sport_id <= 1) {
            /*$ret = TournPlayers::select('sport.tb_tournplayers.player_id as id', 'b1.family','b1.name','b1.surname','b1.number','sport.tb_tournplayers.games','sport.tb_tournplayers_football.bests as points','sport.tb_tournteams.name as teamname', 'b1.team_id as team_id', 'sport.tb_tournteams.shortname as teamshortname', 'classif.tk_position.name as positionname','sport.tb_tournplayers.lastbid_id', 'images.tb_thumbs.filename')
                ->join('sport.tb_tournplayers_football','sport.tb_tournplayers.id','sport.tb_tournplayers_football.tournplayer_id')
                ->join('sport.tb_bidplayer as b1', function ($join) {
                    $join->on('b1.bid_id', '=', 'lastbid_id')
                        ->on('b1.person_id', '=', 'sport.tb_tournplayers.player_id');
                })
                ->join('sport.tb_tournteams','sport.tb_tournteams.id','b1.team_id')
                ->join('classif.tk_position','classif.tk_position.id','b1.position_id')
                ->leftJoin('images.tb_images','images.tb_images.id','b1.photo_id')
                ->leftJoin('images.tb_thumbs','images.tb_thumbs.image_id','images.tb_images.id')
                ->where(function ($query) {
                    $query->where('images.tb_thumbs.thumb_id',9)
                        ->orWhere('b1.photo_id',0);
                })
                ->where('sport.tb_tournplayers.tourn_id', $tourn_id);
            $ret = $ret->orderByDesc('points')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.bests','>',0);
            $ret = $ret->orderBy('b1.family')->orderBy('b1.name');
            return $ret->get();*/
            $ret = TournPlayers::with(['football','bid' => function($query) {
                $query->with([
                    'position',
                    'captain',
                    'person' => function($query) {
                        $query->select('id','url', 'birthdate', DB::raw('date_part(\'year\',age(birthdate)) as age'));
                    },
                    'team' => function($query) {
                        $query->with([
                            'logo' => function($query) {
                                $query->with('thumb')->select('id','object_id');
                            }
                        ])->select('id','name','shortname','city','url','logo_id');
                    },
                    'photo' => function($query) {
                        $query->with('thumb');
                    }
                ]);
            }, 'lastbid'])->leftjoin('sport.tb_tournplayers_football', 'id','=','tournplayer_id')
                ->select('id','player_id','currentbid_id','games','assists','goals',DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'minutes','win_team','los_team','draw_team','goal_team','prop_team','lastbid_id')
                ->tourn($tourn_id)->orderByDesc('bests')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.bests','>',0);
            return $ret->get();
        }
        return collect();
        //});
    }

    public static function topBestGoalkeepers($tourn_id) {
        //return Cache::rememberForever('topplayers_'.$tourn_id.'_type_5', function () use ($tourn_id) {
        $tourn = Tournaments::findOrFail($tourn_id);

        if($tourn->sport_id <= 1) {
            /*$ret = TournPlayers::select('sport.tb_tournplayers.player_id as id', 'b1.family','b1.name','b1.surname','b1.number','sport.tb_tournplayers.games','sport.tb_tournplayers_football.bests as points','sport.tb_tournteams.name as teamname', 'b1.team_id as team_id', 'sport.tb_tournteams.shortname as teamshortname', 'classif.tk_position.name as positionname','sport.tb_tournplayers.lastbid_id', 'images.tb_thumbs.filename')
                ->join('sport.tb_tournplayers_football','sport.tb_tournplayers.id','sport.tb_tournplayers_football.tournplayer_id')
                ->join('sport.tb_bidplayer as b1', function ($join) {
                    $join->on('b1.bid_id', '=', 'lastbid_id')
                        ->on('b1.person_id', '=', 'sport.tb_tournplayers.player_id');
                })
                ->join('sport.tb_tournteams','sport.tb_tournteams.id','b1.team_id')
                ->join('classif.tk_position','classif.tk_position.id','b1.position_id')
                ->leftJoin('images.tb_images','images.tb_images.id','b1.photo_id')
                ->leftJoin('images.tb_thumbs','images.tb_thumbs.image_id','images.tb_images.id')
                ->where(function ($query) {
                    $query->where('images.tb_thumbs.thumb_id',9)
                        ->orWhere('b1.photo_id',0);
                })
                ->where('sport.tb_tournplayers.tourn_id', $tourn_id);
            $ret = $ret->orderByDesc('points')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.bests','>',0);
            $ret = $ret->orderBy('b1.family')->orderBy('b1.name');
            return $ret->get();*/
            $ret = TournPlayers::with(['football','bid' => function($query) {
                $query->with([
                    'position',
                    'captain',
                    'person' => function($query) {
                        $query->select('id','url', 'birthdate', DB::raw('date_part(\'year\',age(birthdate)) as age'));
                    },
                    'team' => function($query) {
                        $query->with([
                            'logo' => function($query) {
                                $query->with('thumb')->select('id','object_id');
                            }
                        ])->select('id','name','shortname','city','url','logo_id');
                    },
                    'photo' => function($query) {
                        $query->with('thumb');
                    }
                ]);
            }, 'lastbid'])->leftjoin('sport.tb_tournplayers_football', 'id','=','tournplayer_id')
                ->select('id','player_id','currentbid_id','games','assists','goals',DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'minutes','win_team','los_team','draw_team','goal_team','prop_team','lastbid_id')
                ->tourn($tourn_id)->orderByDesc('shoutout_gk')->orderBy('games_gk')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.shoutout_gk','>',0);
            return $ret->get();
        }
        return collect();
        //});
    }

    /**
     * ЖК турнира
     * @param $tourn - идентификтатор турнира
     */
    public static function yellowCards($tourn_id) {
        //return Cache::rememberForever('topplayers_'.$tourn_id.'_type_6', function () use ($tourn_id) {
        $tourn = Tournaments::findOrFail($tourn_id);

        if($tourn->sport_id <= 1) {
            $ret = TournPlayers::with(['football','bid' => function($query) {
                $query->with([
                    'position',
                    'captain',
                    'person' => function($query) {
                        $query->select('id','url', 'birthdate', DB::raw('date_part(\'year\',age(birthdate)) as age'));
                    },
                    'team' => function($query) {
                        $query->with([
                            'logo' => function($query) {
                                $query->with('thumb')->select('id','object_id');
                            }
                        ])->select('id','name','shortname','city','url','logo_id');
                    },
                    'photo' => function($query) {
                        $query->with('thumb');
                    }
                ]);
            }, 'lastbid'])->leftjoin('sport.tb_tournplayers_football', 'id','=','tournplayer_id')
                ->select('id','player_id','currentbid_id','games','assists','goals',DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'minutes','win_team','los_team','draw_team','goal_team','prop_team','lastbid_id')
                ->tourn($tourn_id)->orderByDesc('yellowcards')->orderBy('games_gk')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.yellowcards','>',0);
            return $ret->get();
        }
        return collect();
        //});
    }

    /**
     * Красные карточки
     * @param $tourn_id - идентификатор турнира
     * @return \Illuminate\Support\Collection
     */
    public static function redCards($tourn_id) {
        //return Cache::rememberForever('topplayers_'.$tourn_id.'_type_7', function () use ($tourn_id) {
        $tourn = Tournaments::findOrFail($tourn_id);

        if($tourn->sport_id <= 1) {
            $ret = TournPlayers::with(['football','bid' => function($query) {
                $query->with([
                    'position',
                    'captain',
                    'person' => function($query) {
                        $query->select('id','url', 'birthdate', DB::raw('date_part(\'year\',age(birthdate)) as age'));
                    },
                    'team' => function($query) {
                        $query->with([
                            'logo' => function($query) {
                                $query->with('thumb')->select('id','object_id');
                            }
                        ])->select('id','name','shortname','city','url','logo_id');
                    },
                    'photo' => function($query) {
                        $query->with('thumb');
                    }
                ]);
            }, 'lastbid'])->leftjoin('sport.tb_tournplayers_football', 'id','=','tournplayer_id')
                ->select('id','player_id','currentbid_id','games','assists','goals',DB::raw('sport.tb_tournplayers.goals + sport.tb_tournplayers.assists as goalpass'),'minutes','win_team','los_team','draw_team','goal_team','prop_team','lastbid_id')
                ->tourn($tourn_id)->orderByDesc('redcards')->orderBy('games_gk')->orderBy('games')->orderByDesc('win_team')->where('sport.tb_tournplayers_football.redcards','>',0);
            return $ret->get();
        }
        return collect();
        //});
    }

    public static function getPlayer($url) {

        $players = Person::URL($url)->get();
        foreach ($players as $player) {
            return $player;
        }
        return null;
    }

    /**
     * Показать игрока в турнире
     */
    public function show($url, $url_player)
    {
        $tourn = TournamentController::getTournament($url);
        if($tourn == null) abort(404);

        $person = TournPlayersController::getPlayer($url_player);
        $player = TournPlayersController::person($tourn->id, $person->id, 0)->first();
        if($player == null) abort(404);

        return view('tournament.player', ['player' => $player]);
    }
}
