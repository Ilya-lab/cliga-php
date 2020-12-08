
@extends('layouts.main')

@section('title')Дисквалифицированные игроки @endsection

@section('js')<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcombobox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxdropdownbutton.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version') }}"></script>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version') }}" type="text/css" />
@endsection

@section('js_footer')

@endsection

@section('content')
    <button type="button" class="btn btn-default" id="back">Назад, в соревнование</button>
    <div class="ln_solid"></div>
    <div id="grid" data-back-route="{{ route('admin_showtournament', $tournament->id) }}"></div>
    <div id="loader"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>

    @component('components.main_block')
        @slot('title')Дисквалификации @endslot
        @slot('description')Игроки, имеющие дисквалификации в туринре - {{ $tournament->name }}@endslot
        <div class="m-1">
            <table id="table-disq" class="w-100">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Игрок</th>
                    <th class="text-center hidden-xs">Позиция</th>
                    <th class="text-center hidden-xs">Команда</th>
                    <th class="text-center hidden-xs">Матч</th>
                    <th class="text-center"><div class="hidden-xs">Причина</div></th>
                    <th class="text-center">Кол.игр</th>
                    <th class="text-center">Ост.игр</th>
                    @if(!$closed)<th class="text-center"></th>@endif
                </tr>
                <tbody>
                @foreach($players as $player)
                    <tr class="border-top @if($loop->index % 2 == 0) bg-light @endif " data-id="{{ $player->id }}">
                        <td class="text-center p-2">{{ $loop->index + 1 }}</td>
                        <td class="text-left disqview" @if(!$closed)  style="cursor: pointer;" @endif>{{ $player->family }} {{ $player->name }}</td>
                        <td class="text-center hidden-xs"><small>{{ $player->position }}</small></td>
                        <td class="text-center hidden-xs"><small>{{ $player->team }}</small></td>
                        <td class="text-center hidden-xs"><small>{{ $player->home_team }} - {{ $player->away_team }}</small></td>
                        <td class="text-left"><img src="{{ $player->type_id == 1 ? asset('/images/icons/yellow.png') : asset('/images/icons/red.png') }}"><small class="ml-2 hidden-xs">{{ $player->comment }}</small></td>
                        <td class="text-center">{{ $player->matches }}</td>
                        <td class="text-center">{{ $player->elapsed }}</td>
                        @if(!$closed)<td class="text-center remove"><i class="fa fa-close" title="Удалить игрока из дисквалификации"></i></td>@endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <p>Итого дисквалификаций: <strong id="disq-count" class="red">{{ $players->count() }}</strong></p>
        @if(!$closed)
            <div class="row mt-5">
                <button id="addButton" class="btn btn-primary">Добавить</button>
            </div>
        @endif
    @endcomponent
<div id="ajax"></div>
<script>
    $(document).ready(function () {
        $('#back').on('click', function () {
            document.location.href = $('#grid').data('backRoute')
        })
        $('#addButton').on('click', function () {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('admin_tournadddisqplayerview') }}',
                data: {id: {{ $tournament->id }} },
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                try {
                    response = JSON.parse(response)
                } catch(errorThrown) {
                    console.log(errorThrown)
                    $('#loader').jqxLoader('close')
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                }

                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    // загружена форма вывода параметров дисквалификации
                    $('#ajax').html(response['text'])
                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('table').on('click', 'td.remove',function () {
            if (!confirm('Удалить дисквалификацию игрока?')) return false
            $.ajax({
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('admin_tourndeletedisqplayer') }}',
                data: {id: $(this).parent().attr("data-id") },
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                try {
                    response = JSON.parse(response)
                } catch(errorThrown) {
                    console.log(errorThrown)
                    $('#loader').jqxLoader('close')
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                }

                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                } else {
                    // удалить строку
                    $('table tbody tr[data-id="'+response['disq']['id']+'"]').remove()
                    $('#disq-count').html($('#table-disq tr').length-1)
                    $('#messageNotification').jqxNotification({ template: 'info' })
                }
                $("#message").html(response['text'])
                $("#messageNotification").jqxNotification("open")
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('table').on('click', 'td.disqview',function () {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('admin_tourndisqplayerview') }}',
                data: {id: $(this).parent().attr("data-id") },
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                try {
                    response = JSON.parse(response)
                } catch(errorThrown) {
                    console.log(errorThrown)
                    $('#loader').jqxLoader('close')
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                }

                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    // загружена форма вывода параметров дисквалификации
                    $('#ajax').html(response['text'])
                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
    })
</script>
@endsection

