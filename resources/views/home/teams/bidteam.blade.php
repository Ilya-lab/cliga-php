@extends('layouts.main')

@section('title')Заявочное окно «{{ $bid->name }}» команды «{{ $team->name }}» ({{ $team->city }}) @endsection

@section('js')<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/globalization/globalize.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/globalization/globalize.culture.ru-RU.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcombobox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('js_footer')
<script type="text/javascript" src="{{ asset('resources/home/bidplayers.js').'?v='.config('app.version') }}"></script>
@endsection

@section('content')
<button type="button" class="btn btn-default" id="back">Назад, к команде</button>
<div id="grid" data-back-route="{{ route('admin_showteam', $team->id) }}"  data-load-route="{{ route('person_ajaxbidload') }}" data-path="" data-back-route="{{ route('admin_showteam', $team->id) }}" data-save-player="{{ route("admin_savebidteamperson", [$team->id, $bid->id]) }}" data-remove-player="{{ route("admin_removebidteamperson", [$team->id, $bid->id]) }}" data-cancelremove-player="{{ route("admin_cancelremovebidteamperson", [$team->id, $bid->id]) }}"></div>
<div id="loader"></div>
<div class="ln_solid"></div>
<div id="messageNotification">
    <div id="message"></div>
</div>

<div class="row">
    <div class="image">
        @if(isset($team->logo))
            @foreach($team->logo->thumb as $thumb)
                @if($thumb->thumb_id == 5)
                    <div class="left"><img src="{{ $thumb->filename }}" alt="логотип {{ $team->name }}" class="mr-5" /></div>
                @endif
            @endforeach
        @endif
    </div>
    <h1>{{ $team->name }} ({{ $team->city }})</h1>
</div>
<div class="row m-3">
    <h2>Заявочное окно «{{ $bid->name }}». Команда «{{ $team->name }}» ({{ $team->city }}) в турнире «{{ $tournament->name }}».</h2>
    @component('components.box_block')
        @slot('title')Текущий состав @endslot
        @slot('description') @endslot
        <h3>Игроки</h3>
        <table class="w-100" id="table-players">
            <tr>
                <th align="center">#</th>
                <th align="center">Игрок</th>
                <th align="center">Позиция</th>
                @if($tournament->status_id <= 1)<th align="center"></th>@endif
            </tr>
            <tbody>
            @foreach($players as $player)
            <tr data-bidplayer="{{ $player->id }}" class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                <td class="text-center">@if($player->number > 0){{ $player->number }}@endif</td>
                <td class="text-left p-3"><a href="{{ route('person', $player->person->url) }}">{{ $player->family }} {{ $player->name }} @if($player->captain->id > 0) ({{$player->captain->shortname}})@endif</a></td>
                <td class="text-center">{{ $player->position->shortname }}</td>
                @if($tournament->status_id <= 1)<td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td>@endif
            </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($players) > 0)
        <p>Итого в составе - <strong class="red" id="playercount">{{ count($players) }}</strong></p>
        @else
            <p class="text-center">нет</p>
        @endif
        <div class="x_title"></div>
        <h3>Персонал</h3>
            <table class="w-100" id="table-coaches">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                    @if($tournament->status_id <= 1)<th align="center"></th>@endif
                </tr>
                <tbody>
                @foreach($admins as $player)
                    <tr data-bidplayer="{{ $player->id }}" class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">{{ $loop->index + 1 }}.</td>
                        <td class="text-left p-3"><a href="/"><a href="{{ route('person', $player->person->url) }}">{{ $player->family }} {{ $player->name }}</a></a></td>
                        <td class="text-center">{{ $player->post->name }}</td>
                        @if($tournament->status_id <= 1)<td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td>@endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @if(count($admins) > 0)
            <p>Итого в составе - <strong class="red" id="coachcount">{{ count($admins) }}</strong></p>
        @else
            <p class="text-center">нет</p>
        @endif
    @endcomponent

    @if($tournament->status_id <= 1)
    @component('components.box_block')
        @slot('title')Заявить участника @endslot
        @slot('description')Добавление в заявочный лист @endslot
            <div>Тип заявки</div>
            <select id="typebid" name="typebid" style="width: 100%;">
                <option value="0" >Игрок</option>
                <option value="1" >Администрация и тренеры</option>
            </select>
            <div style="padding-top: 20px;">Участник</div>
            <div id="players" class="position-sticky"></div>
            <small id="choice"><span class="red"> не выбран </span></small>
            @if($currentPlayer == null)
