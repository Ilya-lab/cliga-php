<?php

namespace App\Http\Controllers\Sport;

use App\Classif\Settings;
use App\Sport\Seasons;
use App\Sport\Sport;
use App\Sport\Table;
use App\Sport\Tournaments;
use App\Sport\TournCoaches;
use App\Sport\TournMatches;
use App\Sport\TournSettings;
use App\Sport\TournTeams;
use App\Sport\TournPlace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Sport\Stage;
use App\Http\Controllers\UserRolesController;
use Cache;
use Log;

class TournamentController extends Controller
{
    public function adminShowTournament($id) {
        /*if (Gate::denies('TOURNAMENT', $id)) {
            abort(403);
        }*/

        $role = TournamentController::roleUser($id);
        $tournament = Tournaments::findOrFail($id);
        $stages = Stage::select('id','name','shortname', 'levels_id')->tourn($id)->main()->with(['child' => function($query) {
            $query->with(['table' => function($query) {
                $query->with('team')->orderBy('place')->orderBy('points','DESC')->orderBy('win','DESC');
            }]);
        }, 'table' => function($query) {
            $query->with('team')->orderBy('place')->orderBy('points','DESC')->orderBy('win','DESC');
        }])->orderBy('priority')->get();
        $games = TournMatchesController::matches($id);
       // return $games;

        return view('home.tournament.index', ['roles' => $role, 'tournament' => $tournament, 'stages' => $stages,
            'matches' => $games ]);
    }

    /**
     * Показать настройки турнира
     * @param $id - идентификтаор турнира
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminShowTournamentSettings($id) {
        $role = TournamentController::roleUser($id);
        $tournament = Tournaments::findOrFail($id);

        $settings = TournSettings::
            join('classif.tk_settings','key_id','key')
            ->tournament($id)->get();

        return view('home.tournament.settings', ['roles' => $role, 'tournament' => $tournament, 'settings' => $settings ]);
    }

    /**
     * возвращает роль пользователя в турнире
     * @param $id - идентификатор чемпионата
     * 1 - Админтурнира
     * 2 - секретарь турнира
     * 3 - глава судейского корпуса
     * 4 - арбитр
     * 5 - представитель команды
     * 6 - статист турнира
     * 7 - новостной редактор
     */
    static public function roleUser($id) {
        $roles = collect();  // роль не определена
        if(Auth::user()->isAdmin()) return collect([1]);       // если админ, то админ турнира

        $res = UserRolesController::tournRole(Auth::user()->id, $id);
        foreach ($res as $role) {

            $roles->push($role->role);
        }
        return $roles;
    }

    /**
     * Проверяет закрыт ли турнир. Состояние в архиве - тоже имеет статус Закрыт.
     * @param $id - идентификатор соревнования
     * @return bool - признак
     */
    static public function isClosed($id) {
        $tourn = Tournaments::find($id);
        if($tourn !== null) {
            return $tourn->status_id > 1 ? true : false;
        }
        return true;
    }

    /**
     * API
     * Возвращает список турниров
     */
    static public function tournaments($league) {
        return Cache::rememberForever('tournaments_'.$league, function () use ($league) {
            return Tournaments::select('sport.tb_tournaments.id','sport.tb_tournaments.name','sport.tb_tournaments.shortname','sport.tb_tournaments.desc','sport.tb_tournaments.status_id','sport.tb_tournaments.start','sport.tb_tournaments.finish','sport.tb_tournaments.sport_id','sport.tb_tournaments.level_id','sport.tb_tournaments.season_id')
                ->join('sport.tb_tournlist','sport.tb_tournaments.tournament_id','sport.tb_tournlist.id')
                ->with(['status', 'sport' => function($query) {
                    $query->select('id','name');
                }, 'level' => function($query) {
                    $query->select('id','name','desc');
                }, 'season'])
                ->where('sport.tb_tournlist.league_id', $league)
                ->orderBy('status_id')
                ->get();
        });
    }

