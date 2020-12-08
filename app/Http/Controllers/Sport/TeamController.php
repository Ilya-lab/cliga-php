<?php

namespace App\Http\Controllers\Sport;

use App\Sport\BidPlayer;
use App\Sport\BidCoach;
use App\Sport\Tournaments;
use App\Sport\TournBids;
use App\Sport\TournTeams;
use App\Classif\Position;
use App\Classif\Post;
use App\Classif\Captain;
use App\Sport\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TeamController extends Controller
{
    /**
     *
     * Загрузка команды в заявке
     * @param $id - идентификатор чемпионата
     */
    public function adminTournamentTeam($team) {
        $command = TournTeams::with(['logo' => function($query) {
            $query->select('id','type_id')->with('thumb');
        }])->findOrFail($team);
        $id = $command->tourn_id;
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2) || !$this->hasTeamAdminRole($id, $team))
            abort(403); // права только у админа, секретаря и у представителя команды

        $tournament = Tournaments::find($id);
        if($tournament === null) abort(404);
        $bids = TournBids::tournament($id)->orderBy('start')->get();

        // это пиздец... сортировка идёт не слева направо, а справо налево!!
        $players = TournPlayersController::players( $command->tourn_id, $team)->sortBy('number')->sortBy('position_id');
        $admins = TournPlayersController::admins( $command->tourn_id, $team)->sortBy('family')->sortBy('post_id');

        return view('home.teams.team', ['tournament' => $tournament, 'roles' => $roles, 'team' => $command,
                                              'bids' => $bids, 'players' => $players, 'admins' => $admins ]);
    }

    /**
     * Показать заявку команды
     * @param $bid - идентификаитор заявки
     * @param $team - идентификатор команды в заявке
     * @param $currentPlayerArray - текущий игрок
     */
    public function adminTournamentBidTeam($team, $bid, $currentPlayerArray = array(/*'type' => 1, 'id' => 4557, 'dol' => 4, 'number' => 9, 'position' => 0, 'captain' => 1 */)) {

        $command = TournTeams::with(['logo' => function($query) {
            $query->select('id','type_id')->with('thumb');
        }])->findOrFail($team);
        $id = $command->tourn_id;
        $roles = TournamentController::roleUser($id);
        if(!$roles->contains(1) || $roles->contains(2) || !TeamController::hasTeamAdminRole($id, $team))
            abort(403); // права только у админа, секретаря и у представителя команды

        $tournament = Tournaments::findOrFail($id);
        $bid = TournBids::findOrFail($bid);
        if($bid->tourn_id != $id) abort(403);

        $positions = Position::active()->orderBy('id')->get();
        $dols = Post::orderBy('dol_id')->orderBy('priority')->get();
        $captain = Captain::orderBy('id')->get();

        $currentPlayer = null;
        $currentPlayerAttr = collect();
        $currentPhoto = null;
        if(array_key_exists('id', $currentPlayerArray)) {
            $currentPlayer = Person::find($currentPlayerArray['id']);
        }
        if(array_key_exists('type', $currentPlayerArray)) $currentPlayerAttr->put('type', $currentPlayerArray['type']);
        else $currentPlayerAttr->put('type', 0);
        if(array_key_exists('dol', $currentPlayerArray)) $currentPlayerAttr->put('dol', $currentPlayerArray['dol']);
        if(array_key_exists('number', $currentPlayerArray)) $currentPlayerAttr->put('number', $currentPlayerArray['number']);
        if(array_key_exists('position', $currentPlayerArray)) $currentPlayerAttr->put('position', $currentPlayerArray['position']);
        if(array_key_exists('captain', $currentPlayerArray)) $currentPlayerAttr->put('captain', $currentPlayerArray['captain']);

        $bidPlayers = $this->biddedPlayers($team, $bid->id);
        $unbidPlayers = $this->unbiddedPlayers($team, $bid->id);
        $bidAdmins = $this->biddedCoaches($team, $bid->id);
        $unbidCoaches = $this->unbiddedCoaches($team, $bid->id);
        $players = TournPlayersController::players($command->tourn_id, $command->id)->sortBy('family');
        $admins = TournPlayersController::admins($command->tourn_id, $command->id)->sortBy('family');
        //return $players;
        return view('home.teams.bidteam', ['tournament' => $tournament, 'roles' => $roles, 'team' => $command,
                                                 'bid' => $bid, 'positions' => $positions, 'dols' => $dols,
                                                 'captains' => $captain, 'currentPlayer' => $currentPlayer,
                                                 'currentPlayerAttr' => $currentPlayerAttr,
                                                 'bidplayers' => $bidPlayers, 'bidadmins' => $bidAdmins,
                                                 'unbidplayers' => $unbidPlayers, 'unbidadmins' => $unbidCoaches,
                                                  'players' => $players, 'admins' => $admins ]);
    }

    /**
     * Проверка права доступа от представителя команды
     * @param $tourn - идентификатор турнира
     * @param $team - идентификатор турнира
     */
    public static function hasTeamAdminRole($tourn, $team) {
        // TODO: сделать проверку на роль от пользователя - Представитель команды
        return true;
    }

    /**
     * Загрузить заявленных игроков за заявочное окно
     * @param $team - идентификатор заявленной команды
     * @param $bid - идентификтор заявки
     */
    public function biddedPlayers($team, $bid) {
        return BidPlayer::with(['person', 'position', 'photo', 'captain'])->bid($bid)->team($team)->orderBy('family')->orderBy('name')->orderBy('surname')->get();
    }

    /**
     * Загрузить заявленных тренеров и администрацию за заявочное окно
     * @param $team - идентификатор заявленной команды
     * @param $bid - идентификтор заявки
     */
    public function biddedCoaches($team, $bid) {
        return BidCoach::with(['person', 'post', 'photo'])->bid($bid)->team($team)->orderBy('family')->orderBy('name')->orderBy('surname')->get();
    }

    /**
     * Загрузить отзаявленных игроков за заявочное окно
     * @param $team - идентификатор заявленной команды
     * @param $bid - идентификтор заявки
     */
    public function unbiddedPlayers($team, $bid) {
        return BidPlayer::with(['person', 'position', 'photo', 'captain'])->unbid($bid)->team($team)->orderBy('family')->orderBy('name')->orderBy('surname')->get();
    }

    /**
     * Загрузить отзаявленных представителей
     * @param $team - идентификатор заявленной команды
     * @param $bid - идентификатор заявки
     * @return mixed
     */
    public function unbiddedCoaches($team, $bid) {
        return BidCoach::with(['person', 'post', 'photo'])->unbid($bid)->team($team)->orderBy('family')->orderBy('name')->orderBy('surname')->get();
    }
}
