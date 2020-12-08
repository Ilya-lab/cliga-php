@extends('layouts.main')

@section('title')Протокол футбольного матча @endsection

@section('js')<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/globalization/globalize.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/globalization/globalize.culture.ru-RU.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxpopover.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxtooltip.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version') }}"></script>

<script type="text/javascript" src="{{ asset('resources/home/protocol.js').'?v='.config('app.version') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('content')
<button type="button" class="btn btn-default" id="back" onclick="history.back();">Назад</button>
<div id="grid" data-currentscore-route="{{ route('admin_savescore') }}" data-currentfoul-route="{{ route('admin_savefoul') }}" data-state-route="{{ route('admin_statematch') }}" data-team-route="{{ route('admin_teammatchview') }}" data-forma-route="{{ route('admin_formamatchview') }}" data-saveevent-route="{{ route('admin_saveeventmatch') }}" data-removeevent-route="{{ route('admin_removeeventmatch') }}" data-minupdateevent-route="{{ route('admin_playedminutehview') }}" data-minupdate-route="{{ route('admin_saveminutematch') }}" data-saveviewers-route="{{ route('admin_saveviewersmatch') }}" data-saveshots-route="{{ route('admin_saveshotsmatch') }}" data-savemvp-route="{{ route('admin_savemvpmatch') }}", data-savedefender-route="{{ route('admin_savedefendermatch') }}"></div>
<div id="loader"></div>
<div class="ln_solid"></div>
<div id="messageNotification">
    <div id="message"></div>
</div>

