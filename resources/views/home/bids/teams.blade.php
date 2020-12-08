
@extends('layouts.main')

@section('title')Команды в заявке @endsection

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
    <script type="text/javascript" src="{{ asset('resources/home/bidteams.js').'?v='.config('app.version') }}"></script>
@endsection

@section('content')
    @if($roles->contains(1) || $roles->contains(2)) <button type="button" class="btn btn-default" id="back">Назад, в соревнование</button> @endif
    <div class="ln_solid"></div>
    <div id="grid" data-back-route="{{ route('admin_showtournament', $tournament->id) }}"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>

    @component('components.main_block')
        @slot('title')Команды @endslot
        @slot('description')Команды в соревновании - {{ $tournament->name }}@endslot
        <div class="x_content">
            <ul class="list-unstyled msg_list">
            @foreach($teams as $team)
                <li>
                    <a href="{{ route('admin_showteam', array($team->id)) }}">
                        <div class="image">
                        @if(isset($team->logo))
                            @foreach($team->logo->thumb as $thumb)
                                @if($thumb->thumb_id == 6)
                                    <img height="60px" src="{{ $thumb->filename }}" alt="логотип {{ $team->name }}" />
                                @endif
                            @endforeach
                        @endif
                        </div>
                        <h2>{{ $team->name }}</h2>
                        <span class="message">Перейти в Личный кабинет команды</span>
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
    @endcomponent

@endsection

