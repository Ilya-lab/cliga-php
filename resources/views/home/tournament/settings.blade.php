
@extends('layouts.main')

@section('title')Настройки соревнования - «{{ $tournament->name }}» @endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxswitchbutton.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('js_footer')
<script type="text/javascript" src="{{ asset('resources/home/settings.js').'?v='.config('app.version') }}"></script>
@endsection

@section('content')
    <button type="button" class="btn btn-default" id="back">Назад, к соревнованию</button>
    <div id="grid" data-back-route="{{ route('admin_showtournament', $tournament->id) }}"></div>
    <div id="loader"></div>
    <div class="ln_solid"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>
    <div class="row m-3">
        @component('components.box_block')
            @slot('title')Формат @endslot
            @slot('description') Формат проведения соревнования @endslot
            <div id="ssettingsbox">
                123
            </div>
        @endcomponent

        @component('components.box_block')
            @slot('title')Настройки @endslot
            @slot('description') Настройки соревнования @endslot
            <div id="settingsbox">
                @include('home.tournament.ajax_tournsettings_view', ['settings' => $settings, 'roles' => $roles, 'tournament' => $tournament ])
            </div>
        @endcomponent

        @if($roles->contains(1))
        @component('components.box_block')
            @slot('title')Права доступа @endslot
            @slot('description') Пользователи, допущенные к соревнованию @endslot
            123
        @endcomponent
        @endif
    </div>
    <div id="ajax"></div>
@endsection

