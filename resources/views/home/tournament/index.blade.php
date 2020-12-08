
@extends('layouts.main')

@section('title')Турнир - «{{ $tournament->name }}» @endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxtabs.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxtree.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('js_footer')
@endsection

@section('content')
    @component('components.main_block')
        @slot('title')Турнир @endslot
        @slot('description'){{ $tournament->name }} @endslot
            @if($roles->contains(1))
            @component('components.small_block')
                @slot('title')Заявки @endslot
                @slot('url'){{ route('admin_showbids', $tournament->id) }} @endslot
                @slot('icon')fa-book @endslot
                @slot('description')Список заявок @endslot
            @endcomponent
            @endif

        @if($roles->contains(1) || $roles->contains(2))
            @component('components.small_block')
                @slot('title')Команды @endslot
                @slot('url'){{ route('admin_showbidteams', $tournament->id) }} @endslot
                @slot('icon')fa-group @endslot
                @slot('description')Действия над командой @endslot
            @endcomponent
        @endif

        @if($roles->contains(1))
            @component('components.small_block')
                @slot('title')Календарь @endslot
                @slot('url'){{ route('admin_calendar', $tournament->id) }} @endslot
                @slot('icon')fa-calendar @endslot
                @slot('description')Расписание матчей @endslot
            @endcomponent
        @endif

        @if($roles->contains(1))
            @component('components.small_block')
                @slot('title')Таблицы @endslot
                @slot('url')/ @endslot
                @slot('icon')fa-th-list @endslot
                @slot('description')Корректировка таблиц @endslot
            @endcomponent
        @endif

        @if($roles->contains(1))
            @component('components.small_block')
                @slot('title')Дисквалификации @endslot
                @slot('url'){{ route('admin_showdisq', $tournament->id) }} @endslot
                @slot('icon')fa-stop @endslot
                @slot('description')Дисквалификации участников @endslot
            @endcomponent
        @endif

        @if($roles->contains(1))
            @component('components.small_block')
                @slot('title')Настройки @endslot
                @slot('url'){{ route('admin_settings', $tournament->id) }} @endslot
                @slot('icon')fa-cogs @endslot
                @slot('description')Установки соревнования @endslot
            @endcomponent
        @endif
    @endcomponent
    <div class="row m-3">
        <div id="grid" data-load-stages="{{ route('admin_showstages', $tournament->id) }}"></div>
        <div class="col-md-8 col-sm-4 col-xs-12">
    @component('components.big_block')
        @slot('title')Формат соревнования @endslot
        @slot('description') Этапы турнира @endslot
        <div id='tabStage'>
            <ul>
                <li>Структура турнира</li>
                @foreach($stages as $stage)
                    <li value="{{ $stage->id }}">{{ $stage->name }}</li>
                @endforeach
            </ul>
            <div class="m-3">
                <div id="level" class="position-sticky"></div>
            </div>
            @foreach($stages as $stage)
                <div class="m-3">
                    @if($stage->levels_id == 3)
                        @if($stage->table->count() > 0)
                            <table class="w-100">
                                <tr>
                                    <th class="text-center w-5">#</th>
                                    <th class="text-center w-auto">Команда</th>
                                    <th class="text-center w-10 hidden-xs">И</th>
                                    <th class="text-center w-10 hidden-xs">В</th>
                                    <th class="text-center w-10 hidden-xs">Н</th>
                                    <th class="text-center w-10 hidden-xs">П</th>
                                    <th class="text-center w-10 hidden-xs">Мячи</th>
                                    <th class="text-center w-10">О</th>
                                </tr>
                                <tbody>
                                @foreach($stage->table as $team)
                                    <tr class="border-top @if($loop->index % 2 == 0) bg-light @endif">
                                        <td class="text-center p-2">@if($team->place > 0) {{ $team->place }} @endif</td>
                                        <td class="text-left">{{ $team->team->name }} ({{ $team->team->city }})</td>
                                        <td class="text-center hidden-xs">{{ $team->win + $team->los + $team->nic }}</td>
                                        <td class="text-center hidden-xs">{{ $team->win }}</td>
                                        <td class="text-center hidden-xs">{{ $team->nic }}</td>
                                        <td class="text-center hidden-xs">{{ $team->los }}</td>
                                        <td class="text-center hidden-xs">{{ $team->zab }} - {{ $team->prop }}</td>
                                        <td class="text-center">{{ $team->points }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        @foreach($stage->child as $group)
                            <h2>{{ $group->name }}</h2>
                            <table class="w-100">
                                <tr>
                                    <th class="text-center w-5">#</th>
                                    <th class="text-center w-auto">Команда</th>
                                    <th class="text-center w-10 hidden-xs">И</th>
                                    <th class="text-center w-10 hidden-xs">В</th>
                                    <th class="text-center w-10 hidden-xs">Н</th>
                                    <th class="text-center w-10 hidden-xs">П</th>
                                    <th class="text-center w-10 hidden-xs">Мячи</th>
                                    <th class="text-center w-10">О</th>
                                </tr>
                                <tbody>
                                @foreach($group->table as $team)
                                    <tr class="border-top @if($loop->index % 2 == 0) bg-light @endif">
                                        <td class="text-center p-2">@if($team->place > 0) {{ $team->place }} @endif</td>
                                        <td class="text-left">{{ $team->team->name }} ({{ $team->team->city }})</td>
                                        <td class="text-center hidden-xs">{{ $team->win + $team->los + $team->nic }}</td>
                                        <td class="text-center hidden-xs">{{ $team->win }}</td>
                                        <td class="text-center hidden-xs">{{ $team->nic }}</td>
                                        <td class="text-center hidden-xs">{{ $team->los }}</td>
                                        <td class="text-center hidden-xs">{{ $team->zab }} - {{ $team->prop }}</td>
                                        <td class="text-center">{{ $team->points }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    @endcomponent
        </div>
    @component('components.box_block')
        @slot('title')Календарь матчей @endslot
        @slot('description') Сортировка по турам @endslot
            <table class="w-100" id="tableFinish-{{ $stage->id }}">
                <tr>
                    <th class="text-center">Дата</th>
                    <th class="text-center hidden-xs"></th>
                    <th class="text-center">Хозяева</th>
                    <th class="text-center"></th>
                    <th class="text-center">Гости</th>
                </tr>
                <tbody>
                @php $tour = 0; @endphp
                @foreach($matches as $game)
                    @if($tour != $game->tour->id)
                        <tr>
                            <td colspan="7" class="text-center"><h5><strong><u>{{ $game->tour->shortname }}</u></strong></h5></td>
                        </tr>
                        @php $tour = $game->tour->id; @endphp
                    @endif
                    <tr class="popoverable border-top @if($loop->index % 2 == 0 && $game->status_id != 4) bg-light @endif @if($game->status_id == 4) bg-blue-sky @endif" data-match-id="{{ $game->id }}" data-match-status="{{ $game->status_id }}">
                        <td class="text-center"><small>@if($game->datetime){{ date('d.m.y   H:i', strtotime($game->datetime)) }}@endif</small></td>
                        <td class="text-center hidden-xs"><small>{{ $game->stage->shortname }}</small></td>
                        <td class="text-right">@if($game->home){{ $game->home->name }} @else<small class="red">нет</small>@endif</td>
                        <td class="text-center @if($game->technicalmissed) red @endif">{{ $game->homescore }} : {{ $game->awayscore }}</td>
                        <td class="text-left">@if($game->away){{ $game->away->name }}@else<small class="red">нет</small>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    @endcomponent
    </div>
    <script>
        $(document).ready(function () {
            $('#tabStage').jqxTabs({width: '100%', position: 'top'})
            var source = {
                datatype: "json",
                type: "GET",
                datafields: [
                    { name: 'id' },
                    { name: 'parent_id' },
                    { name: 'levels_id' },
                    { name: 'name' },
                    { name: 'shortname'},
                    { name: 'priority' },
                ],
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('loadStages'),
                async: false,
            }
            var dataAdapter = new $.jqx.dataAdapter(source, {
                beforeLoadComplete: function (records) {
                    for(var i=0; i<records.length; i++) {
                        if(i==0) records[i]['selected'] = true
                        if(records[i]['parent_id'] === null) records[i]['parent_id'] = 0;
                        records[i]['expanded'] = true
                    }
                    return records;
                }
            })
            dataAdapter.dataBind()
            var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{ name: 'name', map: 'label'},{ name: 'id', map: 'value'}])
            $('#level').jqxTree({ source: records, width: '99%', theme: 'bootstrap'})
        })
    </script>
@endsection