<div class="row m-3">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Протокол матча @if($match->home){{ $match->home->name }} @else<small class="red">нет</small>@endif - @if($match->away){{ $match->away->name }} @else<small class="red">нет</small>@endif</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: none">
                <div class="row m-3"><small>Дата и время игры - </small><strong>@if($match->datetime){{ date('d.m.y   H:i', strtotime($match->datetime)) }}@endif</strong></div>
                <div class="row m-3"><small>Стадион, арена, площадка - </small><strong>{{ $match->place->field->arena->name }} @if($match->place->field->number > 0) ({{ $match->place->field->number }}) @endif</strong></div>
                <div class="row m-3"><small>Стадия - </small><strong>{{ $match->mainstage->name }}</strong></div>
                <div class="row m-3"><small>Этап - </small><strong>{{ $match->tour->name }}</strong></div>
                <div class="row m-3"><small>Статус - </small><span class="status-circle @if($match->status_id == 1)bg-green @elseif($match->status_id == 0)bg-red @else bg-blue @endif mr-2"></span><strong>{{ $match->status->name }}</strong></div>
                <div class="row m-3"><small>Судьи - </small><strong>нет</strong></div>
            </div>
        </div>
    </div>
    @component('components.box_block')
        @slot('title')Действия @endslot
        @slot('description') Ввод и корректировка протокола @endslot
        <div class="form-group row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button id="home_button" class="btn btn-primary w-100">Состав «@if($match->home){{ $match->home->name }}@elseнет@endif»</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Ввести состав команды хозяев
            </div>
        </div>
        <div class="form-group row border-bottom pb-3">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button id="away_button" class="btn btn-primary w-100">Состав «@if($match->away){{ $match->away->name }}@elseнет@endif»</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Ввести состав команды гостей
            </div>
        </div>
        @if($hasForma)
        <div class="form-group row border-bottom pb-3">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button id="forma_button" class="btn btn-info w-100">Форма команд</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Ввести цвет формы команд
            </div>
        </div>
        @endif

        <div id="rowStart" class="form-group row @if($match->status_id != 0) hidden @endif">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="start_button" class="btn btn-success w-100">Начать матч</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Изменить статус матча на «идёт»
            </div>
        </div>

        <div id="rowFinish" class="form-group row border-bottom pb-3  @if($match->status_id >= 2) hidden @endif">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="finish_button" class="btn btn-primary w-100">Завершить матч</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Изменить статус матча на «окончен» и зафиксировать результат
            </div>
        </div>

        <div id="rowCancel" class="form-group row border-bottom pb-3 @if($match->status_id != 2) hidden @endif">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="cancel_button" class="btn btn-danger w-100">Отменить результат</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Отменить результат матча и перевести в статус «не начался»
            </div>
        </div>
        <form class="form-horizontal form-label-left">
            <div class="form-group row">
                <table class="w-100">
                    <tr>
                        <th width="45%" class="text-right">@if( $match->home){{ $match->home->name }}@else хозяева @endif</th>
                        <th width="10%"></th>
                        <th width="45%" class="text-left">@if( $match->away){{ $match->away->name }}@else гости @endif</th>
                    </tr>
                    <tr>
                        <td align="right"><div id="homeScore"></div></td>
                        <td></td>
                        <td align="left"><div id="awayScore"></div></td>
                    </tr>
                </table>
            </div>
            <div class="w-100 border-bottom m-2"></div>
            @if($match->mainstage->levels_id == 5 || $match->mainstage->levels_id == 6)
                <div class="form-group row">
                    <input id="addtime" type="checkbox" />Дополнительное время и пенальти
                    <div id="addTimePanel" style="display: none;" class="w-100  border-bottom m-2 pb-2">
                        <table class="w-100">
                            <tr>
                                <th width="45%" class="text-right">@if( $match->home){{ $match->home->name }}@else хозяев @endif</th>
                                <th width="10%"></th>
                                <th width="45%" class="text-left">@if( $match->away){{ $match->away->name }}@else хозяев @endif</th>
                            </tr>
                            <tr>
                                <td align="right"><div id="homeAddScore"></div></td>
                                <td></td>
                                <td align="left"><div id="awayAddScore"></div></td>
                            </tr>
                        </table>
                        <input id="penaltytime" type="checkbox" />Пенальти
                        <div id="panaltyPanel" style="display: none;" class="w-100  border-bottom m-2 pb-2">
                            <table class="w-100">
                                <tr>
                                    <th width="45%" class="text-right">@if( $match->home){{ $match->home->name }}@else хозяев @endif</th>
                                    <th width="10%"></th>
                                    <th width="45%" class="text-left">@if( $match->away){{ $match->away->name }}@else хозяев @endif</th>
                                </tr>
                                <tr>
                                    <td align="right"><div id="homePenaltyScore"></div></td>
                                    <td></td>
                                    <td align="left"><div id="awayPenaltyScore"></div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </form>
    @endcomponent
    @component('components.box_block')
        @slot('title')Состав «@if($match->home){{ $match->home->name }}@elseнет@endif» @endslot
        @slot('description') Состав команды на игру @endslot
        <div id="box{{ $match->home_id }}">
            @include('home.tournament.ajax_teamsostav_view', ['players' => $home_players, 'team_id' => $match->home_id, 'opponent_id' => $match->away_id ])
        </div>
    @endcomponent
    @component('components.box_block')
        @slot('title')Состав «@if($match->away){{ $match->away->name }}@elseнет@endif» @endslot
        @slot('description') Состав команды на игру @endslot
        <div id="box{{ $match->away_id }}">
            @include('home.tournament.ajax_teamsostav_view', ['players' => $away_players, 'team_id' => $match->away_id, 'opponent_id' => $match->home_id ])
        </div>
    @endcomponent
    @component('components.box_block')
        @slot('title')События @endslot
        @slot('description') События в матче @endslot
        <div id="eventbox">
            @include('home.tournament.ajax_matchevents_view', ['events' => $events, 'match' => $match ])
        </div>
    @endcomponent
    @if($hasViewers || $hasFouls || $hasShots)
    @component('components.box_block')
        @slot('title')Статистика @endslot
        @slot('description') Статистика матча @endslot
            @if($hasFouls)
            <h4>Фолы</h4>
            <div class="form-group row">
                <table class="w-100">
                    <tr>
                        <th width="45%" class="text-right">@if( $match->home){{ $match->home->name }}@else хозяева @endif</th>
                        <th width="10%"></th>
                        <th width="45%" class="text-left">@if( $match->away){{ $match->away->name }}@else гости @endif</th>
                    </tr>
                    <tr>
                        <td align="right"><div id="homeFoul"></div></td>
                        <td></td>
                        <td align="left"><div id="awayFoul"></div></td>
                    </tr>
                </table>
            </div>
            @endif
            @if($hasViewers)
            <div class="w-100  border-top m-2 pb-2">
                <h4>Зрители</h4>
                <form id="formVal" class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12">Количество на игре</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="countViewers"></div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            @if($hasShots)
            <div class="form-group row m-2 pb-2">
                <h4>Удары по воротам</h4>
                <table class="w-100">
                    <tr>
                        <th width="45%" class="text-center">@if( $match->home){{ $match->home->name }}@else хозяева @endif</th>
                        <th width="10%"></th>
                        <th width="45%" class="text-center">@if( $match->away){{ $match->away->name }}@else гости @endif</th>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="3">всего</td>
                    </tr>
                    <tr>
                        <td align="center"><div id="homeShots"></div></td>
                        <td></td>
                        <td align="center"><div id="awayShots"></div></td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="3">в створ</td>
                    </tr>
                    <tr>
                        <td align="center"><div id="homeShotsOnGoal"></div></td>
                        <td></td>
                        <td align="center"><div id="awayShotsOnGoal"></div></td>
                    </tr>
                </table>
            </div>
            @endif
    @endcomponent
    @endif
    @if($hasBestDefenders && $hasMVP)
    @component('components.box_block')
        @slot('title')Лучшие игроки @endslot
        @slot('description') Лучшие игроки матча @endslot
        @if($hasBestDefenders)
        <div class="w-100  border-top m-2 pb-2">
            <h4>Защитники</h4>
                <div class="form-group row">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">Защитник хозяев</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="homeDefenders">
                            <option value="0">Не выбран</option>
                            @if( $match->home)
                            @foreach($home_players as $player)
                            <option value="{{ $player->player_id }}" @if($matchFootball->homedefender_id == $player->player_id) selected @endif>@if($player->number > 0){{ $player->number }} - @endif{{ $player->family.' '.$player->name }}  (@if($player->is_goalkeeper ) вр @else {{ $player->position_shortname }} @endif)</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">Защитник гостей</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="awayDefenders">
                            <option value="0">Не выбран</option>
                            @if($match->away)
                            @foreach($away_players as $player)
                                <option value="{{ $player->player_id }}" @if($matchFootball->awaydefender_id == $player->player_id) selected @endif>@if($player->number > 0){{ $player->number }} - @endif{{ $player->family.' '.$player->name }}  (@if($player->is_goalkeeper ) вр @else {{ $player->position_shortname }} @endif)</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
        </div>
        @endif
        @if($hasMVP)
        <div class="w-100  border-top m-2 pb-2">
            <h4>MVP</h4>
            <div class="form-group row">
                <label class="control-label col-md-6 col-sm-6 col-xs-12">MVP матча</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="mvp">
                        <optgroup label="Не выбрано">
                        <option value="0">Не выбран</option>
                        </optgroup>
                        @if($match->home)
                        <optgroup label="{{ $match->home->name }}">
                        @foreach($home_players as $player)
                            <option value="{{ $player->player_id }}" @if($matchFootball->mvp_id == $player->player_id) selected @endif>@if($player->number > 0){{ $player->number }} - @endif{{ $player->family.' '.$player->name }}  (@if($player->is_goalkeeper ) вр @else {{ $player->position_shortname }} @endif)</option>
                        @endforeach
                        </optgroup>
                        @endif
                        @if($match->away)
                        <optgroup label="{{ $match->away->name }}">
                        @foreach($away_players as $player)
                            <option value="{{ $player->player_id }}" @if($matchFootball->mvp_id == $player->player_id) selected @endif>@if($player->number > 0){{ $player->number }} - @endif{{ $player->family.' '.$player->name }}  (@if($player->is_goalkeeper ) вр @else {{ $player->position_shortname }} @endif)</option>
                        @endforeach
                        </optgroup>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        @endif
    @endcomponent
    @endif
