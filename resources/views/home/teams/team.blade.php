
@extends('layouts.main')

@section('title')Команда "{{ $team->name }}" ({{ $team->city }} в заявке на {{ $tournament->name }} @endsection

@section('js')<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxgrid.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxgrid.selection.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxgrid.pager.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxgrid.columnsresize.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/globalization/globalize.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/globalization/globalize.culture.ru-RU.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxvalidator.js').'?v='.config('app.version') }}"></script>

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('js_footer')
    <script type="text/javascript" src="{{ asset('resources/home/bidteam.js').'?v='.config('app.version') }}"></script>
@endsection

@section('content')
    <button type="button" class="btn btn-default" id="back">Назад, в соревнование</button>
    <div class="ln_solid"></div>
    <div id="grid" data-back-route="{{ route('admin_showbidteams', $tournament->id) }}"></div>
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

    <div class="row">
    @component('components.box_block')
        @slot('title')Заявочные окна @endslot
        @slot('description') @endslot
       <table class="w-100">
           <tr>
               <th align="center">#</th>
               <th align="center">Наименование</th>
               <th align="center">Начало</th>
               <th align="center">Окончание</th>
           </tr>
           <tbody>
           @foreach($bids as $bid)
               <tr class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                   <td class="text-center">{{ $loop->index + 1 }}.</td>
                   <td class="text-left p-3"><a href="{{ route('admin_showbidteam', [$team->id, $bid->id]) }}">{{ $bid->name }}</a></td>
                   <td class="text-center">{{ date('d.m.Y', strtotime($bid->start)) }}</td>
                   <td class="text-center">{{ date('d.m.Y', strtotime($bid->finish)) }}</td>
               </tr>
           @endforeach
           </tbody>
       </table>
    @endcomponent
    @component('components.box_block')
        @slot('title')Игроки @endslot
        @slot('description')Заявленные игроки @endslot
            <table class="w-100" id="table-players">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                </tr>
                <tbody>
                @foreach($players as $player)
                    <tr data-bidplayer="{{ $player->id }}" class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">@if($player->number > 0){{ $player->number }}@endif</td>
                        <td class="text-left p-3"><a href="{{ route('person', $player->person->url) }}">{{ $player->family }} {{ $player->name }} @if($player->captain->id > 0) ({{$player->captain->shortname}})@endif</a></td>
                        <td class="text-center">{{ $player->position->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($players) > 0)
                <p>Итого в составе - <strong class="red" id="playercount">{{ count($players) }}</strong></p>
            @else
                <p class="text-center">нет</p>
            @endif
    @endcomponent
    @component('components.box_block')
        @slot('title')Администрация @endslot
        @slot('description')Заявленные представители команды @endslot
            <table class="w-100" id="table-coaches">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                </tr>
                <tbody>
                @foreach($admins as $player)
                    <tr data-bidplayer="{{ $player->id }}" class="border-top @if($loop->index % 2 == 0)bg-light @endif">
                        <td class="text-center">{{ $loop->index + 1 }}.</td>
                        <td class="text-left p-3"><a href="/"><a href="{{ route('person', $player->person->url) }}">{{ $player->family }} {{ $player->name }}</a></a></td>
                        <td class="text-center">{{ $player->post->name }}</td>
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
    @component('components.box_block')
        @slot('title')Стадион @endslot
        @slot('description')Заявленный стадион команды @endslot
        Пока не реализовано
    @endcomponent
    </div>
@endsection

