@extends('layouts.main')

@section('title')Календарь соревнований @endsection

@section('js')<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxtabs.js').'?v='.config('app.version') }}"></script>
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
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdropdownbutton.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcalendar.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdatetimeinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxtree.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxpanel.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxtooltip.js').'?v='.config('app.version') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('js_footer')
<script type="text/javascript" src="{{ asset('resources/home/calendar.js').'?v='.config('app.version') }}"></script>
@endsection

@section('content')
<button type="button" class="btn btn-default" id="back">Назад, к соревнованию</button>
<div id="grid" data-back-route="{{ route('admin_showtournament', $tournament->id) }}" data-load-stages="{{ route('admin_showstages', $tournament->id) }}" data-save-route="{{ route('admin_savematch') }}" data-remove-route="{{ route('admin_removematch') }}" data-editview-route="{{ route('admin_editmatchview') }}" data-edit-route="{{ route('admin_editmatch') }}" data-resultview-route="{{ route('admin_resultmatchview') }}" data-result-route="{{ route('admin_resultmatch') }}" data-cancelresult-route="{{ route('admin_cancelresultmatch') }}"></div>
<div id="loader"></div>
<div class="ln_solid"></div>
<div id="messageNotification">
    <div id="message"></div>
</div>

<div class="row m-3">
    <h2>{{ $tournament->name }}</h2>
    <div class="col-md-8 col-sm-4 col-xs-12">
    @component('components.big_block')
        @slot('title')Календарь игр @endslot
        @slot('description') Предстоящие либо идущие матчи @endslot
        <div id='tabNextMatch'>
            <ul>
            @foreach($stages as $stage)
                <li item-expanded="true" value="{{ $stage->id }}">{{ $stage->name }}</li>
            @endforeach
            </ul>
            @php $maxn = 0; @endphp
            @foreach($stages as $stage)
            <div class="m-3">
                <table class="w-100" id="table-{{ $stage->id }}">
                    <tr>
                        <th class="text-center hidden-xs">#</th>
                        <th class="text-center">Дата</th>
                        <th class="text-center hidden-xs"></th>
                        <th class="text-center hidden-xs">Арена (площадка)</th>
                        <th class="text-center">Хозяева</th>
                        <th class="text-center"></th>
                        <th class="text-center">Гости</th>
                    </tr>
                    <tbody>
                    @php $tour = 0;  $mx = $stage->matches->max('number'); if($mx > $maxn) $maxn = $mx; @endphp
                    @foreach($stage->matches as $game)
                    @if($tour != $game->tour->id)
                        <tr>
                            <td colspan="7" class="text-center"><h5><strong><u>{{ $game->tour->shortname }}</u></strong></h5></td>
                        </tr>
                        @php $tour = $game->tour->id; @endphp
                    @endif
                    <tr class="popoverable border-top @if($loop->index % 2 == 0 && $game->status_id == 0) bg-light @endif @if($game->status_id == 1) bg-blue-sky @endif" data-match-id="{{ $game->id }}" data-match-status="{{ $game->status_id }}" data-match-completed=@if(!$game->home || !$game->away) "0" @else "1" @endif>
                        <td class="text-center p-2 hidden-xs">{{ $game->number }}</td>
                        <td class="text-center"><small>@if($game->datetime){{ date('d.m.y   H:i', strtotime($game->datetime)) }}@endif</small></td>
                        <td class="text-center hidden-xs"><small>{{ $game->stage->shortname }}</small></td>
                        <td class="text-center hidden-xs">{{ $game->place->field->arena->name }} @if($game->place->field->number > 0) ({{ $game->place->field->number }}) @endif</td>
                        <td class="text-right">@if($game->home){{ $game->home->name }} @else<small class="red">нет</small>@endif</td>
                        <td class="text-center">-</td>
                        <td class="text-left">@if($game->away){{ $game->away->name }}@else<small class="red">нет</small>@endif</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    @endcomponent
    @component('components.big_block')
        @slot('title')Сыгранные матчи @endslot
        @slot('description') Оконченные матчи @endslot
        <div id='tabFinishMatch'>
            <ul>
                @foreach($stagesFinish as $stage)
                    <li item-expanded="true" value="{{ $stage->id }}">{{ $stage->name }}</li>
                @endforeach
            </ul>
            @php $maxn = 0; @endphp
            @foreach($stagesFinish as $stage)
                <div class="m-3">
                    <table class="w-100" id="tableFinish-{{ $stage->id }}">
                        <tr>
                            <th class="text-center hidden-xs">#</th>
                            <th class="text-center">Дата</th>
                            <th class="text-center hidden-xs"></th>
                            <th class="text-center hidden-xs">Арена (площадка)</th>
                            <th class="text-center">Хозяева</th>
                            <th class="text-center"></th>
                            <th class="text-center">Гости</th>
                        </tr>
                        <tbody>
                        @php $tour = 0;  $mx = $stage->matches->max('number'); if($mx > $maxn) $maxn = $mx; @endphp
                        @foreach($stage->matches as $game)
                            @if($tour != $game->tour->id)
                                <tr>
                                    <td colspan="7" class="text-center"><h5><strong><u>{{ $game->tour->shortname }}</u></strong></h5></td>
                                </tr>
                                @php $tour = $game->tour->id; @endphp
                            @endif
                            <tr class="popoverable border-top @if($loop->index % 2 == 0 && $game->status_id != 4) bg-light @endif @if($game->status_id == 4) bg-blue-sky @endif" data-match-id="{{ $game->id }}" data-match-status="{{ $game->status_id }}" data-match-completed=@if(!$game->home || !$game->away) "0" @else "1" @endif>
                                <td class="text-center p-2 hidden-xs">{{ $game->number }}</td>
                                <td class="text-center"><small>@if($game->datetime){{ date('d.m.y   H:i', strtotime($game->datetime)) }}@endif</small></td>
                                <td class="text-center hidden-xs"><small>{{ $game->stage->shortname }}</small></td>
                                <td class="text-center hidden-xs">{{ $game->place->field->arena->name }} @if($game->place->field->number > 0) ({{ $game->place->field->number }}) @endif</td>
                                <td class="text-right">@if($game->home){{ $game->home->name }} @else<small class="red">нет</small>@endif</td>
                                <td class="text-center @if($game->technicalmissed) red @endif">{{ $game->homescore }} : {{ $game->awayscore }}</td>
                                <td class="text-left">@if($game->away){{ $game->away->name }}@else<small class="red">нет</small>@endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endcomponent
    </div>
    @if(!$closed)
    @component('components.box_block')
        @slot('title')Добавить игру @endslot
        @slot('description') Добавить игру к календарю @endslot
        <div>Этап соревнования</div>
        <div id="dropDownButton" class="position-sticky">
            <div id="level" class="position-sticky" style="border: none;">

            </div>
        </div>
        <div style="padding-top: 20px;">Номер матча</div>
        <div id="number" class="position-sticky"></div>
        <div style="padding-top: 20px;">Дата и время матча</div>
        <div id="datetime" class="position-sticky"></div>
        <div style="padding-top: 20px;">Тур (стадия) матча</div>
        <select id="tour" class="position-sticky">
            @foreach($tours as $tour)
            <option value="{{ $tour->id }}">{{ $tour->name }}</option>
            @endforeach
        </select>
        <div style="padding-top: 20px;">Арена (площадка)</div>
        <select id="arena" class="position-sticky">
            <option value="0">Не выбрано</option>
            @foreach($arenas as $arena)
                @if($arena->field && $arena->field->arena)
            <option value="{{ $arena->id }}">{{ $arena->field->arena->name }} ({{ $arena->field->name }})</option>
                @endif
            @endforeach
        </select>
        <div style="padding-top: 20px;">Команда хозяев</div>
        <select id="home" class="position-sticky">
            <option value="0">Не выбрано</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->city }})</option>
            @endforeach
        </select>
        <div style="padding-top: 20px;">Команда гостей</div>
        <select id="away" class="position-sticky">
            <option value="0">Не выбрано</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->city }})</option>
            @endforeach
        </select>
        <div style="padding-top: 20px;">Следующий матч сдвинуть на минут</div>
        <div id="nextmatch" class="position-sticky"></div>
        <div class="text-center"><button type="submit" id="save_button" class="btn btn-primary navbar-btn">Добавить</button></div>
    @endcomponent
    @endif

</div>
<input id="closed" type="hidden" value=" {{ $closed ? 1 : 0 }}">
<input id="tournament-id" type="hidden" value="{{ $tournament->id }}">
<input id="max-number-match" type="hidden" value="{{ $maxn }}">
<div id="ajax"></div>
@endsection