</div>
<input id="_match" type="hidden" value="{{ $id }}">
<input id="_status" type="hidden" value="{{ $match->status_id }}">
<input id="_homeScore" type="hidden" value="{{ $match->homefoul == null ? 0 : $match->homescore }}">
<input id="_awayScore" type="hidden" value="{{ $match->awayscore == null ? 0 : $match->awayscore }}">
<input id="_homeFoul" type="hidden" value="{{ $matchFootball == null ? 0 : $matchFootball->homefouls }}">
<input id="_awayFoul" type="hidden" value="{{ $matchFootball == null ? 0 : $matchFootball->awayfouls }}">
<input id="_home" type="hidden" value="{{ $match->home_id }}">
<input id="_away" type="hidden" value="{{ $match->away_id }}">
<input id="_currentPlayer" type="hidden" value="0">
<input id="_currentTeam" type="hidden" value="0">
<input id="_hasMinuteEditor" type="hidden" value="{{ $hasMinuteEditor }}">
<input id="_countViewers" type="hidden" value="{{ $match->viewers }}">
<input id="_homeShots" type="hidden" value="{{ $matchFootball->homeshots }}">
<input id="_awayShots" type="hidden" value="{{ $matchFootball->awayshots }}">
<input id="_homeShotsOnGoal" type="hidden" value="{{ $matchFootball->homeshotsongoals }}">
<input id="_awayShotsOnGoal" type="hidden" value="{{ $matchFootball->awayshotsongoals }}">
<style>
#homeScore input, #awayScore input {
    font-size: 40px;
}
#homeFoul input, #awayFoul input {
    font-size: 28px;
    background: #f5f7d1;
}
</style>

