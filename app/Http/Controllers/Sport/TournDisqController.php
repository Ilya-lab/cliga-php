<?php

namespace App\Http\Controllers\Sport;

use App\Classif\Disq;
use App\Sport\TournDisqMatches;
use App\Sport\TournMatches;
use App\Sport\TournPlayers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sport\Tournaments;
use App\Sport\TournDisq;
use Log;
use Auth;
use DB;

class TournDisqController extends Controller
{
    /**
     * Загрузка формы дисквалифицированных
     * @param $tourn - идентфикатор турнира
     */
    public function adminIndex($tourn)
    {
        $closed = TournamentController::isClosed($tourn);

        Log::info('Пользователь с идентификатором - '.Auth::user()->id.' зашёл в дисквалификации турнира - '.$tourn);

        $role = TournamentController::roleUser($tourn);
        $tournament = Tournaments::findOrFail($tourn);
        if (!$role->contains(1) && !$role->contains(2)) $closed = true;

        $players = TournDisq::
            join('sport.tb_tournplayers','sport.tb_tourndisq.player_id','sport.tb_tournplayers.id')
            ->join('sport.tb_bidplayer', function ($join) {
                $join->on('sport.tb_tournplayers.lastbid_id', '=', 'sport.tb_bidplayer.bid_id')
                    ->on('sport.tb_tournplayers.player_id', '=', 'sport.tb_bidplayer.person_id');
            })
            ->join('classif.tk_position','sport.tb_bidplayer.position_id','classif.tk_position.id')
            ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','sport.tb_tournteams.id')
            ->join('sport.tb_tournmatches','sport.tb_tourndisq.match_id','sport.tb_tournmatches.id')
            ->join('sport.tb_tournteams as t1', 't1.id','sport.tb_tournmatches.home_id')
            ->join('sport.tb_tournteams as t2', 't2.id','sport.tb_tournmatches.away_id')
            ->select('sport.tb_tourndisq.*','sport.tb_bidplayer.family','sport.tb_bidplayer.name',
                'classif.tk_position.name as position', 'sport.tb_tournteams.name as team',
                't1.name as home_team', 't2.name as away_team')
            ->tournament($tourn)->orderBy('elapsed','DESC')->orderBy('matches','DESC')->orderBy('family')->get();

        return view('home.disq.index', [
            'tournament' => $tournament,
            'role' => $role,
            'players' => $players,
            'closed' => $closed ]);
    }

    /**
     * Загрузка View для корректировки параметров дисквалификации
     * @param Request $request
     */
    public function disqPlayerView(Request $request)
    {

        if (!$request->has("id")) {
            Log::error('Ввод параметров дисквалификации. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод параметров дисквалификации омтенён.'));
        }
        $id = $request->input("id");
        Log::info('Отображение окна с параметрами дисквалификации - '.$id);

