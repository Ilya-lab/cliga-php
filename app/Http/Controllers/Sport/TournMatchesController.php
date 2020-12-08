<?php

namespace App\Http\Controllers\Sport;

use App\Classif\CardReasons;
use App\Classif\ColorForms;
use App\Classif\Settings;
use App\Classif\Tours;
use App\Sport\BidArena;
use App\Sport\MatchEvents;
use App\Sport\Stage;
use App\Sport\Tournaments;
use App\Sport\TournMatches;
use App\Sport\TournMatches_Football;
use App\Sport\TournSettings;
use App\Sport\TournTeams;
use App\Sport\MatchMembers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Auth;
use Carbon\Carbon;
use Cache;
use DB;

class TournMatchesController extends Controller
{

    /**
     * Показать все матчи чемпионата
     * @param $id - идентификатор чемпионата
     */
    public function adminIndex($id) {
        // проверка прав доступа
        $closed = TournamentController::isClosed($id);
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2) ) {
            Log::error('Отсутствуют права доступа к соревнованию-'.$id.' от пользователя-'.Auth::user()->id);
            $closed = true;
            abort(403);
        }
        // от проверки прав доступа

        $tournament = Tournaments::findOrFail($id);

        // построение дерева этапов
        //$stages = Stage::tourn($id)->main()->with('child')->orderBy('priority')->get();

        $stages = TournMatchesController::mainStagesWithMatches($id);
        $stagesFinish = TournMatchesController::mainStagesWithMatches($id, false);
        //return $stages;
        $arena = BidArena::join('sport.tb_tournbids','sport.tb_tournbids.id','sport.tb_bidarena.bid_id')->
            with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name');
                }])->select('id','arena_id', 'name')->orderBy('number');
            }])->select('sport.tb_bidarena.id as id','field_id')->where('tourn_id',$id)->orderBy('team_id')->get();
        //return $arena;

        return view('home.tournament.calendar', [
            'stages' => $stages,
            'stagesFinish' => $stagesFinish,
            'tournament' => $tournament,
            'roles' => $roles,
            'closed' => $closed,
            'tours' => Tours::noFriendly()->orderBy('id')->get(),
            'teams' => $teams = TournTeams::with(['logo' => function($query) {
                                    $query->select('id','type_id')->with('thumb');
                                }])->tournament($id)->orderBy('name')->orderBy('city')->get(),
            'arenas' => $arena,
        ]);
    }

    public function lentaMatches($championats) {
        return TournMatchesController::lenta(explode(',', $championats));
    }

    /**
     * Загрузить в ленту
     * @param $championats - массив идентификаторов турниров
     * @param int $tournament - идентификатор типа соревнования
     * @param int $limit_start - количество предстоящих матчей
     * @param int $limit_finish - количество оконченных матчей
     * @return mixed
     */
    static public function lenta($championats, $tournament = 1, $limit_start = 50, $limit_finish = 50) {
        return Cache::rememberForever('lentamatches_'.implode(',', $championats), function () use ($championats, $tournament, $limit_start, $limit_finish) {
            return DB::select('SELECT * FROM sport.match_lenta(?,?,?,?)', array('{' . implode(',', $championats) . '}', $tournament, $limit_start, $limit_finish));
        });
    }

    /**
     * Загрузить в ленту
     * @param int $tournament - идентификатор типа соревнования
     * @param int $limit_start - количество предстоящих матчей
     * @param int $limit_finish - количество оконченных матчей
     * @return mixed
     */
    static public function lenta_openedTournament($tournament = 1, $limit_start = 50, $limit_finish = 50) {
       // return Cache::rememberForever('lentamatches_'.implode(',', $championats), function () use ($championats, $tournament, $limit_start, $limit_finish) {
            return DB::select('SELECT * FROM sport.match_lenta_noclosed(?,?,?)', array($tournament, $limit_start, $limit_finish));
        //});
    }

    /**
     * Вернуть ленту по всем видам спорта
     * @param int $limit
     * @return mixed
     */
    static public function lentaAllSport($limit = 20) {
        //return Cache::rememberForever('lentaallsport', function () use ($id) {

        $ret = TournMatches::select('sport.tb_tournmatches.*')
            ->join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
            ->with(['status','home' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with(['thumb' => function ($query) {
                        //$query->where('thumb_id',5);
                    }]);
                }, 'team' => function($query) {
                    $query->with(['maincolor','color']);
                }]);
            }, 'away' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with(['thumb' => function ($query) {
                        //$query->where('thumb_id',5);
                    }]);
                }, 'team' => function($query) {
                    $query->with(['maincolor','color']);
                }]);
            }, 'tour', 'status', 'place' => function($query) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }]);
                }]);
            }, 'stage' => function($query) {
                $query->with('levels');
            }, 'mainstage' => function($query) {
                $query->with(['levels', 'tournament' => function($query) {
                    $query->with('sport');
                }]);
            }]);
        /*if($events) {
            $ret = $ret->with(['events' => function($query) {
                $query->with(['player' => function($query) {
                    $query->with('person');

                }])->orderBy('minute');
            }]);
        }*/

        // подключаю  футбол
        $ret = $ret->with(['football' => function($query) {

        }]);
        $ret = $ret->where('sport.tb_tournmatches.status_id',0)
            ->orderByDesc('datetime')
            ->orderBy('sport.tb_tournmatches.tour_id')
            ->orderBy('mainstage_id')
            ->limit($limit);
            //->get();

        $ret2 = TournMatches::select('sport.tb_tournmatches.*')
            ->join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
            ->with(['status','home' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with(['thumb' => function ($query) {
                        //$query->where('thumb_id',5);
                    }]);
                }, 'team' => function($query) {
                    $query->with(['maincolor','color']);
                }]);
            }, 'away' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with(['thumb' => function ($query) {
                        //$query->where('thumb_id',5);
                    }]);
                }, 'team' => function($query) {
                    $query->with(['maincolor','color']);
                }]);
            }, 'tour', 'status', 'place' => function($query) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }]);
                }]);
            }, 'stage' => function($query) {
                $query->with('levels');
            }, 'mainstage' => function($query) {
                $query->with(['levels', 'tournament' => function($query) {
                    $query->with('sport');
                } ]);
            }]);
        /*if($events) {
            $ret = $ret->with(['events' => function($query) {
                $query->with(['player' => function($query) {
                    $query->with('person');

                }])->orderBy('minute');
            }]);
        }*/

        // подключаю  футбол
        $ret2 = $ret2->with(['football' => function($query) {

        }]);
        $ret2 = $ret2->where('sport.tb_tournmatches.status_id','>',0)
            //->orderByDesc('status_id')
            ->orderByDesc('datetime')
            ->orderBy('sport.tb_tournmatches.tour_id')
            ->orderBy('mainstage_id')
            ->limit($limit);
            //->unionAll($ret)

        return $ret2->union($ret)->orderBy('datetime')->get();
        //});
    }

    /**
     * Загрузить матчи за период
     * @param $id - идентификатор периода
     */
    public function stageMatches($id) {
        return TournMatches::stage($id)->get();
    }

    /**
     * Вернуть главные этапы с матчами
     * @param $id
     */
    static public function mainStagesWithMatches($id, $noStarted = true) {
        if($noStarted) return Stage::select('id','name','shortname')->
            tourn($id)->main()->with(['matches' => function($query) {
                $query->with(['home', 'away', 'tour','stage', 'place' => function($query) {
                    $query->with(['field' => function($query) {
                        $query->with(['arena' => function($query) {
                            $query->select('id', 'name', 'url');
                        }]);
                    }]);
                }])->where('status_id','<',2)->orderBy('datetime')->orderBy('number');
        }/*,'child'*/ ])->orderBy('priority')->get();
        else return Stage::select('id','name','shortname')->
        tourn($id)->main()->with(['matches' => function($query) {
            $query->with(['home', 'away', 'tour','stage', 'place' => function($query) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name', 'url');
                    }]);
                }]);
            }])->where('status_id','>',1)->orderBy('datetime', 'DESC')->orderBy('number');
        }/*,'child'*/ ])->orderBy('priority')->get();
    }

    /**
     * Вернуть матчи команды в турнире
     * @param $id - идентификатор турнира
     * @param $team - идентификатор команды в турнире
     */
    static public function matchesTeam($id, $team) {
        //return Cache::rememberForever('matches_'.$id.'_team_'.$team, function () use ($id) {

        return TournMatches::select('sport.tb_tournmatches.*')->
        join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
            ->with(['home' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with(['thumbOne' => function ($query) {
                        $query->where('thumb_id',5);
                    }]);
                }]);
            }, 'away' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with(['thumb' => function ($query) {
                        $query->where('thumb_id',5);
                    }]);
                }]);
            }, 'tour', 'status', 'place' => function($query) use  ($id) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }]);
                }]);
            }, 'stage'])
            ->where('sport.tb_stage.tourn_id',$id)
            ->where(function($q) use($team) {
                return $q
                    ->where('home_id', $team)
                    ->orWhere('away_id', $team);
            })
            //->where('sport.tb_tournmatches.home_id',$team)
            //->orWhere('sport.tb_tournmatches.away_id',$team)
            ->orderBy('tour_id','datetime')
            ->orderBy('tour_id','tour_id')
            ->get();
        //});
    }


    /**
     * Вернуть все матчи в турнире
     * @param $id - идентификатор турнира
     * @sport_id - Идентификатор вида спорта
     * @events - признак для загрузки событий матча
     */
    static public function matches($id, $sport_id = 0, $events = false) {
        //return Cache::rememberForever('matches_'.$id, function () use ($id) {

           $ret = TournMatches::select('sport.tb_tournmatches.*')
                ->join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
                ->with(['status','home' => function($query) {
                    $query->with(['logo' => function($query) {
                        $query->with(['thumb' => function ($query) {
                            //$query->where('thumb_id',5);
                        }]);
                    }, 'team' => function($query) {
                            $query->with(['maincolor','color']);
                        }]);
                }, 'away' => function($query) {
                    $query->with(['logo' => function($query) {
                        $query->with(['thumb' => function ($query) {
                            //$query->where('thumb_id',5);
                        }]);
                    }, 'team' => function($query) {
                        $query->with(['maincolor','color','alt_maincolor','alt_color']);
                    }]);
                }, 'tour', 'status', 'place' => function($query) use  ($id) {
                    $query->with(['field' => function($query) {
                        $query->with(['arena' => function($query) {
                            $query->select('id', 'name');
                        }]);
                    }]);
                }, 'stage' => function($query) {
                    $query->with('levels');
                }]);
           if($events) {
               $ret = $ret->with(['events' => function($query) {
                   $query->with(['player' => function($query) {
                       $query->with('person');

                   }])->orderBy('minute');
               }]);
           }
           if($sport_id <= 1) {
               // если футбол
               $ret = $ret->with(['football' => function($query) {

               }]);
           }
           $ret = $ret->where('sport.tb_stage.tourn_id',$id)
                ->orderBy('sport.tb_tournmatches.tour_id')
                ->orderBy('datetime')
               ->orderBy('mainstage_id')
                ->get();
           return $ret;
        //});
    }

    static public function match($id) {
        return TournMatches::select('sport.tb_tournmatches.*','sport.tb_stage.name as stname','sport.tb_stage.shortname')
            ->join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
            ->with(['home' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with('thumb');
                }]);
            }, 'away' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with('thumb');
                }]);
            }, 'tour', 'status', 'place' => function($query) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }]);
                }]);
            }, 'stage'])
            ->find($id);
    }



    /**
     * Сохранить матч
     * @param $id - иднтифкикатор турнира
     * @param Request $request
     */
    public function save(Request $request) {
        Log::info('Сохранение нового матча от пользователя - '.Auth::user()->id);

        if (!$request->has("id") || !$request->has("stage") || !$request->has("number") || !$request->has("datetime")
            || !$request->has("tour") || !$request->has("arena") || !$request->has("home")
            || !$request->has("away")) {
            Log::error('Получены не все параметры от пользователя '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Добавление матча отменено.'));
        }

        $id = $request->input("id");
        $closed = TournamentController::isClosed($id);
        if($closed) {
            Log::error('Соревнование закрыто от пользователя - '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка сохранения матча. Турнир закрыт.'));
        }
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2) ) {
            Log::error('Отсутствуют права доступа к соревнованию-'.$id.' от пользователя-'.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Добавление матча отменено.'));
        }

        $match = new TournMatches;
        $match->stage_id = $request->input('stage');
        $match->arena_id = $request->input('arena');
        if($request->input('datetime')) $match->datetime = Carbon::createFromFormat('d.m.Y   H:i', $request->input('datetime'));
        else $match->datetime = null;
        $match->number = $request->input('number');
        $match->tour_id = $request->input('tour');
        $match->home_id = $request->input('home');
        $match->away_id = $request->input('away');
        $match->mainstage_id = $this->mainStage($match->stage_id);

        if($match->home_id == 0)  $match->home_id = null;
        if($match->away_id == 0)  $match->away_id = null;
        if($match->arena_id == 0) $match->arena_id = null;

        Log::info('Добавление матча:
                                                  stage-'.$match->stage_id.',
                                                  arena-'.$match->arena_id.',
                                                  datetime-'.$match->datetime.',
                                                  number-'.$match->number.',
                                                  tour-'.$match->tour_id.',
                                                  home-'.$match->home_id.',
                                                  away-'.$match->away_id.',
                                                  mainstage-'.$match->mainstage_id);
        try {
            $match->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Матч не был добавлен.'));
        }

        $addedMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($match->id);

        Cache::forget('matches_'.$id);  // очищаем кэш за матчи турнира

        return json_encode(array('status' => 'OK', 'text' => 'Матч добавлен!', 'match' => $addedMatch));
    }

    /**
     * Вернуть головной этап
     * @param $id - идентификатор этапа
     */
    private function mainStage($id) {
        $stage = Stage::find($id);
        if($stage !== null) {
            if($stage->parent_id == null) return $stage->id;
            return $this->mainStage($stage->parent_id);
        }
        return null;
    }

    /**
     * Удалить матч
     * @param Request $request
     * @return false|string
     */
    public function remove(Request $request)
    {
        if (!$request->has("id")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Удаления матча отменено.'));
        }

        $id = $request->input("id");
        Log::info('Удаления матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $removeMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($removeMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Удаления матча отменено.'));
        }

        $stage = Stage::find($removeMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Удаления матча отменено.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления матча. Турнир закрыт. Удаление матча отменено.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Удаление матча отменено.'));
        }

        if($removeMatch->status_id != 0) {
            Log::error('Матч или идёт или окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя удалить уже начавшийся матч и закончившийся. Удаление матча отменено.'));
        }

        try {
            $removeMatch->delete();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Матч не был удален. Удаление матча отменено.'));
        }

        Cache::forget('matches_'.$tourn_id);  // очищаем кэш за матчи турнира

        return json_encode(array('status' => 'OK', 'text' => 'Матч удален!','match' => $removeMatch));
    }

    /**
     * Вернуть окно с редактированием
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function editView(Request $request) {
        if (!$request->has("id")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Изменение матча отменено.'));
        }

        $id = $request->input("id");
        Log::info('Получение View для редактирования матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $editMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($editMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Изменение матча отменено.'));
        }

        $stage = Stage::find($editMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Изменение матча отменено.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Изменение матча отменено.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Изменение матча отменено.'));
        }

        if($editMatch->status_id != 0) {
            Log::error('Матч или идёт или окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя изменить уже начавшийся матч и закончившийся. Изменение матча отменено.'));
        }

        return json_encode(array('status' => 'OK', 'text' => view('home.tournament.ajax_edit',[
            'teams' => $teams = TournTeams::with(['logo' => function($query) {
                $query->select('id','type_id')->with('thumb');
            }])->tournament($tourn_id)->orderBy('name')->orderBy('city')->get(),
            'arenas' => BidArena::join('sport.tb_tournbids','sport.tb_tournbids.id','sport.tb_bidarena.bid_id')->
                with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }])->select('id','arena_id', 'name')->orderBy('number');
            }])->select('sport.tb_bidarena.id as id','field_id')->where('tourn_id',$tourn_id)->orderBy('team_id')->get(),
            'match' => $editMatch,
        ])->render(),'match' => $editMatch));
    }

    /**
     * Сохранить обновление
     * @param Request $request
     */
    public function update(Request $request) {
        if (!$request->has("id") || !$request->has("number") || !$request->has("datetime") || !$request->has("arena_id") || !$request->has("home_id") || !$request->has("away_id")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Изменение матча отменено.'));
        }

        $id = $request->input("id");
        Log::info('Обновление матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $editMatch = TournMatches::find($id);
        if ($editMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Изменение матча отменено.'));
        }

        $stage = Stage::find($editMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Изменение матча отменено.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Изменение матча отменено.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Изменение матча отменено.'));
        }

        if($editMatch->status_id != 0) {
            Log::error('Матч или идёт или окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя изменить уже начавшийся матч и закончившийся. Изменение матча отменено.'));
        }

        $editMatch->arena_id = $request->input('arena_id');
        if($request->input('datetime')) $editMatch->datetime = Carbon::createFromFormat('d.m.Y   H:i', $request->input('datetime'));
        else $editMatch->datetime = null;
        //$editMatch->datetime = Carbon::createFromFormat('d.m.Y   H:i', $request->input('datetime'));
        $editMatch->number = $request->input('number');
        $editMatch->home_id = $request->input('home_id');
        $editMatch->away_id = $request->input('away_id');

        if($editMatch->home_id == 0)  $editMatch->home_id = null;
        if($editMatch->away_id == 0)  $editMatch->away_id = null;
        if($editMatch->arena_id == 0)  $editMatch->arena_id = null;

        Log::info('Изменение матча:
                                                  arena-'.$editMatch->arena_id.',
                                                  datetime-'.$editMatch->datetime.',
                                                  number-'.$editMatch->number.',
                                                  home-'.$editMatch->home_id.',
                                                  away-'.$editMatch->away_id);
        try {
            $editMatch->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Матч не изменён. Изменение матча отменено.'));
        }

        $match = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);

        Cache::forget('matches_'.$tourn_id);  // очищаем кэш за матчи турнира

        return json_encode(array('status' => 'OK', 'text' => 'Матч изменён.', 'match' => $match));
    }

    /**
     * Вьюха для ввода результата
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function resultView(Request $request) {
        if (!$request->has("id")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод результата матча отменен.'));
        }

        $id = $request->input("id");
        Log::info('Получение View для ввода результата матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour','mainstage', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод результата матча отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод результата матча отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Ввод результата матча отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод результата матча отменен.'));
        }

        if($resultMatch->status_id > 1) {
            Log::error('Матч окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя изменить уже закончившийся матч. Ввод результата матча отменен.'));
        }

        return json_encode(array('status' => 'OK', 'text' => view('home.tournament.ajax_result',[
            'match' => $resultMatch,
        ])->render(),'match' => $resultMatch));
    }

    /**
     * Ввести результат матча
     * @param Request $request
     */
    public function result(Request $request) {
        if (!$request->has("id") || !$request->has("homeScore") || !$request->has("awayScore")  || !$request->has("state")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод результата матча отменен.'));
        }

        $id = $request->input("id");
        Log::info('Запись результата матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод результата матча отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод результата матча отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Ввод результата матча отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод результата матча отменен.'));
        }

        if($resultMatch->status_id > 1) {
            Log::error('Матч окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя изменить уже закончившийся матч. Ввод результата матча отменен.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Ввод результата матча отменен.'));
        }

        Log::info('Запись результата матча:
                    id - '.$id.'
                    status - '.$request->input("state").'
                    viewer - '.$request->input("viewer").'
                    ');
        $resultMatch->homescore = $request->input("homeScore");
        $resultMatch->awayscore = $request->input("awayScore");
        if($request->has("viewer")) $resultMatch->viewers = $request->input("viewer");
        $tp = false;
        $hs = $request->input("homeScore");
        $as = $request->input("awayScore");
        if($request->has("tp")) {
            Log::info('ТП-'.implode("|",$request->input("tp")));
            $tp = true;
            $arr = $request->input("tp");
            for ($i=0; $i<count($arr); $i++) {
                if ($arr[$i] == 0) {
                    // если ТП хозяевам
                    $as = 5; // TODO указать количество. Сейчас берётся из ХП
                }
                if ($arr[$i] == 1) {
                    // если ТП гостям
                    $hs = 5; // TODO указать количество. Сейчас берётся из ХП
                }
            }
        }
        $resultMatch->status_id = $request->input("state") == "true" ? 2 : 1;
        Cache::forget('matches_'.$tourn_id);  // очищаем кэш за матчи турнира
        try {
            $resultMatch->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Матч не изменён. Ввод результата матча отменен.'));
        }

        $tournament = Tournaments::find($tourn_id);
        if($tournament != null) {
            if ($tournament->sport_id == 0 || $tournament->sport_id == 1) {
                // сохраняю футбол
                if ($request->input("hasAddTime") == "true") {
                    // есть ли дополнительное время без пенальти
                    return $this->saveScore($id, $tourn_id, $hs, $as, $tp, true,
                        $request->input("homeAddScore"). $request->input("awayAddScore")); // сохранить счёт
                } elseif ($request->input("hasPenalty") == "true") {
                    // если есть пенальти
                    return $this->saveScore($id, $tourn_id, $hs, $as, $tp, true,
                        $request->input("homeAddScore"). $request->input("awayAddScore"),
                        true, $request->input("homePenaltyScore"), $request->input("awayPenaltyScore")); // сохранить счёт
                } else {
                    // без дополнительного времени
                    return $this->saveScore($id, $tourn_id, $hs, $as, $tp); // сохранить счёт
                }

            } else return $this->saveScore($id, $tourn_id, $hs, $as, $tp); // от остальных видов спорта
        }

        return json_encode(array('status' => 'fail', 'text' => 'Турнир не найден. Результат не введён.', 'match' => TournMatchesController::match($resultMatch->id)));
    }

    /**
     * Отмена результата встречи
     * @param Request $request
     * @return false|string
     */
    public function cancelResult(Request $request) {
        if (!$request->has("id")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Отмена результата матча отменена.'));
        }

        $id = $request->input("id");
        Log::info('Отмена результата матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Отмена результата матча отменена.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Отмена результата матча отменена.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Отмена результата матча отменена.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Отмена результата матча отменена.'));
        }

        if($resultMatch->status_id != 2) {
            Log::error('Матч окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя отменить не закончившийся матч. Отмена результата матча отменена.'));
        }

        /*if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Отмена результата матча отменена.'));
        }*/

        Log::info('Отмена записи результата матча:
                    id - '.$id.'
                    status - '.$request->input("state").'
                    ');
        //$resultMatch->homescore = null;
        //$resultMatch->awayscore = null;
        $resultMatch->status_id = 0;
        //$resultMatch->technicalmissed = false;

        Cache::forget('matches_'.$tourn_id);  // очищаем кэш за матчи турнира

        try {
            $resultMatch->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Матч не отменён. Отмена результата матча отменена.'));
        }

        $tournament = Tournaments::find($tourn_id);
        if($tournament != null) {
            if($tournament->sport_id == 0 || $tournament->sport_id == 1) {
                $footballMatch = TournMatches_Football::find($resultMatch->id);
                if($footballMatch != null) {
                    $footballMatch->is_additionaltime = false;
                    $footballMatch->homescore_additionaltime = null;
                    $footballMatch->awayscore_additionaltime = null;
                    $footballMatch->is_penalty = false;
                    $footballMatch->homepenaltyscore = null;
                    $footballMatch->awaypenaltyscore = null;
                    try {
                        $footballMatch->save();
                    } catch (Exception $e) {
                        return json_encode(array('status' => 'fail', 'text' => 'Матч не отменён. Отмена результата матча отменена.'));
                    }
                }
            }
        }

        return json_encode(array('status' => 'OK', 'text' => 'Результат отменён', 'match' => TournMatchesController::match($resultMatch->id)));
    }

    /**
     * Вернуть матчи за этап
     * @param $id - идентификатор этапа
     * @return \Illuminate\Support\Collection
     */
    public static function matchStage($id) {

        $rr = Stage::findOrFail($id);
        $tournament = Tournaments::findOrFail($rr->tourn_id);

        $res = TournMatches::join('sport.tb_stage','sport.tb_tournmatches.stage_id','sport.tb_stage.id')
            ->with(['home' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with('thumb');
                }]);
            }, 'away' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with('thumb');
                }]);
            }, 'tour', 'status', 'place' => function($query) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }]);
                }]);
            }, 'stage','mainstage'])
            ->stage($id);
        if($tournament->sport_id == 0 || $tournament->sport_id == 1) {
            // футбол
            $res = $res->join('sport.tb_tournmatches_football','sport.tb_tournmatches.id','sport.tb_tournmatches_football.id');
            //$res = $res->with('football');
        }
        $res = $res->orderBy('priority')->get();

        return $res;
    }

    /**
     * Вернуть протокол матча
     */
    public static function matchProtocol($id) {
        Log::info('Загрузка протокола матча - '.$id);
       // return Cache::rememberForever('match_'.$id, function () use ($id) {
            $res = TournMatches::join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
                ->with(['home' => function($query) {
                    $query->with(['logo' => function($query) {
                        $query->with('thumb');
                    }]);
                }, 'away' => function($query) {
                    $query->with(['logo' => function($query) {
                        $query->with('thumb');
                    }]);
                }, 'tour', 'status', 'place' => function($query) {
                    $query->with(['field' => function($query) {
                        $query->with(['arena' => function($query) {
                            $query->select('id', 'name');
                        }]);
                    }]);
                }, 'stage','mainstage'])
                ->findOrFail($id);

            $result = collect();
            $result['match'] = $res;
            $result['home_players'] = TournPlayersController::playersMatchTeam($id, $res->home_id);
            $result['away_players'] = TournPlayersController::playersMatchTeam($id, $res->away_id);
            $tournament = Tournaments::findOrFail($res->tourn_id);
            if($tournament->sport_id == 0 || $tournament->sport_id == 1) {
                // футбол
                $result['statistic'] = TournMatches_Football::find($id);
            }
            $result['events'] = TournPlayersController::eventsMatch($id);

            return $result;
       // });
    }

    /**
     * редактировать протокол матча
     * @param $id
     */
    public function protocol($id) {

        $result = TournMatches::join('sport.tb_stage','sport.tb_tournmatches.mainstage_id','sport.tb_stage.id')
            ->with(['home' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with('thumb');
                }]);
            }, 'away' => function($query) {
                $query->with(['logo' => function($query) {
                    $query->with('thumb');
                }]);
            }, 'tour', 'status', 'place' => function($query) {
                $query->with(['field' => function($query) {
                    $query->with(['arena' => function($query) {
                        $query->select('id', 'name');
                    }]);
                }]);
            }, 'stage','mainstage'])
            ->findOrFail($id);

        // если не установлена команд хозяев/гостей
        if(!$result->home_id || !$result->away_id) abort(403);

        $tournament = Tournaments::findOrFail($result->tourn_id);
        if($tournament->sport_id == 0 || $tournament->sport_id == 1) {
            // футбол
            $hasMinuteEditor = 1;
            /*if(TournSettings::setting($result->tourn_id, 'HAS_MINUTE')
                || TournSettings::setting($result->tourn_id, 'HAS_GKMIN')) $hasMinuteEditor = 1;*/
            $footballMatch = TournMatches_Football::find($id);
            if($footballMatch == null) abort(404);
            return view('home.tournament.protocol', [
                'match' => $result,
                'matchFootball' => $footballMatch,
                'tourn' => $tournament,
                'id' => $id,
                'home_players' => TournPlayersController::playersMatchTeam($id, $result->home_id),//MatchMembers::match($id)->team($result->home_id)->get(),
                'away_players' => TournPlayersController::playersMatchTeam($id, $result->away_id),//MatchMembers::match($id)->team($result->away_id)->get(),
                'events' => TournPlayersController::eventsMatch($id),
                'yellowCardReasons' => CardReasons::yellowCards()->orderBy('priority')->get(),
                'redCardReasons' => CardReasons::redCards()->orderBy('priority')->get(),
                'hasMinuteEditor' => $hasMinuteEditor,
                'hasForma' => TournSettings::setting($result->tourn_id, 'HAS_FORMA') == 1 ? true : false,
                'hasFouls' => TournSettings::setting($result->tourn_id, 'HAS_FOULS') == 1 ? true : false,
                'hasViewers' => TournSettings::setting($result->tourn_id, 'HAS_VIEWER') == 1 ? true : false,
                'hasShots' => TournSettings::setting($result->tourn_id, 'HAS_SHOTS') == 1 ? true : false,
                'hasBestDefenders' => TournSettings::setting($result->tourn_id, 'HAS_BESTDE') == 1 ? true : false,
                'hasMVP' => TournSettings::setting($result->tourn_id, 'HAS_MVP') == 1 ? true : false,
            ]);
        }

        abort(404);
    }

    /**
     * Изменить статус матча
     * @param Request $request
     * @return false|string
     */
    public function stateMatch(Request $request) {
        Log::info('Изменение состояния матча');
        if (!$request->has("id") || !$request->has("state")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Изменение состояния матча отменено.'));
        }
        $id = $request->input("id");
        $status = $request->input("state");
        if($status == 1)  {
            $request->merge(['state' => "false"]);
            return $this->result($request);
        }elseif ($status == 2) {
            $request->merge(['state' => "true"]);
            return $this->result($request);
        } elseif ($status == 0) {
            return $this->cancelResult($request);
        }
    }

    /**
     * Записывает результат матча, вне зависимости от состояния матча.
     * @param $id - идентификатор матча
     * @param $tournId - идентификатор соревнования
     * @param $homeScore - голы хозяев
     * @param $awayScore - голы гостей
     * @param bool $technicalMissed - техническое ли поражение
     * @param bool $hasAdditionalTime - есть ли дополнительное время в матче
     * @param int $addHomeScore - голы хояев в добавленное время
     * @param int $addAwayScore  - голы гостей в дополнительное время
     * @param bool $hasPenalty - были ли пенальти в матче
     * @param int $homePenalty - голы зозяев по пенальти
     * @param int $awayPenalty - голы гостей по пенальти
     * @return false|string - результат сохранения в формате JSON
     */
    protected function saveScore($id, $tournId, $homeScore, $awayScore, $technicalMissed = false,
                                 $hasAdditionalTime = false, $addHomeScore = 0, $addAwayScore = 0,
                                 $hasPenalty = false, $homePenalty = 0, $awayPenalty = 0) {

        Log::info('Запись счёта матча:
                    id - '.$id.'
                    tourn - '.$tournId.'
                    homeScore - '.$homeScore.'
                    awayScore - '.$awayScore.'
                    technicalMissed - '.$technicalMissed.'
                    hasAddTime - '.$hasAdditionalTime.'
                    homeAddScore - '.$addHomeScore.'
                    awayAddScore - '.$addAwayScore.'
                    hasPenalty - '.$hasPenalty.'
                    homePenaltyScore - '.$homePenalty.'
                    awayPenaltyScore - '.$awayPenalty.'
                    ');

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if($resultMatch == null) return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Счёт матча не записан.', 'match' => $resultMatch));

        $resultMatch->homescore = $homeScore;
        $resultMatch->awayscore = $awayScore;
        if($technicalMissed) {
            $resultMatch->technicalmissed = $technicalMissed;
        }

        //Cache::forget('matches_'.$tournId);  // очищаем кэш за матчи турнира
        try {
            $resultMatch->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Матч не изменён. Ввод результата матча отменен.', 'match' => $resultMatch));
        }

        $tournament = Tournaments::find($tournId);
        if($tournament != null) {
            if ($tournament->sport_id == 0 || $tournament->sport_id == 1) {
                // сохраняю футбол
                $footballMatch = TournMatches_Football::find($resultMatch->id);
                if ($footballMatch != null) {
                    if ($hasAdditionalTime) {
                        // если надо добавить доп.параметры
                        $footballMatch->is_additionaltime = true;
                        $footballMatch->homescore_additionaltime = $addHomeScore;
                        $footballMatch->awayscore_additionaltime = $addAwayScore;
                        if ($hasPenalty) {
                            $footballMatch->is_penalty = true;
                            $footballMatch->homepenaltyscore = $homePenalty;
                            $footballMatch->awaypenaltyscore = $awayPenalty;
                        } else {
                            $footballMatch->is_penalty = false;
                            $footballMatch->homepenaltyscore = null;
                            $footballMatch->awaypenaltyscore = null;
                        }
                    } else {
                        $footballMatch->is_additionaltime = false;
                        $footballMatch->homescore_additionaltime = null;
                        $footballMatch->awayscore_additionaltime = null;
                        $footballMatch->is_penalty = false;
                        $footballMatch->homepenaltyscore = null;
                        $footballMatch->awaypenaltyscore = null;
                    }

                    try {
                        $footballMatch->save();
                    } catch (Exception $e) {
                        return json_encode(array('status' => 'fail', 'text' => 'Матч не изменён. Ввод результата матча отменен.', 'match' => $resultMatch));
                    }
                }
            }
        }

        // TODO отправить оповещение об изменении счёта
        return json_encode(array('status' => 'OK', 'text' => 'Счёт матча записан', 'match' => TournMatchesController::match($id)));
    }

    /**
     * Изменить фолы в матче
     * @param Request $request
     * @return false|string
     */
    public function foulChange(Request $request) {
        if (!$request->has("id") || !$request->has("homeFoul") || !$request->has("awayFoul")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Фолы в матче не изменены.'));
        }

        $id = $request->input("id");
        Log::info('Запись фолов в матче-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Фолы в матче не изменены'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Фолы в матче не изменены'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Фолы в матче не изменены.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Фолы в матче не изменены.'));
        }

        if($resultMatch->status_id > 1) {
            Log::error('Матч окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя изменить уже закончившийся матч. Фолы в матче не изменены.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Фолы в матче не изменены.'));
        }

        if(!TournSettings::setting($tourn_id, 'HAS_FOULS')) {
            Log::error('Нельзя фиксировать фолы в турнире от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Фиксировать фолы в турнире запрещёно. Фолы в матче не изменены.'));
        }

        $tournament = Tournaments::find($tourn_id);
        if($tournament != null) {
            if ($tournament->sport_id == 0 || $tournament->sport_id == 1) {
                // сохраняю футбол
                Log::info('Сохраняю футбольный матч');
                // фолы
                if ($request->has("homeFoul") && $request->has("awayFoul")) {
                    Log::info('Сохранение фолов');
                    $footballMatch = TournMatches_Football::find($resultMatch->id);
                    if($footballMatch) {
                        Log::info('Найден матч - '.$resultMatch->id);
                        $footballMatch->homefouls = $request->input("homeFoul");
                        $footballMatch->awayfouls = $request->input("awayFoul");
                        try {
                            $footballMatch->save();
                        } catch (Exception $e) {
                            return json_encode(array('status' => 'fail', 'text' => 'Фолы в матче не изменены.', 'match' => $resultMatch));
                        }
                    }
                }
                // от фолов
                return json_encode(array('status' => 'OK', 'text' => 'Фолы в матче изменены.', 'match' => TournMatchesController::match($id)));
            } else {
                // от остальных видов спорта
            }
        }

        return json_encode(array('status' => 'fail', 'text' => 'Турнир не найден. Фолы в матче не изменены.', 'match' => TournMatchesController::match($resultMatch->id)));
    }

    /**
     * Изменён счёт в матче
     * @param Request $request
     * @return false|string
     */
    public function scoreChange(Request $request) {
        if (!$request->has("id") || !$request->has("homeScore") || !$request->has("awayScore")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Счёт матча не изменён.'));
        }

        $id = $request->input("id");
        Log::info('Запись счёта матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Счёт матча не изменён.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Счёт матча не изменён.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Счёт матча не изменён.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Счёт матча не изменён.'));
        }

        if($resultMatch->status_id > 1) {
            Log::error('Матч окончен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нельзя изменить уже закончившийся матч. Счёт матча не изменён.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Счёт матча не изменён.'));
        }

        $tp = false;
        $hs = $request->input("homeScore");
        $as = $request->input("awayScore");

        Cache::forget('matches_'.$tourn_id);  // очищаем кэш за матчи турнира

        $tournament = Tournaments::find($tourn_id);
        if($tournament != null) {
            if ($tournament->sport_id == 0 || $tournament->sport_id == 1) {
                // сохраняю футбол
                Log::info('Сохраняю футбольный матч');
                // фолы
                /* if ($request->has("homeFoul") && $request->has("awayFoul")) {
                     Log::info('Сохранение фолов');
                     $footballMatch = TournMatches_Football::find($resultMatch->id);
                     if($footballMatch) {
                         Log::info('Найден матч - '.$resultMatch->id);
                         $footballMatch->homefouls = $request->input("homeFoul");
                         $footballMatch->awayfouls = $request->input("awayFoul");
                         try {
                             $footballMatch->save();
                         } catch (Exception $e) {
                             return json_encode(array('status' => 'fail', 'text' => 'Фолы в матче не изменены.', 'match' => $resultMatch));
                         }
                     }
                 }*/
                // от фолов

                if ($request->has("hasAddTime") && $request->input("hasAddTime") == "true") {
                    // есть ли дополнительное время без пенальти
                    return $this->saveScore($id, $tourn_id, $hs, $as, $tp, true,
                        $request->input("homeAddScore"). $request->input("awayAddScore")); // сохранить счёт
                } elseif ($request->has("hasPenalty") && $request->input("hasPenalty") == "true") {
                    // если есть пенальти
                    return $this->saveScore($id, $tourn_id, $hs, $as, $tp, true,
                        $request->input("homeAddScore"). $request->input("awayAddScore"),
                        true, $request->input("homePenaltyScore"), $request->input("awayPenaltyScore")); // сохранить счёт
                } else {
                    // без дополнительного времени
                    return $this->saveScore($id, $tourn_id, $hs, $as, $tp); // сохранить счёт
                }

            } else return $this->saveScore($id, $tourn_id, $hs, $as, $tp); // от остальных видов спорта
        }

        return json_encode(array('status' => 'fail', 'text' => 'Турнир не найден. Счёт матча не изменён.', 'match' => TournMatchesController::match($resultMatch->id)));
    }

    /**
     * Записываем форму
     * @param Request $request
     * @return false|string
     */
    public function formaChange(Request $request) {
        if (!$request->has("id") || !$request->has("homeshirt") || !$request->has("homeshorts")
            || !$request->has("awayshirt") || !$request->has("awayshorts")) {
            Log::error('Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Форма команд на игру не сохранена.'));
        }

        $id = $request->input("id");
        $homeShirt = $request->input("homeshirt"); if($homeShirt == 0) $homeShirt = null;
        $awayShirt = $request->input("awayshirt"); if($awayShirt == 0) $awayShirt = null;
        $homeShorts = $request->input("homeshorts"); if($homeShorts == 0) $homeShorts = null;
        $awayShorts = $request->input("awayshorts"); if($awayShorts == 0) $awayShorts = null;
        Log::info('Запись формы матча-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Форма команд на игру не сохранена.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Форма команд на игру не сохранена.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Форма команд на игру не сохранена.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Форма команд на игру не сохранена.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Форма команд на игру не сохранена.'));
        }

        if(!TournSettings::setting($tourn_id, 'HAS_FORMA')) {
            Log::error('Ввод формы команды не предусмотрен от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Вводы формы не предусмотрен в турнире. Форма команд на игру не сохранена.'));
        }

        $resultMatch->homeshirt_id = $homeShirt;
        $resultMatch->homeshorts_id = $homeShorts;
        $resultMatch->awayshirt_id = $awayShirt;
        $resultMatch->awayshorts_id = $awayShorts;

        try {
            $resultMatch->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД состава команды. Форма команд на игру не сохранена.'));
        }


        return json_encode(array('status' => 'OK', 'text' => 'Форма команд записана'));
    }

    /**
     * показать окно с выбором игроков команды на игру
     * @param Request $request
     */
    public function teamView(Request $request) {
        if (!$request->has("id") || !$request->has("team")) {
            Log::error('Ввод состава команды. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод состава команды на матч отменен.'));
        }

        // TODO сделать капитанов и замены
        $id = $request->input("id");
        $team = $request->input("team");
        Log::info('Получение View для ввода состава команды-'.$team.' на матч-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour','mainstage', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод состава команды на матч отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод состава команды на матч отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Ввод состава команды на матч отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод состава команды на матч отменен.'));
        }

        // выбираю предыдущую введённую заявку
        $matchPlayer = MatchMembers::with('playerInfo')->match($id)->team($team)->get();

        return json_encode(array('status' => 'OK', 'text' => view('home.tournament.ajax_teamsostav',[
            'match' => $resultMatch,'team' => $team == $resultMatch->home_id ? $resultMatch->home->name : $resultMatch->away->name,
            'players' => TournPlayersController::players($tourn_id, $team)->sortBy('family'),
            'matchPlayers' => $matchPlayer,
            'team_id' => $team,
        ])->render()));
    }

    /**
     * Вывести окно с выбором формы команды
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function formaView(Request $request) {
        if (!$request->has("id") || !$request->has("team")) {
            Log::error('Ввод формы команды. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод формы команды на матч отменен.'));
        }

        $id = $request->input("id");
        $team = $request->input("team");
        Log::info('Получение View для ввода состава команды-'.$team.' на матч-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour','mainstage', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод формы команды на матч отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод формы команды на матч отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Ввод формы команды на матч отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод формы команды на матч отменен.'));
        }

        return json_encode(array('status' => 'OK', 'text' => view('home.tournament.ajax_teamforma',[
            'match' => $resultMatch,
            'colorforms' => ColorForms::orderBy('id')->get(),
        ])->render()));
    }

    /**
     * Вернуть игроков в заявке команды на турнир
     * @param $tourn_id - идентификатор турнира
     * @param $team_id - идентификатор команды в турнире
     * @return
     */
    public function adminTeamPlayers($tourn_id, $team_id) {
        //return TournPlayersController::players($tourn_id, $team_id)->sortBy('family');
        //return MatchMembers::with('playerInfo')->match(48)->team($team_id)->get();
        return TournPlayersController::playersMatchTeam(48, $team_id);
    }

    /**
     * Сохранить состав команды
     * @param Request $request
     * @return false|string
     */
    public function saveTeam(Request $request) {
        Log::info('Сохранения состава команды от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("team")/* || !$request->has("sostav")*/) {
            Log::error('Ввод состава команды. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод состава команды на матч отменен.'));
        }

        $matchId = $request->input("id");
        $teamId = $request->input("team");
        $sostav = array();
        if($request->has("sostav")) $sostav = $request->input("sostav");
        $hasTable = false;
        if($request->has("table") && $request->input("table") == "true") $hasTable = true;

        Log::info('пришли параметры:
            match_id - '.$matchId.'
            team_id  - '.$teamId.'
            sostav   - '.json_encode($sostav).'
            hastable - '.$hasTable
        );
        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод состава команды на матч отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод состава команды на матч отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Турнир закрыт. Ввод состава команды на матч отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод состава команды на матч отменен.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Ввод состава команды на матч отменен.'));
        }

        $playerArray = array();
        foreach ($sostav as $player) {
            Log::info('Запись игрока в протокол матча - '.$player['player_id']);

            // ищу в уже заявленных
            $membersResult = MatchMembers::match($matchId)->player($player['player_id'])->team($teamId)->get();
            $members = null;
            foreach ($membersResult as $res) {
                $members = $res;
                break;
            }
            if(!$members) $members = new MatchMembers();
            $members->match_id = $matchId;
            $members->team_id = $teamId;
            $members->player_id = $player['player_id'];// из таблицы tournplayers
            $members->number = $player['number'];
            if(TournSettings::setting($tourn_id, 'HAS_MINUTE')) $members->minute = TournSettings::setting($tourn_id, 'MIN_MATCH');
            if($player['gk'] == "true") $members->is_goalkeeper = TRUE;
            try {
                $members->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД состава команды. Ввод состава команды на матч отменен..', 'match' => $resultMatch));
            }
            array_push($playerArray, $player['player_id']);      // добавляю в массив идентификатор игрока
        }

        // удаляю отсутсвующих игроков, которые были добавлены в предыдущей заявке
        try {
            MatchMembers::match($matchId)->team($teamId)->whereNotIn('player_id', $playerArray)->delete();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД состава команды. Ввод состава команды на матч отменен..', 'match' => $resultMatch));
        }

        Cache::forget('players_match_'.$matchId.'_'.$teamId);           // стираю кэш состава команды на игру
        Cache::forget('events_match_'.$matchId);                        // стираю кэш состава команды на игру

        $membersMatch = TournPlayersController::playersMatchTeam($matchId, $teamId);
        //$array = array();
        if($hasTable) $array = array('status' => 'OK', 'text' => 'Состав команды сохранён', 'players' => $membersMatch, 'table' => view('home.tournament.ajax_teamsostav_view',[
            'players' => $membersMatch,
            'opponent_id' => $resultMatch->away_id == $teamId ? $resultMatch->home_id : $resultMatch->away_id,
            'team_id' => $teamId,
        ])->render(),
            'eventTable' => view('home.tournament.ajax_matchevents_view',[
                'events' => TournPlayersController::eventsMatch($matchId),
                'match' => $resultMatch,
            ])->render()); else $array = array('status' => 'OK', 'text' => 'Состав команды сохранён', 'players' => $membersMatch, 'table' => null);
        return json_encode($array);
    }

    /**
     * Сохранить событие в матче
     * @param Request $request
     * @return false|string
     */
    public function saveEvent(Request $request) {
        Log::info('Сохранения события матча от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("player_id") || !$request->has("team_id") || !$request->has("minute") || !$request->has("type")) {
            Log::error('Ввод события матча. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Событие в матче не зафиксировано.'));
        }
        $matchId = $request->input("id");
        $playerId = $request->input("player_id");
        $teamId = $request->input("team_id");
        $minute = $request->input("minute");
        $typeId = $request->input("type");
        $assistant_id = $request->has("assistant_id") && (int)$request->input("assistant_id") > 0 ? $request->input("assistant_id") : null;
        $opponent_id = $request->has("opponent_id") && (int)$request->input("opponent_id") > 0 ? $request->input("opponent_id") : null;
        $reason_id = $request->has("reason_id") && (int)$request->input("reason_id") > 0 ? $request->input("reason_id") : null;
        Log::info('пришли параметры:
            match_id - '.$matchId.'
            player_id  - '.$playerId.'
            minute   - '.$minute.'
            type - '.$typeId.'
            assistant_id - '.$assistant_id.'
            reason_id - '.$reason_id.'
            opponent_id - '.$opponent_id
        );

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Событие в матче не зафиксировано.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Событие в матче не зафиксировано.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Турнир закрыт. Событие в матче не зафиксировано.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Событие в матче не зафиксировано.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Событие в матче не зафиксировано.'));
        }

        if($typeId <= 3) {
            // если это карточка, делаем проверки
            if ($typeId == 1) {
                // если это ЖК
                $ev = MatchEvents::playerCard($matchId, 1, $playerId)->get();
                foreach ($ev as $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Игрок уже получил жёлтую карточку на '.$e->minute.' минуте. Если это карточка вторая, выберите пункт 2 ЖК. Ввод жёлтой карточки отменен.'));
                }
                $ev = MatchEvents::playerCard($matchId, 3, $playerId)->get();
                foreach ($ev as $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Игрок уже получил красную карточку на '.$e->minute.' минуте. Удалите сначала красную карточку. Ввод жёлтой карточки отменен.'));
                }
            } elseif ($typeId == 2) {
                // если это 2 ЖК
                $ev = MatchEvents::playerCard($matchId, 1, $playerId)->get();
                if ($ev->count() == 0) {
                    return json_encode(array('status' => 'fail', 'text' => 'Игрок ещё не получил жёлтой карточки. Введите сначала первую жёлтую карточку. Ввод жёлтой карточки отменен.'));
                }
                foreach ($ev as $e) {
                    if ($e->minute > $minute) {
                        // если минута 1 ЖК больше чем 2-ой ЖК
                        return json_encode(array('status' => 'fail', 'text' => '2 жёлтая карточка получена на '.$minute.' минуте и раньше первой, которая получена на '.$e->minute.' минуте'));
                    }
                }
                $ev = MatchEvents::playerCard($matchId, 3, $playerId)->get();
                foreach ($ev as $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Игрок уже получил красную карточку на '.$e->minute.' минуте. Удалите сначала красную карточку. Ввод жёлтой карточки отменен.'));
                }
                $ev = MatchEvents::playerCard($matchId, 2, $playerId)->get();
                foreach ($ev as $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Игрок уже получил вторую жёлтую карточку на '.$e->minute.' минуте. Ввод жёлтой карточки отменен.'));
                }
            } else {
                // если это КК
                $ev = MatchEvents::playerCard($matchId, 2, $playerId)->get();
                foreach ($ev as $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Игрок уже получил вторую жёлтую карточку на '.$e->minute.' минуте. Ввод красной карточки отменен.'));
                }

                $ev = MatchEvents::playerCard($matchId, 1, $playerId)->get();
                foreach ($ev as $e) {
                    if ($e->minute > $minute) {
                        // если минута 1 ЖК больше чем 2-ой ЖК
                        return json_encode(array('status' => 'fail', 'text' => 'Красная карточка получена на '.$minute.' минуте и раньше первой жёлтой карточки, которая получена на '.$e->minute.' минуте'));
                    }
                }
            }
        } // от карточки

        $hasTable = false;
        if($request->has("table") && $request->input("table") == "true") $hasTable = true;

        // Запись события
        $event = new MatchEvents();
        $event->match_id = $matchId;
        $event->player_id = $playerId;
        $event->event_id = $typeId;
        $event->team_id = $teamId;
        $event->minute = $minute;
        $event->assist_id = $assistant_id;
        $event->opponent_id = $opponent_id;
        $event->cardreason_id = $reason_id;
        try {
            $event->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД события в матче. Ввод события матча отменено.'));
        }
        Cache::forget('events_match_'.$matchId);           // стираю кэш состава команды на игру
        // от записи события

        if ($hasTable) return json_encode(array('status' => 'OK', 'text' => 'Событие матча зафиксировано', 'table' => view('home.tournament.ajax_matchevents_view',[
                                                                                                                                    'events' => TournPlayersController::eventsMatch($matchId),
                                                                                                                                    'match' => $resultMatch,
                                                                                                                                ])->render()));
        return json_encode(array('status' => 'OK', 'text' => 'Событие матча зафиксировано'));
    }

    /**
     * Удалить событие в матче
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function removeEvent(Request $request) {
        Log::info('Сохранения события матча от пользователя - '.Auth::user()->id);
        if (!$request->has("id")) {
            Log::error('Удаление события матча. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Удаление события отменено.'));
        }
        $eventId = $request->input("id");
        Log::info('пришли параметры: match_id - '.$eventId
        );

        $event = MatchEvents::find($eventId);
        if ($event == null) {
            // событие в матче не найдено
            Log::error('Событие с идентификатором - '.$eventId.' не найдено ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Событие в матче не найдено в базе данных. Удаление события отменено.'));
        }
        $matchId = $event->match_id;

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Удаление события отменено.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Удаление события отменено.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Турнир закрыт. Удаление события отменено.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Удаление события отменено.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Удаление события отменено.'));
        }

        $hasTable = false;
        if($request->has("table") && $request->input("table") == "true") $hasTable = true;

        // Удаление события
        try {
            $event->delete();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления в БД события в матче. Удаление события отменено.'));
        }
        Cache::forget('events_match_'.$matchId);           // стираю кэш состава команды на игру
        // от записи события

        if ($hasTable) return json_encode(array('status' => 'OK', 'text' => 'Событие матча зафиксировано', 'table' => view('home.tournament.ajax_matchevents_view',[
            'events' => TournPlayersController::eventsMatch($matchId),
            'match' => $resultMatch,
        ])->render()));
        return json_encode(array('status' => 'OK', 'text' => 'Событие в матче удалено'));
    }

    /**
     * Сохраниить количество минут вратаря
     * @param Request $request
     * @return false|string
     */
    public function saveGKMinute(Request $request) {
        Log::info('Сохранения количества минут вратаря от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("player_id") || !$request->has("gk") || !$request->has("minute") || !$request->has("gkminute")) {
            Log::error('Ввод события матча. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Количество минут вратаря в матче не зафиксировано.'));
        }
        $matchId = $request->input("id");
        $playerId = $request->input("player_id");
        $minute = $request->input("minute");
        $minuteGK = $request->input("gkminute");
        $is_gk = $request->input("gk") == "true" ? true : false;
        Log::info('пришли параметры:
            match_id - '.$matchId.'
            player_id  - '.$playerId.'
            minute   - '.$minute.'
            minuteGK   - '.$minuteGK
        );

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Количество минут в матче не зафиксировано.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Количество минут в матче не зафиксировано.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Количество минут в матче не зафиксировано.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Количество минут в матче не зафиксировано.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Количество минут в матче не зафиксировано.'));
        }

        $hasTable = false;
        if($request->has("table") && $request->input("table") == "true") $hasTable = true;

        // Измененния состояния
        $member = MatchMembers::match($matchId)->player($playerId)->get()->first();
        if($member == null) {
            Log::error('Не найден участник матча от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден участиник матча. Количество минут в матче не зафиксировано.'));
        }

        $member->is_goalkeeper = $is_gk;
        if (TournSettings::setting($tourn_id, 'HAS_MINUTE')) $member->minute = $minute;
        if ($is_gk && TournSettings::setting($tourn_id, 'HAS_GKMIN')) $member->minutegoalkipper = $minuteGK;

        try {
            $member->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД события в матче. Ввод события матча отменено.'));
        }

        Cache::forget('players_match_'.$matchId.'_'.$member->team_id);  // стираю кэш состава команды на игру
        Cache::forget('events_match_'.$matchId);                        // стираю кэш состава команды на игру
        // от записи события

        if ($hasTable) return json_encode(array('status' => 'OK', 'text' => 'Количество минут в матче зафиксировано',
            'table' => view('home.tournament.ajax_teamsostav_view',[
                'players' => TournPlayersController::playersMatchTeam($matchId, $member->team_id),
                'opponent_id' => $resultMatch->away_id == $member->team_id ? $resultMatch->home_id : $resultMatch->away_id,
                'team_id' => $member->team_id,
            ])->render(),
            'eventTable' => view('home.tournament.ajax_matchevents_view',[
                'events' => TournPlayersController::eventsMatch($matchId),
                'match' => $resultMatch,
            ])->render()
        ));
        return json_encode(array('status' => 'OK', 'text' => 'Количество минут в матче зафиксировано'));
    }

    /**
     * Загрузить форму минут в матче
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function playerMinuteView(Request $request) {
        if (!$request->has("id") || !$request->has("player") || !$request->has("team")) {
            Log::error('Ввод минут в игре. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Изменение времени отменено.'));
        }

        $id = $request->input("id");
        $player = $request->input("player");
        $team = $request->input("team");

        Log::info('Получение View для ввода вратаря и минут. Идентификатор-'.$id.' от пользователя - ' . Auth::user()->id);
        $resultMatch = TournMatches::with(['home', 'away', 'tour','mainstage', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($id);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Изменение времени отменено.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Изменение времени отменено.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Изменение времени отменено.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Изменение времени отменено.'));
        }

        $pls = TournPlayersController::players($tourn_id, $team);
        $fname = "Неизвестно";
        foreach ($pls as $pl) {
           // $fname.="<br>".$pl->id;
            if($pl->tournplayer_id == $player) {
                $fname = $pl->family. ' '.$pl->name;
                break;
            }
        }

        $playerMember = MatchMembers::match($id)->player($player)->team($team)->get();
        $minute = 0;
        $minuteGK = 0;
        $isGk = false;
        foreach ($playerMember as $member) {
            $minute = $member->minute;
            $minuteGK = $member->minutegoalkipper;
            $isGk = $member->is_goalkeeper;
        }

        $hasMinuteEditor = false;
        $hasMinuteGKEditor = false;
        if (TournSettings::setting($tourn_id, 'HAS_MINUTE')) $hasMinuteEditor = true;
        if (TournSettings::setting($tourn_id, 'HAS_GKMIN')) $hasMinuteGKEditor = true;
        if(!$hasMinuteEditor && !$hasMinuteGKEditor) {
            Log::error('В соревновании нет возможности для учёта минут игроков -' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'В соревновании нет возможности для учёта минут игроков. Изменение времени отменено.'));
        }

        return json_encode(array('status' => 'OK', 'text' => view('home.tournament.ajax_playedminute',[
            'family' => $fname,
            'minute' => $minute,
            'minuteGK' => $minuteGK,
            'team_id' => $team,
            'gk' => $isGk,
            'hasMinute' => $hasMinuteEditor,
            'hasGKMinute' => $hasMinuteGKEditor,
            'maxMinute' => TournSettings::setting($tourn_id, 'MIN_MATCH'),
        ])->render()));
    }

    /**
     * Сохранить зрителей в матче
     * @param Request $request
     * @return false|string
     */
    public function saveViewers(Request $request) {
        Log::info('Сохранение количества зрителей на мтачк от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("count")) {
            Log::error('Ввод зрителей матча. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод количества зрителей на матче отменено.'));
        }
        $matchId = $request->input("id");
        $viewers = $request->input("count");
        Log::info('пришли параметры:
            match_id - '.$matchId.'
            count viewers  - '.$viewers
        );

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод количества зрителей на матче отменено.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод количества зрителей на матче отменено.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Ввод количества зрителей на матче отменено.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод количества зрителей на матче отменено.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Ввод количества зрителей на матче отменено.'));
        }

        $resultMatch->viewers = $viewers;

        try {
            $resultMatch->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД события в матче. Ввод количества зрителей на матче отменено.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Количество зрителей на матче записано.'));
    }

    /**
     * Сохранить удары по воротам
     * @param Request $request
     * @return false|string
     */
    public function saveShots(Request $request) {
        Log::info('Сохранение ударов по воротам на мтаче от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("homeshots") || !$request->has("awayshots") || !$request->has("homeshotsongoal") || !$request->has("awayshotsongoal")) {
            Log::error('Ввод ударов по воротам. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод ударов по воротам в матче отменен.'));
        }
        $matchId = $request->input("id");
        $homeshots = $request->input("homeshots");
        $awayshots = $request->input("awayshots");
        $homeshotsongoal = $request->input("homeshotsongoal");
        $awayshotsongoal = $request->input("awayshotsongoal");
        Log::info('пришли параметры:
            match_id - '.$matchId.'
            homeshots - '.$homeshots.'
            awayshots - '.$awayshots.'
            homeshotsOnGoal - '.$homeshotsongoal.'
            awayshotsOnGoal - '.$awayshotsongoal
        );

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод ударов по воротам в матче отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод ударов по воротам в матче отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Ввод ударов по воротам в матче отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод ударов по воротам в матче отменен.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Ввод ударов по воротам в матче отменен.'));
        }

        $matchFootbal = TournMatches_Football::find($matchId);
        if($matchFootbal == null) {
            Log::error('Не найден футбольный матч-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден футбольный матч. Ввод ударов по воротам в матче отменен.'));
        }

        $matchFootbal->homeshots = $homeshots;
        $matchFootbal->awayshots = $awayshots;
        $matchFootbal->homeshotsongoals = $homeshotsongoal;
        $matchFootbal->awayshotsongoals = $awayshotsongoal;

        try {
            $matchFootbal->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД события в матче. Ввод ударов по воротам в матче отменен.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Количество ударов в матче записано.'));
    }

    /**
     * Сохранить MVP
     * @param Request $request
     * @return false|string
     */
    public function saveMVP(Request $request) {
        Log::info('Сохранение MVP матче от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("player")) {
            Log::error('Сохраненение MVP. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод MVP в матче отменен.'));
        }
        $matchId = $request->input("id");
        $playerId = $request->input("player");

        Log::info('пришли параметры:
            match_id - '.$matchId.'
            player - '.$playerId
        );

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод MVP в матче отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод MVP в матче отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Ввод MVP в матче отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод MVP в матче отменен.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Ввод MVP в матче отменен.'));
        }

        $matchFootbal = TournMatches_Football::find($matchId);
        if($matchFootbal == null) {
            Log::error('Не найден футбольный матч-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден футбольный матч. Ввод MVP в матче отменен.'));
        }

        $matchFootbal->mvp_id = $playerId == 0 ? null : $playerId;

        try {
            $matchFootbal->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД события в матче. Ввод MVP в матче отменен.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Ввод MVP матча успешен'));
    }

    /**
     * Сохранить лучшего защитника
     * @param Request $request
     * @return false|string
     */
    public function saveDefender(Request $request) {
        Log::info('Сохранение Лучшего защитника в матче от пользователя - '.Auth::user()->id);
        if (!$request->has("id") || !$request->has("player") || !$request->has("type")) {
            Log::error('Сохраненение Лучшего защитника. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод Лучшего защитника в матче отменен.'));
        }
        $matchId = $request->input("id");
        $playerId = $request->input("player");
        $home = $request->input("type");

        Log::info('пришли параметры:
            match_id - '.$matchId.'
            команда - '.$home.'
            player - '.$playerId
        );

        $resultMatch = TournMatches::with(['home', 'away', 'tour', 'place' => function($query) {
            $query->with(['field' => function($query) {
                $query->with(['arena' => function($query) {
                    $query->select('id', 'name', 'url');
                }]);
            }]);
        }])->find($matchId);
        if ($resultMatch == null) {
            Log::error('Майтч не найден от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Матч не найден. Ввод Лучшего защитника в матче отменен.'));
        }

        $stage = Stage::find($resultMatch->mainstage_id);
        if($stage == null) {
            Log::error('Не найден этап от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден этап. Ввод Лучшего защитника в матче отменен.'));
        }
        $tourn_id =$stage->tourn_id;
        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения состава команды на игру. Ввод Лучшего защитника в матче отменен.'));
        }
        $roles = TournamentController::roleUser($tourn_id);
        if (!$roles->contains(1) || $roles->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод Лучшего защитника в матче отменен.'));
        }

        if($resultMatch->home_id == null || $resultMatch->away_id == null) {
            Log::error('Не введены команды от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не введена команда-участник. Ввод Лучшего защитника в матче отменен.'));
        }

        $matchFootbal = TournMatches_Football::find($matchId);
        if($matchFootbal == null) {
            Log::error('Не найден футбольный матч-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден футбольный матч. Ввод Лучшего защитника в матче отменен.'));
        }

        if($home == 1)
            $matchFootbal->homedefender_id = $playerId == 0 ? null : $playerId;
        else
            $matchFootbal->awaydefender_id = $playerId == 0 ? null : $playerId;

        try {
            $matchFootbal->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД события в матче. Ввод Лучшего защитника в матче отменен.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Ввод Лучшего защитника матча успешен'));
    }

    /**
     * Вернуть имя на русском языке в зависимости от номера месяца
     * @param $month - номер месяца
     */
    static public function monthName($month) {
        $s = '';
        switch ($month) {
            case 1: {$s = "января"; break;}
            case 2: {$s = "февраля"; break;}
            case 3: {$s = "марта"; break;}
            case 4: {$s = "апреля"; break;}
            case 5: {$s = "мая"; break;}
            case 6: {$s = "июня"; break;}
            case 7: {$s = "июля"; break;}
            case 8: {$s = "августа"; break;}
            case 9: {$s = "сентября"; break;}
            case 10: {$s = "октября"; break;}
            case 11: {$s = "ноября"; break;}
            case 12: {$s = "декабря"; break;}
        }
        return $s;
    }

    /**
     * Показать протокол матча в соревновании
     * @param $url
     * @param $id
     */
    public function show($url, $id)
    {
        Log::info('Показать матч соревнования - '.$id);

        $protocol = TournMatchesController::matchProtocol($id);
        return view('match', ['match' => $protocol['match'], 'homeplayers' => $protocol['home_players'], 'away_players' => $protocol['away_players'], 'statistic' => $protocol['statistic'], 'events' => $protocol['events'] ]);
    }

    /**
     * Матчи всех соревнований. Календарь с Матч-центром
     */
    public function matchesAll()
    {
        return view('matches',[]);
    }



    /**
     * Показать календарь соревнования
     * @param $url
     */
    public function calendar($url)
    {
        Log::info('Загрузка матчей соревнования с URL - '.$url);

        $tt = TournamentController::getTournament($url);
        if($tt == null) abort(404);

        return view('tournament.calendar', ['matches' => TournMatchesController::matches($tt->id, $tt->sport_id)]);
    }
}