    /**
     * Вернуть список турниров  по виду спорта и сезону
     * @param $league - идентификатор лиги
     * @param $season - идентификатор сезона
     * @param $sport - идентификатор вида спорта
     */
    static public function tournamentsSeasonSport($league, $sport, $season) {
       // return Cache::rememberForever('tournaments_'.$league.'_season_'.$season.'_sport_'.$sport, function () use ($league, $season, $sport) {
            if($sport == 7) // если баскетбол
                return Tournaments::select('sport.tb_tournaments.id','sport.tb_tournaments.name','sport.tb_tournaments.shortname','sport.tb_tournaments.desc','sport.tb_tournaments.url','sport.tb_tournaments.status_id','sport.tb_tournaments.start','sport.tb_tournaments.finish','sport.tb_tournaments.sport_id','sport.tb_tournaments.level_id','sport.tb_tournaments.season_id')
                    ->join('sport.tb_tournlist','sport.tb_tournaments.tournament_id','sport.tb_tournlist.id')
                    ->with(['status', 'sport' => function($query) {
                        $query->select('id','name');
                    }, 'level' => function($query) {
                        $query->select('id','name','desc');
                    }, 'season', 'basketball'])
                    ->sport($sport)->season($season)
                    ->where('sport.tb_tournlist.league_id', $league)
                    ->orderBy('status_id')->orderBy('finish','DESC')
                    ->get();
            else
                return Tournaments::select('sport.tb_tournaments.id','sport.tb_tournaments.name','sport.tb_tournaments.shortname','sport.tb_tournaments.desc','sport.tb_tournaments.url','sport.tb_tournaments.status_id','sport.tb_tournaments.start','sport.tb_tournaments.finish','sport.tb_tournaments.sport_id','sport.tb_tournaments.level_id','sport.tb_tournaments.season_id')
                    ->join('sport.tb_tournlist','sport.tb_tournaments.tournament_id','sport.tb_tournlist.id')
                    ->with(['status', 'sport' => function($query) {
                        $query->select('id','name');
                    }, 'level' => function($query) {
                        $query->select('id','name','desc');
                    }, 'season'])
                    ->sport($sport)->season($season)
                    ->where('sport.tb_tournlist.league_id', $league)
                    ->orderBy('status_id')->orderBy('finish','DESC')
                    ->get();
      //  });
    }

    /**
     * Вернуть избранные виды спорта
     */
    static public function sports() {
        //return Cache::rememberForever('sports', function () {
            /*return Sport::join('sport.tb_tournaments', 'sport.tb_sport.id', 'sport.tb_tournaments.sport_id')->
            select('sport.tb_sport.id', 'sport.tb_sport.name')->distinct()->orderBy('sport.tb_sport.id')->get();*/
        return Sport::/*join('sport.tb_tournaments', 'sport.tb_sport.id', 'sport.tb_tournaments.sport_id')->*/
        select('sport.tb_sport.id', 'sport.tb_sport.name')->whereIn('sport.tb_sport.id',[1,7])->orderBy('sport.tb_sport.id')->get();
       // });
    }

    /**
    * Вернуть виды спорта
    */
    public function sportsAll() {
        return Cache::rememberForever('sports_all', function () {
            return Sport::/*join('sport.tb_tournaments', 'sport.tb_sport.id', 'sport.tb_tournaments.sport_id')->*/
            select('sport.tb_sport.id', 'sport.tb_sport.name')/*->distinct()*/->orderBy('sport.tb_sport.id')->get();
        });
    }

    /**
     * Вернуть все команды, заявленные в соревновании
     * @param $id - идентификатор соревнования
     */
    static public function tournamentTeams($id) {
        return Cache::rememberForever('tournaments_teans_'.$id, function () use ($id) {
            return TournTeams::with(['logo' => function($query) {
                $query->select('id','type_id')->with('thumb');
            }])->tournament($id)->orderBy('name')->orderBy('city')->get();
        });
    }

    /**
     * Показать окно с настройками
     * @param Request $request
     */
    public function settingsView(Request $request) {
        if (!$request->has("id")) {
            Log::error('Ввод настроек турнира. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод настроек турнира омтенён.'));
        }
        $id = $request->input("id");

        $closed = TournamentController::isClosed($id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения матча. Турнир закрыт. Корректировка настроек невозможна.'));
        }

        $role = TournamentController::roleUser($id);
        if (!$role->contains(1)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Корректировка настроек невозможна.'));
        }
        $tournament = Tournaments::findOrFail($id);

        $settings = TournSettings::
            join('classif.tk_settings','key_id','key')
            ->tournament($id)->get();