        $disq = TournDisq::
        join('sport.tb_tournplayers','sport.tb_tourndisq.player_id','sport.tb_tournplayers.id')
            ->join('sport.tb_bidplayer', function ($join) {
                $join->on('sport.tb_tournplayers.lastbid_id', '=', 'sport.tb_bidplayer.bid_id')
                    ->on('sport.tb_tournplayers.player_id', '=', 'sport.tb_bidplayer.person_id');
            })
            ->join('classif.tk_position','sport.tb_bidplayer.position_id','classif.tk_position.id')
            ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','sport.tb_tournteams.id')
            ->join('sport.tb_tournmatches','sport.tb_tourndisq.match_id','sport.tb_tournmatches.id')
            ->join('sport.tb_tournteams as t1', 't1.id','sport.tb_tournmatches.home_id')
            ->join('sport.tb_tournteams as t2', 't2.id','sport.tb_tournmatches.away_id')
            ->select('sport.tb_tourndisq.*','sport.tb_bidplayer.family','sport.tb_bidplayer.name',
                'classif.tk_position.name as position', 'sport.tb_tournteams.name as team',
                't1.name as home_team', 't2.name as away_team', 'sport.tb_tournmatches.datetime')
            ->find($id);
        if($disq == null) {
            Log::error('Ввод параметров дисквалификации. Дисквалификация не найдена от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Дисквалификация игрока не найдена. Ввод параметров дисквалификации омтенён.'));
        }

        $closed = TournamentController::isClosed($disq->tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ввод параметров дисквалификации. Турнир закрыт. Корректировка настроек невозможна.'));
        }

        $role = TournamentController::roleUser($disq->tourn_id);
        if (!$role->contains(1) && !$role->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Корректировка настроек дисквалификации игрока невозможна.'));
        }

        $disqMatches = TournDisqMatches::
            join('sport.tb_tournmatches','sport.tb_tourndisq_matches.match_id','sport.tb_tournmatches.id')
            ->join('sport.tb_tournteams as t1','sport.tb_tournmatches.home_id','t1.id')
            ->join('sport.tb_tournteams as t2','sport.tb_tournmatches.away_id','t2.id')
            ->select('sport.tb_tournmatches.*','t1.name as home_name','t2.name as away_name')
            ->disq($id)
            ->orderBy('sport.tb_tournmatches.datetime')
            ->get();

        // выясняю команду, за которую заявлен игрок
        $team = TournPlayers::
                join('sport.tb_bidplayer', function ($join) {
                    $join->on('sport.tb_bidplayer.bid_id', '=', 'sport.tb_tournplayers.lastbid_id')
                        ->on('sport.tb_bidplayer.person_id', '=', 'sport.tb_tournplayers.player_id');
                })
                ->select('sport.tb_tournplayers.*','sport.tb_bidplayer.team_id')
                ->find($disq->player_id);
        $matches = collect();
        if($team) {
            // если команда найдена
            $matches = TournMatches::team($team->team_id)->afterDate($disq->datetime)
                ->join('sport.tb_tournteams as t1','sport.tb_tournmatches.home_id','t1.id')
                ->join('sport.tb_tournteams as t2','sport.tb_tournmatches.away_id','t2.id')
                ->select('sport.tb_tournmatches.*','t1.name as home_team','t2.name as away_team')
                ->orderBy('sport.tb_tournmatches.datetime')
                ->get();
        }

        return json_encode(array('status' => 'OK', 'text' => view('home.disq.ajax_disqplayerform',[
            'role' => $role,
            'player' => $disq,
            'matches' => $matches,
            'disqMatches' => $disqMatches,
        ])->render()));
    }

    /**
     * Изменить параметры дисквалификации
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function change(Request $request)
    {
        if (!$request->has("id") || !$request->has("matches") || !$request->has("comments")) {
            Log::error('Изменение параметров дисквалификации. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Изменение дисквалификации отменено.'));
        }
        $id = $request->input("id");
        $matches = $request->input("matches");
        $comments = $request->input("comments");
        Log::info('Изменение параметров дисквалификации - '.$id.', матчи - '.$matches.' с комментарием - '.$comments);

        $disq = TournDisq::
            join('sport.tb_tournplayers','sport.tb_tourndisq.player_id','sport.tb_tournplayers.id')
            ->join('sport.tb_bidplayer', function ($join) {
                $join->on('sport.tb_tournplayers.lastbid_id', '=', 'sport.tb_bidplayer.bid_id')
                    ->on('sport.tb_tournplayers.player_id', '=', 'sport.tb_bidplayer.person_id');
            })
            ->join('classif.tk_position','sport.tb_bidplayer.position_id','classif.tk_position.id')
            ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','sport.tb_tournteams.id')
            ->join('sport.tb_tournmatches','sport.tb_tourndisq.match_id','sport.tb_tournmatches.id')
            ->join('sport.tb_tournteams as t1', 't1.id','sport.tb_tournmatches.home_id')
            ->join('sport.tb_tournteams as t2', 't2.id','sport.tb_tournmatches.away_id')
            ->select('sport.tb_tourndisq.*','sport.tb_bidplayer.family','sport.tb_bidplayer.name',
                'classif.tk_position.name as position', 'sport.tb_tournteams.name as team',
                't1.name as home_team', 't2.name as away_team', 'sport.tb_tournmatches.datetime')
            ->find($id);
        if($disq == null) {
            Log::error('Изменение параметров дисквалификации. Дисквалификация не найдена от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Дисквалификация игрока не найдена. Изменение дисквалификации отменено.'));
        }

        $closed = TournamentController::isClosed($disq->tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Изменение параметров дисквалификации. Турнир закрыт. Изменение дисквалификации отменено.'));
        }

        $role = TournamentController::roleUser($disq->tourn_id);
        if (!$role->contains(1) && !$role->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Корректировка настроек дисквалификации игрока невозможна.'));
        }

        $disq->matches = $matches;
        $disq->comment = $comments;

        try {
            $disq->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД параметров дисквалификации игрока. Корректировка параметров дисквалификации невозможна.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Параметры дисквалификации изменены', 'disq' => $disq->refresh()));
    }

    /**
     * Окно для добавления дисквалификации
     * @param Request $request
     * @return false|string
     * @throws \Throwable
     */
    public function disqAddPlayerView(Request $request)
    {
        if (!$request->has("id")) {
            Log::error('Ввод новой дисквалификации. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Ввод дисквалификации омтенён.'));
        }
        $id = $request->input("id");        // идентификатор турнира
        Log::info('Отображение окна с вводом новой дисквалификации - '.$id);

        $closed = TournamentController::isClosed($id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Ввод новой дисквалификации невозможен'));
        }

        $role = TournamentController::roleUser($id);
        if (!$role->contains(1) && !$role->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Ввод новой дисквалификации невозможен.'));
        }

        return json_encode(array('status' => 'OK', 'text' => view('home.disq.ajax_disqplayeraddform',[
            'role' => $role,
            'tourn_id' => $id,
            'closed' => $closed,
            'types' => Disq::orderBy('id')->get(),
            'teams' => TournamentController::tournamentTeams($id),
        ])->render()));
    }

    /**
     * Добавить новую дисквалификацию
     * @param Request $request
     * @return false|string
     */
    public function disqAddPlayer(Request $request)
    {
        if (!$request->has("tourn_id") || !$request->has("match_id") || !$request->has("player_id")
            || !$request->has("type_id") || !$request->has("matches") || !$request->has("comments")) {
            Log::error('Добавление дисквалификации. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Добавление дисквалификации отменено.'));
        }
        $tourn_id = $request->input("tourn_id");
        $match_id = $request->input("match_id");
        $player_id = $request->input("player_id");
        $type_id = $request->input("type_id");
        $matches = $request->input("matches");
        $comments = $request->input("comments");
        Log::info('Добавление дисквалификации от пользователя - '.Auth::user()->id.':
                    турнир - '.$tourn_id.'
                    матч - '.$match_id.'
                    игрок - '.$player_id.'
                    тип дисквалификации - '.$type_id.'
                    количество матчей - '.$matches.'
                    комментарий - '.$comments);

        $closed = TournamentController::isClosed($tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Турнир закрыт. Добавление дисквалификации отменено.'));
        }

        $role = TournamentController::roleUser($tourn_id);
        if (!$role->contains(1) && !$role->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $tourn_id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Добавление дисквалификации игрока невозможна.'));
        }

        $disq = TournDisq::match($match_id)->tournament($tourn_id)->player($player_id)->get();
        foreach ($disq as $dd) {
            Log::error('Игрок уже дисквалифицирован в игре от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Игрок уже дисквалифицирован в матче. Добавление дисквалификации игрока невозможна.'));
        }

        $disq = new TournDisq();
        $disq->tourn_id = $tourn_id;
        $disq->match_id = $match_id;
        $disq->player_id = $player_id;
        $disq->type_id = $type_id;
        $disq->matches = $matches;
        $disq->comment = $comments;

        try {
            $disq->save();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка записи в БД новой дисквалификации игрока. Добавление новой дисквалификации отменено.'));
        }

        $disq = TournDisq::
        join('sport.tb_tournplayers','sport.tb_tourndisq.player_id','sport.tb_tournplayers.id')
            ->join('sport.tb_bidplayer', function ($join) {
                $join->on('sport.tb_tournplayers.lastbid_id', '=', 'sport.tb_bidplayer.bid_id')
                    ->on('sport.tb_tournplayers.player_id', '=', 'sport.tb_bidplayer.person_id');
            })
            ->join('classif.tk_position','sport.tb_bidplayer.position_id','classif.tk_position.id')
            ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','sport.tb_tournteams.id')
            ->join('sport.tb_tournmatches','sport.tb_tourndisq.match_id','sport.tb_tournmatches.id')
            ->join('sport.tb_tournteams as t1', 't1.id','sport.tb_tournmatches.home_id')
            ->join('sport.tb_tournteams as t2', 't2.id','sport.tb_tournmatches.away_id')
            ->select('sport.tb_tourndisq.*','sport.tb_bidplayer.family','sport.tb_bidplayer.name',
                'classif.tk_position.name as position', 'sport.tb_tournteams.name as team',
                't1.name as home_team', 't2.name as away_team', 'sport.tb_tournmatches.datetime')
            ->find($disq->id);
        if($disq == null) {
            Log::error('Изменение параметров дисквалификации. Дисквалификация не найдена от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Дисквалификация игрока не найдена. Добавление дисквалификации отменено.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Игрок добавлен в дисквалификации турнира', 'disq' => $disq));
    }

    /**
     * Удалить дисквалификацию игрока
     * @param Request $request
     * @return false|string
     */
    public function disqDeletePlayer(Request $request)
    {
        if (!$request->has("id")) {
            Log::error('Удаление дисквалификации. Получены не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры. Удаление дисквалификации отменено.'));
        }
        $id = $request->input("id");
        Log::info('Удаление дисквалификации - '.$id.', пользователем - '.Auth::user()->id);

        $disq = TournDisq::
        join('sport.tb_tournplayers','sport.tb_tourndisq.player_id','sport.tb_tournplayers.id')
            ->join('sport.tb_bidplayer', function ($join) {
                $join->on('sport.tb_tournplayers.lastbid_id', '=', 'sport.tb_bidplayer.bid_id')
                    ->on('sport.tb_tournplayers.player_id', '=', 'sport.tb_bidplayer.person_id');
            })
            ->join('classif.tk_position','sport.tb_bidplayer.position_id','classif.tk_position.id')
            ->join('sport.tb_tournteams','sport.tb_bidplayer.team_id','sport.tb_tournteams.id')
            ->join('sport.tb_tournmatches','sport.tb_tourndisq.match_id','sport.tb_tournmatches.id')
            ->join('sport.tb_tournteams as t1', 't1.id','sport.tb_tournmatches.home_id')
            ->join('sport.tb_tournteams as t2', 't2.id','sport.tb_tournmatches.away_id')
            ->select('sport.tb_tourndisq.*','sport.tb_bidplayer.family','sport.tb_bidplayer.name',
                'classif.tk_position.name as position', 'sport.tb_tournteams.name as team',
                't1.name as home_team', 't2.name as away_team', 'sport.tb_tournmatches.datetime')
            ->find($id);
        if($disq == null) {
            Log::error('Удаление дисквалификации. Дисквалификация не найдена от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Дисквалификация игрока не найдена. Удаление дисквалификации отменено.'));
        }

        $closed = TournamentController::isClosed($disq->tourn_id);
        if ($closed) {
            Log::error('Соревнование закрыто от пользователя - ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Турнир закрыт. Удаление дисквалификации отменено.'));
        }

        $role = TournamentController::roleUser($disq->tourn_id);
        if (!$role->contains(1) && !$role->contains(2)) {
            Log::error('Отсутствуют права доступа к соревнованию-' . $id . ' от пользователя-' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к соревнованию. Удаление дисквалификации игрока невозможна.'));
        }

        try {
            $disq->delete();
        } catch (Exception $e) {
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления дисквалификации игрока.'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Игрок удалён из дисквалификаций турнира', 'disq' => $disq));
    }

    /**
     * Список дисквалифицированных
     * @param $tourn_id - идентификатор турнира
     */
    public static function disq($tourn_id) {
        $ret = TournDisq::with([
            'player' => function($query) use ($tourn_id) {
                $query->with(['bid' => function($query) {
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
            }, 'matches'=>function($query) {
                $query->with('home','away');
            }])->tournament($tourn_id);

        $ret = $ret->orderByDesc('elapsed')->orderBy('matches')->orderByDesc('type_id');
        return $ret->get();
    }
}
