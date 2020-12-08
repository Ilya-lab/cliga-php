<?php

namespace App\Http\Controllers\Sport;

use App\Sport\BidPlayer;
use App\Sport\Person;
use App\Sport\Tournaments;
use App\Sport\TournCoaches;
use App\Sport\TournPlayers;
use App\Sport\TournTeams;
use App\Sport\BidCoach;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Sport\TournBids;
use Log;
use Cache;

class TournBidsController extends Controller
{
    public function adminIndex($id) {
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2)) abort(403); // права только у админа и у секретаря

        $tournament = Tournaments::findOrFail($id);
        $teams = TournamentController::tournamentTeams($id);

        return view('home.bids.index', ['tournament' => $tournament, 'roles' => $roles, 'teams' => $teams]);
    }



    public function save(Request $request, bool $insert = true)
    {
        Log::info('Сохранение заявочного окна от пользователя - '.Auth::user()->id);
        if (!$request->has("tournament_id")) {
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор соревнования'));
        }

        $tournament_id = $request->input('tournament_id');
        if(TournamentController::isClosed($tournament_id)) {
            return json_encode(array('status' => 'fail', 'text' => 'Соревнование закрыто. Правки невозможны.'));
        }

        $roles = TournamentController::roleUser($tournament_id);
        if(!$roles->contains(1) || $roles->contains(2)) {
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа к заявкам соревнования'));
        }

        if (!$insert && !$request->has("id")) {
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор заявки'));
        }

        if ($request->has("bidname")) {
            $id = $request->input('id');
            $bidname = $request->input('bidname');
            $start = $request->input('start');
            $finish = $request->input('finish');
            $teams = $request->input('teams');
            $admins = $request->input('admins');
            $arenas = $request->input('arenas');
            $referees = $request->input('referees');
            $players = $request->input('players');

            Log::info('Сохраняю в БД заявочное окно: id-' . $id . ', name-' . $bidname . ', start-' . $start . ', finish-' . $finish . ', players-' . $players . ', teams-' . $teams . ', admins-' . $admins . ', arenas-' . $arenas . ', referees-' . $referees);

            // проверка
            $validators = Validator::make(
                array(
                    'bidname' => $bidname,
                    'start' => $start,
                    'finish' => $finish,
                ),
                array(
                    'bidname' => 'required|max:100',
                    'start' => 'required',
                    'finish' => 'required',
                ),
                array(
                    'required' => 'Поле :attribute должно быть введено',
                )
            );

            if ($insert)
                $tournBids = new TournBids;
            else {
                Log::info('Ищу заявочное окно с идентификатором: ' . $id);
                try {
                    $tournBids = TournBids::findOrFail($id);
                } catch (Exception $e) {
                    Log::error('Заявочное окно с идентификаторм ' . $id . ' не найдено');
                    return json_encode(array('status' => 'fail', 'text' => 'Заявочное окно не найдено.'));
                }
            }

            $tournBids->name = $bidname;
            $tournBids->tourn_id = $tournament_id;
            $tournBids->start = Carbon::createFromFormat('d.m.Y', $start);
            $tournBids->finish = Carbon::createFromFormat('d.m.Y', $finish);
            $tournBids->is_team = $teams;
            $tournBids->is_referee = $referees;
            $tournBids->is_arena = $arenas;
            $tournBids->is_player = $players;
            $tournBids->is_coach = $admins;

            try {
                $tournBids->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Заявочное окно не сохранено.'));
            }
        }

        if($insert) return json_encode(array('status' => 'OK', 'text' => 'Заявочное окно добавлено', 'id' => $tournBids->id, 'bidname' => $tournBids->bidname));
        return json_encode(array('status' => 'OK', 'text' => 'Заявочное окно обновлено', 'id' => $tournBids->id, 'bidname' => $tournBids->bidname));

        Log::error('Не корректно введены параметры заявочного окна');
        return json_encode(array('status' => 'fail', 'text' => 'Заявочное окно не добавлено. Неизвестная ошибка.'));
    }

    /**
     * Загрузить заявки за турнир
     * @param $id - идентификатор турнира
     */
    public function load($id) {
        return TournBids::tournament($id)->orderBy('start')->get();
    }

    /**
     * Вывести операции с командами в турнире
     * @param $id - идентификатор турнира
     */
    public function teams($id) {
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2)) abort(403); // права только у админа и у секретаря

        $tournament = Tournaments::findOrFail($id);
        $teams = TournTeams::with(['logo' => function($query) {
            $query->select('id','type_id')->with('thumb');
        }])->tournament($id)->orderBy('name')->orderBy('city')->get();

        return view('home.bids.teams', ['tournament' => $tournament, 'roles' => $roles, 'teams' => $teams]);
    }

    /**
     * сохранить участника в заявку
     * @param $team - идентификатор команды в заявке
     * @param $bid - идентификатор заявки
     * @param Request $request - POST запрос
     */
    public function adminSavePerson($team, $bid, Request $request) {
        if (!$request->has("team") || !$request->has("bid")) {
            Log::error('Не найден идентификатор заявки или команды от пользователя '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор заявки или команды'));
        }

        if($team != $request->input("team") || $bid != $request->input("bid")) {
            Log::error('Несоответствие идентификаторов заявки или команды от пользователя '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Несоответствие заявки или команды'));
        }

        if (!$request->has("type") || !$request->has("player") || !$request->has("number")
            || !$request->has("position") || !$request->has("photo")) {
            Log::error('Поступили не все параметры от пользователя '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры.'));
        }

        $command = TournTeams::findOrFail($team);
        $id = $command->tourn_id;
        if(TournamentController::isClosed($id)) {
            return json_encode(array('status' => 'fail', 'text' => 'Соревнование закрыто. Правки невозможны.'));
        }
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2) || !TeamController::hasTeamAdminRole($id, $team)) {
            Log::error('Отсутствуют права доступа к соревнованию '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Отсутствуют права доступа к соревнованию.'));
        }

        $person = Person::find($request->input("player"));
        if($person == null) {
            Log::error('Участник не найден от пользователя '.Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Участник не найден.'));
        }

        $bidded = TournBidsController::biddedAtTournament($command->tourn_id, $person->id, $request->input("type"));
        if($bidded) {
            Log::error('Участник '.$person->id.' уже добавлен в турнир '.$command->tourn_id);
            return json_encode(array('status' => 'fail', 'text' => 'Участник уже заявлен в турнире за «'.$bidded->team.'» ('.$bidded->teamcity.') в заявочное окно «'.$bidded->bidname.'»'));
        }

        if($request->input("type") == 0) {
            // если сохраняем игрока
            Log::info('Добавление игрока в зявку: bid-'.$bid.',
                                                  person_id-'.$request->input("player").',
                                                  team-'.$request->input("team").',
                                                  position-'.$request->input("position").',
                                                  photo-'.$request->input("photo").',
                                                  number-'.$request->input("number").',
                                                  family-'.$person->family.',
                                                  name-'.$person->name.',
                                                  surname-'.$person->surname.',
                                                  alias-'.$person->alias.',
                                                  captain-'.$request->input("captain"));

            $bidPlayer = new BidPlayer;
            $bidPlayer->bid_id = $bid;
            $bidPlayer->person_id = $request->input("player");
            $bidPlayer->team_id = $request->input("team");
            $bidPlayer->position_id = $request->input("position");
            $bidPlayer->photo_id = $request->input("photo");
            $bidPlayer->number = $request->input("number");
            $bidPlayer->family = $person->family;
            $bidPlayer->name = $person->name;
            $bidPlayer->surname = $person->surname;
            $bidPlayer->alias = $person->alias;
            $bidPlayer->captain_id = $request->input("captain");

            try {
                $bidPlayer->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Участник в заявку не добавлен.'));
            }

            Cache::forget('players_'.$command->tourn_id.'_'.$bidPlayer->team_id);
            return json_encode(array('status' => 'OK', 'text' => 'Игрок добавлен.', 'type' => 'player', 'player' => $this->bidPlayer($bidPlayer->id)));

        } else {
            // если сохраняем администрацию
            Log::info('Добавление администрации в зявку: bid-'.$request->input("player").',
                                                  team-'.$request->input("team").',
                                                  dol-'.$request->input("position").',
                                                  photo-'.$request->input("photo").',
                                                  family-'.$person->family.',
                                                  name-'.$person->name.',
                                                  surname-'.$person->surname.',
                                                  alias-'.$person->alias);

            $bidCoach = new BidCoach;
            $bidCoach->bid_id = $bid;
            $bidCoach->team_id = $request->input("team");
            $bidCoach->post_id = $request->input("position");
            $bidCoach->photo_id = $request->input("photo");
            $bidCoach->person_id = $request->input("player");
            $bidCoach->family = $person->family;
            $bidCoach->name = $person->name;
            $bidCoach->surname = $person->surname;
            $bidCoach->alias = $person->alias;

            try {
                $bidCoach->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Участник в заявку не добавлен.'));
            }
            Cache::forget('admins_'.$command->tourn_id.'_'.$bidCoach->team_id);
            return json_encode(array('status' => 'OK', 'text' => 'Участник добавлен.', 'type' => 'coach', 'coach' =>  $this->bidCoach($bidCoach->id)));
        }


        return json_encode(array('status' => 'fail', 'text' => 'Ошибка сохранения участника. Неизвестная ошибка.'));
    }

    /**
     * Удалить участника из команды
     * @param $team - идентификатор команды в заявке на турнир
     * @param $bid - идентификатор заявки в турнире
     * @param Request $request
     * @return false|string
     */
    public function adminRemovePerson($team, $bid, Request $request)
    {
        Log::info('Удаляю участника от пользователя ' . Auth::user()->id. '. Идентификатор команды в заявке - '.$team.'. Идентификатор в заявке - '.$bid);
        if (!$request->has("team") || !$request->has("bid")) {
            Log::error('Не найден идентификатор заявки или команды от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор заявки или команды'));
        }

        if ($team != $request->input("team") || $bid != $request->input("bid")) {
            Log::error('Несоответствие идентификаторов заявки или команды от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Несоответствие заявки или команды'));
        }

        if (!$request->has("type") || !$request->has("id")) {
            Log::error('Поступили не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры.'));
        }

        $command = TournTeams::findOrFail($team);
        $id = $command->tourn_id;
        if(TournamentController::isClosed($id)) {
            return json_encode(array('status' => 'fail', 'text' => 'Соревнование закрыто. Правки невозможны.'));
        }
        $roles = TournamentController::roleUser($id);
        if (!$roles->contains(1) || $roles->contains(2) || !TeamController::hasTeamAdminRole($id, $team)) {
            Log::error('Отсутствуют права доступа к соревнованию ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Отсутствуют права доступа к соревнованию.'));
        }

        $bid_id = $request->input("id"); // идентификатор удаляемого участника

        // TODO сделать проверку на заявленного в турнире
        /*$bidded = TournBidsController::biddedAtTournament($command->tourn_id, $person->id, $request->input("type"));
        if (!$bidded) {
            Log::error('Участник ' . $person->id . ' не заявлен в турнир ' . $command->tourn_id);
            return json_encode(array('status' => 'fail', 'text' => 'Участник не заявлен в турнире за.'));
        }*/

        if ($request->input("type") == 0) {
            // если это игрок
            $player = BidPlayer::find($bid_id);
            if($player == null) {
                // игрок не найден
                Log::error('Не найден игрок в заявке - '.$bid_id.', от пользователя - ' . Auth::user()->id);
                return json_encode(array('status' => 'fail', 'text' => 'Игрок не найден в заявке.'));
            }
            if($player->bid_id == $bid) {
                // если игрок из этой же заявки (из текущей)
                try {
                    $player->destroy($bid_id);
                } catch (Exception $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления игрока из заявки.'));
                }
                Cache::forget('players_'.$command->tourn_id.'_'.$player->team_id);
                return json_encode(array('status' => 'OK', 'text' => 'Игрок удален из заявки.', 'type' => 'player', 'player' => $player));
            } else {
                // игрок был заялен за другую заявку (более раннюю)
                $player->unbid_id = $bid;
                $pl = $this->bidPlayer($bid_id);
                try {
                    $player->save();
                } catch (Exception $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления игрока из команды.'));
                }
                Cache::forget('players_'.$command->tourn_id.'_'.$player->team_id);
                return json_encode(array('status' => 'OK', 'text' => 'Игрок удален из заявки.', 'type' => 'player', 'player' => $player, 'before_player' => $pl));
            }
        } elseif ($request->input("type") == 1) {
            // если это админ.дол
            $player = BidCoach::find($bid_id);
            if($player == null) {
                // участник не найден
                Log::error('Не найден представитель команды в заявке - '.$bid_id.', от пользователя - ' . Auth::user()->id);
                return json_encode(array('status' => 'fail', 'text' => 'Представитель команды не найден в заявке.'));
            }
            if($player->bid_id == $bid) {
                // если участник из этой же заявки (из текущей)
                try {
                    $player->destroy($bid_id);
                } catch (Exception $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления представителя команды из заявки.'));
                }
                Cache::forget('admins_'.$command->tourn_id.'_'.$player->team_id);
                return json_encode(array('status' => 'OK', 'text' => 'Преставитель команды удален из заявки.', 'type' => 'coach', 'coach' => $player));
            } else {
                // игрок был заялен за другую заявку (более раннюю)
                $player->unbid_id = $bid;
                $pl = $this->bidCoach($bid_id);
                try {
                    $player->save();
                } catch (Exception $e) {
                    return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления представителя из команды.'));
                }
                Cache::forget('admins_'.$command->tourn_id.'_'.$player->team_id);
                return json_encode(array('status' => 'OK', 'text' => 'Представитель удалён из заявки.', 'type' => 'coach', 'coach' => $player));
            }
        }
        return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления представителя команды. Неизвестная ошибка.'));
    }

    /**
     * Отменить отзаявку участника из команды
     * @param $team - идентификатор команды в турнире
     * @param $bid - идентификатор зявки в турнире
     * @param Request $request
     * @return false|string
     */
    public function adminCancelRemovePerson($team, $bid, Request $request)
    {
        Log::info('Отменяю отзаявку участника от пользователя ' . Auth::user()->id. '. Идентификатор команды в заявке - '.$team.'. Идентификатор в заявке - '.$bid);
        if (!$request->has("team") || !$request->has("bid")) {
            Log::error('Не найден идентификатор заявки или команды от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор заявки или команды'));
        }

        if ($team != $request->input("team") || $bid != $request->input("bid")) {
            Log::error('Несоответствие идентификаторов заявки или команды от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Несоответствие заявки или команды'));
        }

        if (!$request->has("type") || !$request->has("id")) {
            Log::error('Поступили не все параметры от пользователя ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Получены не все параметры.'));
        }

        $command = TournTeams::findOrFail($team);
        $id = $command->tourn_id;
        if(TournamentController::isClosed($id)) {
            return json_encode(array('status' => 'fail', 'text' => 'Соревнование закрыто. Правки невозможны.'));
        }
        $roles = TournamentController::roleUser($id);
        if (!$roles->contains(1) || $roles->contains(2) || !TeamController::hasTeamAdminRole($id, $team)) {
            Log::error('Отсутствуют права доступа к соревнованию ' . Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Отсутствуют права доступа к соревнованию.'));
        }

        $bid_id = $request->input("id"); // идентификатор удаляемого участника

        if ($request->input("type") == 0) {
            // если это игрок
            $player = BidPlayer::find($bid_id);
            if($player == null) {
                // игрок не найден
                Log::error('Не найден игрок в заявке - '.$bid_id.', от пользователя - ' . Auth::user()->id);
                return json_encode(array('status' => 'fail', 'text' => 'Игрок не найден в заявке.'));
            }

            $bidded = TournBidsController::biddedAtTournament($command->tourn_id, $player->person_id, $request->input("type"));
            if($bidded) {
                Log::error('Участник '.$player->person_id.' уже добавлен в турнир '.$command->tourn_id);
                return json_encode(array('status' => 'fail', 'text' => 'Отмена отзаявки невозможна. Участник уже заявлен в турнире за «'.$bidded->team.'» ('.$bidded->teamcity.') в заявочное окно «'.$bidded->bidname.'»'));
            }

            $player->unbid_id = null;
            try {
                $player->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Ошибка отмены отзаявки игрока из команды.'));
            }
            Cache::forget('players_'.$command->tourn_id.'_'.$player->team_id);
            return json_encode(array('status' => 'OK', 'text' => 'Игрок возвращён в команду. Отмена отзаявки.', 'type' => 'player', 'player' => $this->bidPlayer($player->id)));
        } elseif ($request->input("type") == 1) {
            // если это админ.дол
            $player = BidCoach::find($bid_id);
            if($player == null) {
                // участник не найден
                Log::error('Не найден представитель команды в заявке - '.$bid_id.', от пользователя - ' . Auth::user()->id);
                return json_encode(array('status' => 'fail', 'text' => 'Представитель команды не найден в заявке.'));
            }

            $bidded = TournBidsController::biddedAtTournament($command->tourn_id, $player->person_id, $request->input("type"));
            if($bidded) {
                Log::error('Участник '.$player->person_id.' уже добавлен в турнир '.$command->tourn_id);
                return json_encode(array('status' => 'fail', 'text' => 'Отмена отзаявки невозможна. Участник уже заявлен в турнире за «'.$bidded->team.'» ('.$bidded->teamcity.') в заявочное окно «'.$bidded->bidname.'»'));
            }

            $player->unbid_id = null;
            try {
                $player->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Ошибка отмены отзаявки Представителя команды.'));
            }
            Cache::forget('admins_'.$command->tourn_id.'_'.$player->team_id);
            return json_encode(array('status' => 'OK', 'text' => 'Отзаявка Представителя команды отменена.', 'type' => 'coach', 'coach' => $this->bidCoach($player->id)));
        }
        return json_encode(array('status' => 'fail', 'text' => 'Ошибка отмены отзаявки представителя команды. Неизвестная ошибка.'));
    }

    /**
     * Проверяет заялен ли человек в соревнование
     * @param $tourn - идентификатор турнира
     * @param $person - идентификатор человека
     * @param $type - тип: 0 - игрок, 1 - административная должность
     * @return bool - результат проверки, или наименование команды
     */
    public static function biddedAtTournament($tourn, $person, $type) {
        $person = TournPlayersController::person($tourn, $person, $type);
        foreach ($person as $p)
            return $p;
        return false;
    }

    private function bidPlayer($id) {
        $ret = TournPlayers::select('*')->
        join('sport.tb_bidplayer', function ($join) {
            $join->on('sport.tb_bidplayer.bid_id', '=', 'sport.tb_tournplayers.currentbid_id')
                ->on('sport.tb_bidplayer.person_id', '=', 'sport.tb_tournplayers.player_id');
        })->with('position', 'captain')->where('sport.tb_bidplayer.id', $id)->get();
        foreach ($ret as $player) return $player;
        return collect();
    }

    private function bidCoach($id) {
        $ret = TournCoaches::select('*')->
        join('sport.tb_bidcoach', function ($join) {
            $join->on('sport.tb_bidcoach.bid_id', '=', 'sport.tb_tourncoaches.currentbid_id')
                ->on('sport.tb_bidcoach.person_id', '=', 'sport.tb_tourncoaches.coach_id');
        })->with('post','person')->where('sport.tb_bidcoach.id', $id)->get();
        foreach ($ret as $player) return $player;
        return collect();
    }
}
