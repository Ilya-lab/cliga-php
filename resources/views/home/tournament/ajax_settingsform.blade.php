<div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Настройки турнира «{{ $tournament->name }}»</h4>
            </div>
            <div class="modal-body">
                <form id="formValCard" class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Настройка</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="comboboxSettings" class="w-100">
                            @foreach($settings as $setting)
                                @if(!$currentSetting->contains('key', $setting->key))
                                <option value="{{ $setting->key }}">{{ $setting->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resultButton" class="btn btn-success">Добавить</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#comboboxSettings').jqxDropDownList({ width: '100%', height: 30, theme: 'bootstrap'})
    $('#dialog').modal('toggle')

    $( "#resultButton").click(function(){
        $('#dialog').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('setting_add') }}',
            data: { id: {{ $tournament->id }}, key: $('#comboboxSettings').val(), table: true },
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
                // загружен состав команды
                $("#settingsbox").html(response['table'])

                $("#message").html(response['text'])
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
            console.log('fail' + response)
        })
    })
</script>
