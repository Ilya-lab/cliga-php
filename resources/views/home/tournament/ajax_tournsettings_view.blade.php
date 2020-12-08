<div class="m-3">
    <table class="w-100" id="table-settings">
        <tr>
            <th class="text-center">Наименование</th>
            <th class="text-center" colspan="2">Значение</th>
        </tr>
        <tbody>
        @if($roles->contains(1))
            @foreach($settings as $setting)
                <tr class="border-top @if($loop->index % 2 == 0) bg-light @endif " data-setting-id="{{ $setting->key }}">
                    <td class="text-left p-3">{{ $setting->name }}</td>
                    @if($setting->type_field == "bool")
                    <td align="center" class="text-center"><input type="checkbox" id="{{ $setting->key }}" class="{{ $setting->type_field }}" {{ $setting->value == 1 ? 'checked' : '' }}></td>
                    @else
                    <td class="text-center"><input id="{{ $setting->key }}" class="{{ $setting->type_field }}" value="{{ $setting->value }}"></td>
                    @endif
                    <td class="text-center remove"><i class="fa fa-close" title="Удалить событие"></i></td>
                </tr>
            @endforeach
        @else
        @foreach($settings as $setting)
            <tr class="border-top @if($loop->index % 2 == 0) bg-light @endif " data-setting-id="{{ $setting->key }}">
                <td class="text-left p-3">{{ $setting->name }}</td>
                <td class="text-center">{{ $setting->value }}</td>
                <td></td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
    @if($roles->contains(1))
        <div class="row mt-5">
            <button id="addButton" class="btn btn-primary">Добавить</button>
        </div>
    @endif
</div>
<p>Итого настроек в соревновании: <strong class="red">{{ $settings->count() }}</strong></p>
<script>
    if($("input").is(".uint")) {
        $('.uint').jqxNumberInput({ width: '70px', height: '30px', spinButtons: true, digits: 3,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 150, spinButtonsWidth: 20, textAlign: 'center',
            allowNull: true, theme: 'bootstrap' })
        $('.uint').on('valueChanged', function (event)
        {
            saveSetting($(this).parent().parent().attr('data-setting-id'), event.args.value)
        })
    }
    if($("input").is(".bool")) {
        $('.bool').jqxCheckBox({ height: 30, width: 70, theme: 'bootstrap' })
        $('.bool').on('change', function (event) {
            saveSetting($(this).parent().parent().attr('data-setting-id'), event.args.checked ? 1 : 0)
        })
    }
    @if($roles->contains(1))
    $( "#addButton" ).click(function(){
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('admin_tournsettingsview') }}',
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
                // загружена форма ввода состава команды
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
        console.log('LL')
        if (!confirm('Удалить настройку соревнования?')) return false

            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('setting_remove') }}',
                data: { id: {{ $tournament->id }}, key: $(this).parent().attr('data-setting-id'), table: true },
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                try {
                    response = JSON.parse(response)
                } catch(errorThrown) {
                    console.log(errorThrown)
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
                    // обработка ответа
                    $('#settingsbox').html(response['table'])
                    $("#message").html(response['text'])
                    $('#messageNotification').jqxNotification({ template: 'info' })
                    $("#messageNotification").jqxNotification("open")
                }
            }).fail(function(response, textStatus, errorThrown) {
                $('#loader').jqxLoader('close')
                console.log('fail' + response)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
    })

    function saveSetting(key, value) {
       $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('setting_change') }}',
            data: { id: {{ $tournament->id }}, key: key, value: value, table: true },
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            try {
                response = JSON.parse(response)
            } catch(errorThrown) {
                console.log(errorThrown)
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
                // обработка ответа
                $('#settingsbox').html(response['table'])
                $("#message").html(response['text'])
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            console.log('fail' + response)
            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    }
    @endif
</script>