<input type="hidden" id="player" name="player"  value="0">
            <input type="hidden" id="_playerName"  value="">
@else
<input type="hidden" id="player" name="player"  value="{{ $currentPlayer->id }}">
            <input type="hidden" id="_playerName"  value="{{ $currentPlayer->fio }}">
@endif
            <input type="hidden" id="photo_id" name="photo_id"  value="0" >
            <input type="hidden" id="bid_id" name="bid_id" value="{{ $bid->id }}">
            <input type="hidden" id="team_id" name="team_id" value="{{ $team->id }}">
            @if($currentPlayerAttr->has('type') && $currentPlayerAttr->get('type') == 0)
            <div id="number_text">Номер игрока в команде</div>
            <div id="number" name="number" style="width: 100%;"></div>
            <div id="position_text" style="padding-top: 20px;">Позиция игрока в команде</div>
            <select id="position" name="position" style="width: 100%;">
            @foreach($positions as $position)
                <option value="{{ $position->id }}" >{{ $position->name }}</option>
            @endforeach
            </select>

            <div id="captain_text" style="padding-top: 20px;">Капитан в команде</div>
            <select id="captain" name="position" style="width: 100%;">
                @foreach($captains as $captain)
                    <option value="{{ $captain->id }}" >{{ $captain->name }}</option>
                @endforeach
            </select>
            <div id="dol_text" class="hidden">Должность в команде</div>
            <select id="dol" name="dol" style="width: 100%;" class="hidden">
                @foreach($dols as $dol)
                    <option value="{{ $dol->id }}" >{{ $dol->name }}</option>
                @endforeach
            </select>
            @else
                <div id="number_text" class="hidden">Номер игрока в команде</div>
                <div id="number" class="hidden" name="number" style="width: 100%;"></div>
                <div id="position_text" class="hidden" style="padding-top: 20px;">Позиция игрока в команде</div>
                <select id="position" name="position" class="hidden" style="width: 100%;">
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" >{{ $position->name }}</option>
                    @endforeach
                </select>

                <div id="captain_text" class="hidden" style="padding-top: 20px;">Капитан в команде</div>
                <select id="captain" name="position" class="hidden" style="width: 100%;">
                    @foreach($captains as $captain)
                        <option value="{{ $captain->id }}" >{{ $captain->name }}</option>
                    @endforeach
                </select>
                <div id="dol_text">Должность в команде</div>
                <select id="dol" name="dol" style="width: 100%;">
                    @foreach($dols as $dol)
                        <option value="{{ $dol->id }}" >{{ $dol->name }}</option>
                    @endforeach
                </select>
            @endif
            <div style="padding-top: 20px;">Фотография игрока</div>
            <select id="photo" name="photo" style="width: 100%;">
                <option value="0">/storage/images/no_image.png</option>
            </select>
            <div class="text-center">
                <button type="submit" id="save_button" class="btn btn-primary navbar-btn" disabled>Записать</button>
                <button type="button" id="photo_button" class="btn btn-secondary navbar-btn" disabled>Новое фото</button>
                @if($roles->contains(1)) <button type="button" class="btn btn-secondary navbar-btn" onclick="document.location.href = '/home/players/add/frombid/151/590';">Новый игрок</button> @endif
            </div>
            @if($roles->contains(1))

            @endif
    @endcomponent
    @endif
    @component('components.box_block')
        @slot('title')Заявочный лист игроков@endslot
        @slot('description')Результат заявки @endslot
            <h2><u>Заявленные игроки</u></h2>
            <table class="w-100" id="table-players-on-bid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                </tr>
                <tbody>
                @foreach($bidplayers as $player)
                    <tr data-bidplayer="{{ $player->id }}"  class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">@if($player->number > 0){{ $player->number }}@endif</td>
                        <td class="text-left p-3"><a href="{{ route('person', $player->person->url) }}">{{ $player->family.' '.$player->name }} @if($player->captain_id > 0) ({{ $player->captain->shortname }}) @endif</a></td>
                        <td class="text-center">{{ $player->position->shortname }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($bidplayers) > 0)
                <p>Итого за заявочное окно - <strong class="red" id="bidplayercount">{{ count($bidplayers) }}</strong></p>
            @else
                <p class="text-center">нет</p>
            @endif
            <div class="x_title"></div>
            <h2><u>Отзаявленные игроки</u></h2>
            <table class="w-100" id="table-players-on-unbid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                    @if($tournament->status_id <= 1)<th align="center"></th>@endif
                </tr>
                <tbody>
                @foreach($unbidplayers as $player)
                    <tr data-bidplayer="{{ $player->id }}"  class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">@if($player->number > 0){{ $player->number }}@endif</td>
                        <td class="text-left p-3"><a href="{{ route('person', $player->person->url) }}">{{ $player->family.' '.$player->name }} @if($player->captain_id > 0) ({{ $player->captain->shortname }}) @endif</a></td>
                        <td class="text-center">{{ $player->position->shortname }}</td>
                        @if($tournament->status_id <= 1)<td class="text-center remove"><i class="fa fa-close" title="Вернуть в команду"></i></td>@endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($unbidplayers) > 0)
                <p>Итого за заявочное окно - <strong class="red" id="unbidplayercount">{{ count($unbidplayers) }}</strong></p>
            @else
                <p class="text-center">нет</p>
            @endif
    @endcomponent
    @component('components.box_block')
        @slot('title')Заявочный лист административных лиц@endslot
        @slot('description')Результат заявки @endslot
            <h2><u>Заявленные представители</u></h2>
            <table class="w-100" id="table-coaches-on-bid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Фамилия Имя Отчество</th>
                    <th align="center">Должность</th>
                </tr>
                <tbody>
                @foreach($bidadmins as $player)
                    <tr data-bidplayer="{{ $player->id }}" class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td class="text-left p-3"><a href="/"><a href="{{ route('person', $player->person->url) }}">{{ $player->family.' '.$player->name }} @if($player->captain_id > 0) ({{ $player->captain->shortname }}) @endif</a></a></td>
                        <td class="text-center">{{ $player->post->name }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($bidadmins) > 0)
                <p>Итого за заявку - <strong class="red" id="bidcoachcount">{{ count($bidadmins) }}</strong></p>
            @else
                <p class="text-center">нет</p>
            @endif

            <h2><u>Отзаявленные представители</u></h2>
            <table class="w-100" id="table-coaches-on-unbid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Фамилия Имя Отчество</th>
                    <th align="center">Должность</th>
                    @if($tournament->status_id <= 1)<th align="center"></th>@endif
                </tr>
                <tbody>
                @foreach($unbidadmins as $player)
                    <tr data-bidplayer="{{ $player->id }}" class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td class="text-left p-3"><a href="/"><a href="{{ route('person', $player->person->url) }}">{{ $player->family.' '.$player->name }} @if($player->captain_id > 0) ({{ $player->captain->shortname }}) @endif</a></a></td>
                        <td class="text-center">{{ $player->post->name }}</td>
                        @if($tournament->status_id <= 1)<td class="text-center remove"><i class="fa fa-close" title="Вернуть в команду"></i></td>@endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($unbidadmins) > 0)
                <p>Итого за заявку - <strong class="red" id="unbidcoachcount">{{ count($unbidadmins) }}</strong></p>
            @else
                <p class="text-center">нет</p>
            @endif
    @endcomponent
</div>
<input id="tourn_status" type="hidden" value="{{ $tournament->status_id }}">
@if($currentPlayerAttr->has('type')) <input id="_typebid" type="hidden" value="{{ $currentPlayerAttr->get('type') }}">
@else <input id="_typebid" type="hidden" value="0">
@endif
@if($currentPlayerAttr->has('dol')) <input id="_dol" type="hidden" value="{{ $currentPlayerAttr->get('dol') }}">
@else <input id="_dol" type="hidden" value="0">
@endif
@if($currentPlayerAttr->has('number')) <input id="_number" type="hidden" value="{{ $currentPlayerAttr->get('number') }}">
@else <input id="_number" type="hidden" value="0">
@endif
@if($currentPlayerAttr->has('position')) <input id="_position" type="hidden" value="{{ $currentPlayerAttr->get('position') }}">
@else <input id="_position" type="hidden" value="0">
@endif
@if($currentPlayerAttr->has('captain')) <input id="_captain" type="hidden" value="{{ $currentPlayerAttr->get('captain') }}">
@else <input id="_captain" type="hidden" value="0">
@endif


@endsection