<div class="modal fade bs-modal" id="dialogGoal" role="dialogGoal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Гол</h4>
            </div>
            <div class="modal-body">
                <h3 id="family">Фамилия</h3>
                <form id="formVal" class="form-horizontal form-label-left">
                    <div class="row text-center">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active text-uppercase"><input type="radio" name="options" id="goalgame" autocomplete="off" checked> ГОЛ</label>
                            <label class="btn btn-info"><input type="radio" name="options" id="goalpenalty" autocomplete="off"> Пенальти</label>
                            <label class="btn btn-info"><input type="radio" name="options" id="goalauto" autocomplete="off"> Автогол</label>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group row" id="assistantRow">
                        <label for="selname" class="control-label col-md-3 col-sm-3 col-xs-12">Ассистент</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="assistant">
                                <option value="0">Нет</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="gkRow">
                        <label for="selgk" class="control-label col-md-3 col-sm-3 col-xs-12">Вратарь</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="gk">
                                <option value="0">Нет</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row hidden" id="gkRowAG">
                        <label for="selgkAG" class="control-label col-md-3 col-sm-3 col-xs-12">Вратарь</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="gkAG">
                                <option value="0">Нет</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="selgkAG" class="control-label col-md-3 col-sm-3 col-xs-12">Минута</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="minute"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resultSaveGoal" class="btn btn-success">Записать</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal" id="dialogCard" role="dialogCard" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Карточка</h4>
            </div>
            <div class="modal-body">
                <h3 id="familyCard">Фамилия</h3>
                <form id="formValCard" class="form-horizontal form-label-left">
                    <div class="row text-center">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info active text-uppercase"><input type="radio" name="options" id="yellowcard" autocomplete="off" checked> <img src="{{ asset('/images/icons/yellow.png') }}" class="p-2">ЖК</label>
                            <label class="btn btn-info text-uppercase"><input type="radio" name="options" id="twoyellowcard" autocomplete="off"> <img src="{{ asset('/images/icons/yellow2.png') }}" class="p-2">2 ЖК</label>
                            <label class="btn btn-info text-uppercase"><input type="radio" name="options" id="redcard" autocomplete="off"> <img src="{{ asset('/images/icons/red.png') }}" class="p-2">КК</label>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group row" id="opponentRow">
                        <label for="selname" class="control-label col-md-3 col-sm-3 col-xs-12">Оппонент</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="opponent">
                                <option value="0">Нет</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="yellowcardReasonRow">
                        <label for="selgk" class="control-label col-md-3 col-sm-3 col-xs-12">Причина</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="yellowcardReason">
                                <option value="0">Нет</option>
                                @foreach($yellowCardReasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row hidden" id="redcardReasonRow">
                        <label for="selgk" class="control-label col-md-3 col-sm-3 col-xs-12">Причина</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="redcardReason">
                                <option value="0">Нет</option>
                                @foreach($redCardReasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteCard" class="control-label col-md-3 col-sm-3 col-xs-12">Минута</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="minuteCard"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resultSaveCard" class="btn btn-success">Записать</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<div id="ajax"></div>
@endsection