        return json_encode(array('status' => 'OK', 'text' => view('home.tournament.ajax_settingsform',[
            'role' => $role,
            'tournament' => $tournament,
            'currentSetting' => $settings,
            'settings' => Settings::orderBy('name')->get(),
        ])->render()));
    }

    /**
     * Сохранить настройку для чемпионата
     * @param Request $request
     */
    public function settingSave(Request $request) {
        if (!$request->has("id") || !$request->has("key")) {
            Log::error('Ввод настроек турнира. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод настроек турнира омтенён.'));
        }
        $id = $request->input("id");
        $key = $request->input("key");

        $closed = TournamentController::isClosed($id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка добавления настроек. Турнир закрыт. Корректировка настроек невозможна.'));
        }

        $role = TournamentController::roleUser($id);
        if (!$role->contains(1)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Корректировка настроек невозможна.'));
        }

        Log::info('Сохранение настройки для соревнования - '.$id.' с ключом - '.$key.' от пользователя - '.Auth::user()->id);

        $defaultSetting = Settings::find($key);
        if($defaultSetting == null) {
            Log::error('Настройка не найдена -' . $key . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Настройка не найдена. Корректировка настроек невозможна.'));
        }

        $tournament = Tournaments::findOrFail($id);

        $setting = new TournSettings();
        $setting->tourn_id = $id;
        $setting->key_id = $key;
        $setting->value = $defaultSetting->default;
        try {
            $setting->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД настройки соревнования. Корректировка настроек невозможна.'));
        }

        $settings = TournSettings::
            join('classif.tk_settings','key_id','key')
            ->tournament($id)->get();

        if($request->has("table") && $request->input("table") == "true")
            return json_encode(array('status' => 'OK', 'text' => 'Настройка добавлена',
                'table' => view('home.tournament.ajax_tournsettings_view',[
                    'settings' => $settings,
                    'roles' => $role, 'tournament' => $tournament
                ])->render(),));

        return json_encode(array('status' => 'OK', 'text' => 'Настройка добавлена'));
    }

    /**
     * Удалить настройку из соревнования
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function settingRemove(Request $request) {
        if (!$request->has("id") || !$request->has("key")) {
            Log::error('Удаление настроек турнира. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Удаление настройки турнира омтенён.'));
        }
        $id = $request->input("id");
        $key = $request->input("key");

        $closed = TournamentController::isClosed($id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления настроек. Турнир закрыт. Корректировка настроек невозможна.'));
        }

        $role = TournamentController::roleUser($id);
        if (!$role->contains(1)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Корректировка настроек невозможна.'));
        }

        Log::info('Удаление настройки для соревнования - '.$id.' с ключом - '.$key.' от пользователя - '.Auth::user()->id);


        $tournament = Tournaments::findOrFail($id);

        $setting = TournSettings::key($key)->tournament($id)->get();
        foreach ($setting as $sr) {
            try {
                $sr->delete();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления из БД настройки соревнования. Корректировка настроек невозможна.'));
            }
        }
        /*if($setting == null) {
            Log::error('Отсутствуют настройка в соревновании - ' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления настройки в БД. Корректировка настроек невозможна.'));
        }*/



        $settings = TournSettings::
            join('classif.tk_settings','key_id','key')
            ->tournament($id)->get();

        if($request->has("table") && $request->input("table") == "true")
            return json_encode(array('status' => 'OK', 'text' => 'Настройка удалена',
                'table' => view('home.tournament.ajax_tournsettings_view',[
                    'settings' => $settings,
                    'roles' => $role, 'tournament' => $tournament
                ])->render(),));

        return json_encode(array('status' => 'OK', 'text' => 'Настройка удалена'));
    }

    public function settingChange(Request $request) {
        if (!$request->has("id") || !$request->has("key") || !$request->has("value")) {
            Log::error('Изменение настроек турнира. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Изменение настроек турнира омтенён.'));
        }
        $id = $request->input("id");
        $key = $request->input("key");
        $value = $request->input("value");

        $closed = TournamentController::isClosed($id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения настроек. Турнир закрыт. Корректировка настроек невозможна.'));
        }

        $role = TournamentController::roleUser($id);
        if (!$role->contains(1)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Корректировка настроек невозможна.'));
        }

        Log::info('Изменение настройки для соревнования - '.$id.' с ключом - '.$key.' от пользователя - '.Auth::user()->id);

        $tournament = Tournaments::findOrFail($id);

        $setting = TournSettings::tournament($id)->key($key)->get();
        foreach ($setting as $ss) {
            $ss->value = $value;
            try {
                $ss->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Ошибка изменения в БД настройки соревнования. Корректировка настроек невозможна.'));
            }
        }

        $settings = TournSettings::
        join('classif.tk_settings','key_id','key')
            ->tournament($id)->get();

        if($request->has("table") && $request->input("table") == "true")
            return json_encode(array('status' => 'OK', 'text' => 'Настройка изменена',
                'table' => view('home.tournament.ajax_tournsettings_view',[
                    'settings' => $settings,
                    'roles' => $role, 'tournament' => $tournament
                ])->render(),));

        return json_encode(array('status' => 'OK', 'text' => 'Настройка изменена'));
    }

    /**
     * Вернуть все этапы соревнования
     * @param $id - идентификтаор соревнования
     * @return mixed
     */
    public function tournStages($id) {
        return Stage::select('id','name','shortname','parent_id', 'levels_id', 'priority')->tourn($id)->get();
    }

    /**
     * Вернуть все этапы соревнования в древовидной структуре
     * @param $id - идентификтаор соревнования
     * @return mixed
     */
    public static function tournStagesTree($id, $withmatch = false) {
        if($withmatch) {
            return Stage::tourn($id)->main()->with(['table' => function($query) {
                $query->select('place','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points')
                    //->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id');
                    ->with(['team' => function($query) {
                        $query->select('id','team_id','name','shortname','city','url','logo_id')->with(['logo' => function($query) {
                            $query->with(['thumb' => function ($query) {
                                //$query->where('thumb_id',5);
                            }]);
                        }]);
                    }]);
                //->leftJoin('images.tb_images','sport.tb_tournteams.logo_id','images.tb_images.id')
                //->leftJoin('images.tb_thumbs','images.tb_thumbs.image_id','images.tb_images.id');//->where('images.tb_thumbs.thumb_id',6);
            }, 'child' => function($query) {
                $query->with([
                    'table' => function($query) {
                        $query->select('place','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points')
                            //->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id');
                            ->with(['team' => function($query) {
                                $query->select('id','team_id','name','shortname','city','url','logo_id')->with(['logo' => function($query) {
                                    $query->with(['thumb' => function ($query) {
                                        //$query->where('thumb_id',5);
                                    }]);
                                }]);
                            }]);
                    },
                    'match' => function($query) {
                        $query->with([
                            'home' => function($query) {
                                $query->with(['logo' => function($query) {
                                    $query->with('thumb');
                                }]);
                            },'away' => function($query) {
                                $query->with(['logo' => function($query) {
                                    $query->with('thumb');
                                }]);
                            },'tour','football']);
                    },
                    'child' => function($query) {
                        $query->with([
                            'table' => function($query) {
                                $query->select('place','name','shortname','city','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points','url')
                                    ->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id');
                            },
                            'match' => function($query) {
                                $query->with([
                                    'home' => function($query) {
                                        $query->with(['logo' => function($query) {
                                            $query->with('thumb');
                                        }]);
                                    },'away' => function($query) {
                                        $query->with(['logo' => function($query) {
                                            $query->with('thumb');
                                        }]);
                                    },'tour','football']);
                            },
                            'child' => function($query) {
                                $query->with(
                                    ['match' => function($query) {
                                        $query->with([
                                            'home' => function($query) {
                                                $query->with(['logo' => function($query) {
                                                    $query->with('thumb');
                                                }]);
                                            },'away' => function($query) {
                                                $query->with(['logo' => function($query) {
                                                    $query->with('thumb');
                                                }]);
                                            },'tour','football']);
                                    }]
                                );
                            }])->orderBy('priority');
                    }])->orderBy('priority');
            }])->orderBy('priority')->get();
        }
        return Stage::tourn($id)->main()->with(['table' => function($query) {
            $query->select('place','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points')
                //->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id');
                ->with(['team' => function($query) {
                    $query->select('id','team_id','name','shortname','city','url','logo_id')->with(['logo' => function($query) {
                        $query->with(['thumb' => function ($query) {
                            //$query->where('thumb_id',5);
                        }]);
                    }]);
                }]);
                //->leftJoin('images.tb_images','sport.tb_tournteams.logo_id','images.tb_images.id')
                //->leftJoin('images.tb_thumbs','images.tb_thumbs.image_id','images.tb_images.id');//->where('images.tb_thumbs.thumb_id',6);
        }, 'child' => function($query) {
            $query->with([
                'table' => function($query) {
                    $query->select('place','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points')
                        //->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id');
                        ->with(['team' => function($query) {
                            $query->select('id','team_id','name','shortname','city','url','logo_id')->with(['logo' => function($query) {
                                $query->with(['thumb' => function ($query) {
                                    //$query->where('thumb_id',5);
                                }]);
                            }]);
                        }]);
                },
                'child' => function($query) {
                    $query->with(['table' => function($query) {
                        $query->select('place','name','shortname','city','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points','url')
                            ->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id');
                    },'child'])->orderBy('priority');
                }])->orderBy('priority');
        }])->orderBy('priority')->get();
    }

    /*
     * Вернуть турнирную таблицу
     */
    public function tournTable($id, $stage_id) {
        return Table::select('place','sport.tb_table.id','sport.tb_table.team_id','sport.tb_table.stage_id','win','nic','los','zab','prop','points')
            //->join('sport.tb_tournteams','sport.tb_tournteams.id','sport.tb_table.team_id')
            ->with(['team' => function($query) {
                $query->select('id','team_id','name','shortname','city','url','logo_id')->with(['logo' => function($query) {
                    $query->with(['thumb' => function ($query) {
                        //$query->where('thumb_id',5);
                    }]);
                }]);
            }])
            ->where('sport.tb_table.stage_id', $stage_id)
            ->orderBy('place')->orderBy('win')->orderBy('nic')->orderBy('name')->get();
    }

    /*
     * Вернуть места в турнире, если турнир завершён
     */
    public static function tournPlace($id) {
        return TournPlace::select('sport.tb_stage.name as stagename','sport.tb_stage.id','place','sport.tb_tournteams.name','points','sport.tb_tournplace.team_id','sport.tb_tournteams.url')
            ->join('sport.tb_tournteams','sport.tb_tournplace.team_id','sport.tb_tournteams.id')
            ->join('sport.tb_stage','sport.tb_tournplace.stage_id','sport.tb_stage.id')
            ->tournament($id)->orderBy('sport.tb_stage.priority')->orderBy('place')->orderBy('points')->get();
    }

    /**
     * Текущая турнирная таблица
     * @param $tourn_id - идентификатор туринра
     */
    public static function table($tourn_id) {
       // return Cache::rememberForever('currenttable_'.$tourn_id, function () use ($tourn_id) {
            $stages = TournamentController::tournStagesTree($tourn_id);     // загрузка этапов
            for ($i = $stages->count() - 1; $i >= 0; $i--) {
                // от начала к концу, ищу команды
                $stage = $stages[$i];
                if ($stage->levels_id == 3 || $stage->levels_id == 4) {
                    // если таблица
                    if ($stage->child->count() == 0) {
                        if($stage->table->count() == 0) continue;
                        return $stage;
                    } else {
                        foreach ($stage->child as $ch) {
                            if($ch->table->count() == 0) continue 2;
                        }
                        return $stage->child;
                    }
                }
            }
            return collect();
      //  });
    }

    /**
     * Показать турнирную сетку
     * @param $tourn_id - идентификатор турнира
     * @return mixed
     */
    public static function grid($tourn_id) {
       // return Cache::rememberForever('grid_'.$tourn_id, function () use ($tourn_id) {
            $ret = collect();
            $stages = TournamentController::tournStagesTree($tourn_id, true);     // загрузка этапов
            for ($i = $stages->count() - 1; $i >= 0; $i--) {
                // от начала к концу, ищу команды
                $stage = $stages[$i];
                if ($stage->levels_id == 7 || $stage->levels_id == 8 || $stage->levels_id == 8) {
                    // если на выбывание
                    //$stage['matches'] = (TournMatches::select('*')->stage($stage->id)->get());
                    $ret->push($stage);
                }
            }
            return $ret;
        //});
    }

    /**
     * Загрзуить турнирную таблицу
     * @param $tournament - объект турнира
     */
    public static function format($tournament) {
        $ret = collect();
        if(!$tournament) return $ret;
        if($tournament->status_id == 2) {
            // если турнир завершён
            $winners = TournamentController::tournPlace($tournament->id);
            $tourn = 0;
            $tournName = '';
            $teams = array();
            foreach ($winners as $team) {
                if($tourn == 0) {
                    $tourn = $team->id;
                    $tournName = $team->stagename;
                }

                if($team->id != $tourn) {
                    $ret[] = array('name' => $tournName, 'type' => 'winners', 'table' => $teams);
                    $teams = array();
                    $tourn = $team->id;
                    $tournName = $team->stagename;
                }

                $tt = array();
                $tt['place'] = $team->place;
                $tt['name'] = $team->name;
                $tt['shortname'] = $team->name;
                $teams[] = $tt;

            }
            if($tourn > 0) {
                $ret[] = array('name' => $tournName, 'type' => 'winners', 'table' => $teams);
            }
        } else {
            // если турнир продолжается
            $stages = TournamentController::tournStagesTree($tournament->id);
            $twofinals = false;
            foreach ($stages as $stage) {
                if($stage->levels_id == 7) {
                    // если золотой финал
                    $team = array();
                    if($stage->child->count() == 1) {
                        // если матча за 3 место нет
                        foreach ($stage->child as $st) {
                            $games = TournMatchesController::matchStage($st->id);
                            //$team = array();
                            foreach ($games as $game) {
                                if($game->home_id > 0 && $game->away_id > 0) {
                                    $team = TournamentController::gameResult($team, $game);
                                    $twofinals = true;
                                }
                            }
                            foreach ($st->child as $st2) {
                                //$team[] = array('place' => 10, 'name' => $st2->name);
                                $games = TournMatchesController::matchStage($st2->id);
                                foreach ($games as $game) {
                                    //$team[] = array('place' => $game->id, 'name' => '');
                                    if($game->home_id > 0 && $game->away_id > 0) {
                                        $team = TournamentController::gameResult($team, $game,3,3);
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ($stage->child as $st) {
                            $games = TournMatchesController::matchStage($st->id);
                           // $team[] = array('place' => 10, 'name' => $st->name);
                            foreach ($games as $game) {
                                if($game->home_id > 0 && $game->away_id > 0) {
                                    if($st->priority == 1) $team = TournamentController::gameResult($team, $game);
                                    else $team = TournamentController::gameResult($team, $game,3,4);
                                    //$team[] = array('place' => $game->id, 'name' => '');
                                    $twofinals = true;
                                }
                            }
                        }
                    }
                    $ret[] = array('name' => $stage->name, 'type' => 'winners', 'table' => $team);
                }
            }

            if($twofinals) {
                // если есть золотой финал
                foreach ($stages as $stage) {
                    if($stage->levels_id == 8) {
                        // если золотой финал (серебряный финал)
                        $team = array();
                        if($stage->child->count() == 1) {
                            // если матча за 3 место нет
                            foreach ($stage->child as $st) {
                                $games = TournMatchesController::matchStage($st->id);
                                //$team = array();
                                foreach ($games as $game) {
                                    if($game->home_id > 0 && $game->away_id > 0) {
                                        $team = TournamentController::gameResult($team, $game);
                                        $twofinals = true;
                                    }
                                }
                                foreach ($st['child'] as $st2) {
                                    $games = TournMatchesController::matchStage($st2->id);
                                    foreach ($games as $game) {
                                        if($game->home_id > 0 && $game->away_id > 0) {
                                            $team = TournamentController::gameResult($team, $game,3,3);
                                        }
                                    }
                                }

                            }
                        } else {
                            foreach ($stage->child as $st) {
                                $games = TournMatchesController::matchStage($st->id);
                                // $team[] = array('place' => 10, 'name' => $st->name);
                                foreach ($games as $game) {
                                    if($game->home_id > 0 && $game->away_id > 0) {
                                        if($st->priority == 1) $team = TournamentController::gameResult($team, $game);
                                        else $team = TournamentController::gameResult($team, $game,3,4);
                                        //$team[] = array('place' => $game->id, 'name' => '');
                                        $twofinals = true;
                                    }
                                }
                            }
                        }
                        $ret[] = array('name' => $stage->name, 'type' => 'winners', 'table' => $team);
                    }
                }
            } else {
                // если без финала
                for($i=$stages->count()-1; $i>=0; $i--) {
                    $stage = $stages[$i];

                    if($stage->table->count() == 0) {
                        $found = false;
                        $ret = array();
                        foreach($stage->child as $div) {
                            $team = array();
                            foreach($div->table as $table) {
                                $found = true;
                                $log = '';
                                if($table->team->logo) {
                                    foreach ($table->team->logo->thumb as $logo) {
                                        if ($logo->thumb_id == 6) $log = $logo->filename;
                                    }
                                }
                                $team[] = array(
                                    'place' => $table->place,
                                    'name' => $table->team->name,
                                    'shortname' => $table->team->shortname,
                                    'logo' => $log,
                                    'games' => $table->win + $table->los + $table->nic,
                                    'win' => $table->win,
                                    'los' => $table->los,
                                    'nic' => $table->nic,
                                    'zab' => $table->zab,
                                    'prop' => $table->prop,
                                    'points' => $table->points,
                                );
                            }
                            $ret[] = array('name' => $div->name, 'type' => 'table', 'table' => $team);
                        }
                        if($found) break;
                    }
                }
            }
        }
        return $ret;
    }

    private static function gameResult($team, $game, $first = 1, $second = 2)
    {
        if ($game->status_id == 2) {
            // матч окончен
            if ($game->homescore > $game->awayscore) {
                // хозяева выиграли
                if($first != 3 || $second == 4) {
                    $tm = array();
                    $tm['place'] = $first;
                    $tm['name'] = $game->home->name;
                    $tm['shortname'] = $game->home->shortname;
                    $tm['logo'] = "";
                    if ($game->home->logo) {
                        foreach ($game->home->logo->thumb as $logo) {
                            if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                        }
                    }
                    $team[] = $tm;

                    $tmA = array();
                    $tmA['place'] = $second;
                    $tmA['name'] = $game->away->name;
                    $tmA['shortname'] = $game->away->shortname;
                    $tmA['logo'] = "";
                    if ($game->away->logo) {
                        foreach ($game->away->logo->thumb as $logo) {
                            if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                        }
                    }
                    $team[] = $tmA;
                } elseif($second == 3) {
                    $tmA = array();
                    $tmA['place'] = $first;
                    $tmA['name'] = $game->away->name;
                    $tmA['shortname'] = $game->away->shortname;
                    $tmA['logo'] = "";
                    if ($game->away->logo) {
                        foreach ($game->away->logo->thumb as $logo) {
                            if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                        }
                    }
                    $team[] = $tmA;
                }

            } elseif ($game->homescore < $game->awayscore) {
                // гости выиграли
                if($first != 3 || $second == 4) {
                    $tmA = array();
                    $tmA['place'] = $first;
                    $tmA['name'] = $game->away->name;
                    $tmA['shortname'] = $game->away->shortname;
                    $tmA['logo'] = "";
                    if ($game->away->logo) {
                        foreach ($game->away->logo->thumb as $logo) {
                            if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                        }
                    }
                    $team[] = $tmA;

                    $tm = array();
                    $tm['place'] = $second;
                    $tm['name'] = $game->home->name;
                    $tm['shortname'] = $game->home->shortname;
                    $tm['logo'] = "";
                    if ($game->home->logo) {
                        foreach ($game->home->logo->thumb as $logo) {
                            if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                        }
                    }
                    $team[] = $tm;
                } elseif($second == 3)  {
                    $tm = array();
                    $tm['place'] = $first;
                    $tm['name'] = $game->home->name;
                    $tm['shortname'] = $game->home->shortname;
                    $tm['logo'] = "";
                    if ($game->home->logo) {
                        foreach ($game->home->logo->thumb as $logo) {
                            if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                        }
                    }
                    $team[] = $tm;
                }

            } else {
                if ($game->homepenaltyscore > $game->awaypenaltyscore) {
                    // хозяева выиграли
                    if($first != 3 || $second == 4) {
                        $tm = array();
                        $tm['place'] = $first;
                        $tm['name'] = $game->home->name;
                        $tm['shortname'] = $game->home->shortname;
                        $tm['logo'] = "";
                        if ($game->home->logo) {
                            foreach ($game->home->logo->thumb as $logo) {
                                if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                            }
                        }
                        $team[] = $tm;

                        $tmA = array();
                        $tmA['place'] = $second;
                        $tmA['name'] = $game->away->name;
                        $tmA['shortname'] = $game->away->shortname;
                        $tmA['logo'] = "";
                        if ($game->away->logo) {
                            foreach ($game->away->logo->thumb as $logo) {
                                if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                            }
                        }
                        $team[] = $tmA;
                    } elseif($second == 3)  {
                        $tmA = array();
                        $tmA['place'] = $first;
                        $tmA['name'] = $game->away->name;
                        $tmA['shortname'] = $game->away->shortname;
                        $tmA['logo'] = "";
                        if ($game->away->logo) {
                            foreach ($game->away->logo->thumb as $logo) {
                                if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                            }
                        }
                        $team[] = $tmA;
                    }

                } elseif ($game->homepenaltyscore < $game->awaypenaltyscore) {
                    // гости выиграли
                    if($first != 3 || $second == 4) {
                        $tmA = array();
                        $tmA['place'] = $first;
                        $tmA['name'] = $game->away->name;
                        $tmA['shortname'] = $game->away->shortname;
                        $tmA['logo'] = "";
                        if ($game->away->logo) {
                            foreach ($game->away->logo->thumb as $logo) {
                                if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                            }
                        }
                        $team[] = $tmA;

                        $tm = array();
                        $tm['place'] = $second;
                        $tm['name'] = $game->home->name;
                        $tm['shortname'] = $game->home->shortname;
                        $tm['logo'] = "";
                        if ($game->home->logo) {
                            foreach ($game->home->logo->thumb as $logo) {
                                if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                            }
                        }
                        $team[] = $tm;
                    } elseif($second == 3)  {
                        $tm = array();
                        $tm['place'] = $first;
                        $tm['name'] = $game->home->name;
                        $tm['shortname'] = $game->home->shortname;
                        $tm['logo'] = "";
                        if ($game->home->logo) {
                            foreach ($game->home->logo->thumb as $logo) {
                                if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                            }
                        }
                        $team[] = $tm;
                    }

                }
            }
        } else {
            // не начался (идёт)
            $tmA = array();
            $tmA['place'] = 0;
            $tmA['name'] = $game->away->name;
            $tmA['shortname'] = $game->away->shortname;
            $tmA['logo'] = "";
            if ($game->away->logo) {
                foreach ($game->away->logo->thumb as $logo) {
                    if ($logo->thumb_id == 6) $tmA['logo'] = $logo->filename;
                }
            }
            $team[] = $tmA;

            $tm = array();
            $tm['place'] = 0;
            $tm['name'] = $game->home->name;
            $tm['shortname'] = $game->home->shortname;
            $tm['logo'] = "";
            if ($game->home->logo) {
                foreach ($game->home->logo->thumb as $logo) {
                    if ($logo->thumb_id == 6) $tm['logo'] = $logo->filename;
                }
            }

            $team[] = $tm;
        }
        return $team;
    }

    /**
     * Вернуть структуру турнира, матчи для главной страницы моб.приложения, сайта КЛ
     * @param $sport - идентификатор текущего вида спорта. Если 0 - то первый в списке.
     * @param $season - идентификатор текущего сезона вида спорта. Если 0 - первый в списке.
     * @param $tournament - идентификатор текущего турнира. Если 0 - первый в списке.
     * @param $generateHTML - генерировать HTML
     * @param int $league - идентификатор лиги. По умолчанию КЛ.
     * @return \Illuminate\Support\Collection
     */
    public static function tournamentView($sport, $season, $tournament, $generateHTML = 0, $league = 1) {
        Log::info('Выдача турнира: sport='.$sport.', season='.$season.', tournament='.$tournament.', generateHTML='.$generateHTML.', league='.$league);
        if($tournament == 'null') $tournament = 0;
        if($season == 'null') $season = 0;
        $ret = collect();
        $ret['sports'] = TournamentController::sports();
        if($sport == 0) {
            $sport = 1;
        }
        $ret['currentSport'] = (int)$sport;
        $ret['seasons'] = SeasonsController::league($league);
        if($season == 0) {
            $season = 11;
        }
        $ret['currentSeason'] = (int)$season;
        $tournaments = TournamentController::tournamentsSeasonSport($league,$sport,$season);
        $ret['tournaments'] = $tournaments;
        $currentTournamentId = 0;
        $currentTournament = null;
        foreach ($tournaments as $tourn) {
            if((int)$tournament > 0) {
                if($tourn->id == (int)$tournament) {
                    $currentTournamentId = $tourn->id;
                    $currentTournament = $tourn;
                    break;
                }
            } else {
                $currentTournamentId = $tourn->id;
                $currentTournament = $tourn;
                break;
            }
        }

        if($currentTournamentId == 0) {
            foreach ($tournaments as $tourn) {
                $currentTournamentId = $tourn->id;
                $currentTournament = $tourn;
                break;
            }
        }

        $ret['currentTournamentId'] = (int)$currentTournamentId;
        $ret['currentTournament'] = $currentTournament;
        $ret['table'] = $currentTournamentId == 0 ? collect() : TournamentController::format($currentTournament);


        // матчи
        $ret['matches'] = $currentTournamentId == 0 ? collect() : TournMatchesController::matches($currentTournamentId, $sport, true);

        // лучшие игроки
        $players = array();
        $players['forwards'] = $currentTournamentId == 0 ? collect() : TournPlayersController::topPlayers($currentTournamentId);
        $players['assistants'] = $currentTournamentId == 0 ? collect() : TournPlayersController::topAssistants($currentTournamentId);
        $players['bombardirs'] = $currentTournamentId == 0 ? collect() : TournPlayersController::topBombardirs($currentTournamentId);
        $players['defenders'] = $currentTournamentId == 0 ? collect() : TournPlayersController::topDefenders($currentTournamentId);
        $players['bestPlayers'] = $currentTournamentId == 0 ? collect() : TournPlayersController::topBestPlayers($currentTournamentId);
        $ret['players'] = $players;

        if($generateHTML == 1) {
            $rr = array();
            //if($currentTournament && $currentTournament->status_id != 2) {
                // если турнир не закончен
                $rr['table'] = $currentTournamentId == 0 ? '' : view('view.tourntable', ['tournament' => $currentTournament, 'table' => $ret['table'] ])->render();
                $rr['next_matches'] = $currentTournamentId == 0 ? '' : view('view.next_matches', ['tournament' => $currentTournament, 'matches' => $ret['matches'] ])->render();
                $rr['prev_matches'] = $currentTournamentId == 0 ? '' : view('view.prev_matches', ['tournament' => $currentTournament, 'matches' => $ret['matches'] ])->render();
                $rr['players'] = $currentTournamentId == 0 ? '' : view('view.bestplayers', ['tournament' => $currentTournament, 'players' => $ret['players'] ])->render();
         //   }
            $ret['html'] = $rr;
        }
        return $ret;
    }

    /**
     * Отобразить турнир
     * @param $url - идентификатор турнира
     */
    public function show($url)
    {
        return $url;
    }

    /**
     * Показать карточку команды в турнире
     * @param $url - идентификатор соревнования
     * @param $url_team - идентификатор команды
     */
    public function showTeam($url, $url_team)
    {
        return view('tournament.team', []);
    }

    /**
     * Показывать все соревнования
     */
    public function showAll()
    {
        return view('tournaments',['tournaments' => Tournaments::all() ]);
    }

    /**
     * Вернуть соревнование по URL
     * @param $url
     */
    public static function getTournament($url)
    {
        $tourn = Tournaments::URL($url)->get();
        foreach ($tourn as $tt) {
            return $tt;
        }
        return null;
    }
}
