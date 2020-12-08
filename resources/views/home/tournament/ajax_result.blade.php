<div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Результат матча</h4>
            </div>
            <div class="modal-body">
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
                                        <th width="45%" class="text-right">@if( $match->home){{ $match->home->name }}@else хозяева @endif</th>
                                        <th width="10%"></th>
                                        <th width="45%" class="text-left">@if( $match->away){{ $match->away->name }}@else гости @endif</th>
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
                                            <th width="45%" class="text-right">@if( $match->home){{ $match->home->name }}@else хозяева @endif</th>
                                            <th width="10%"></th>
                                            <th width="45%" class="text-left">@if( $match->away){{ $match->away->name }}@else гости @endif</th>
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
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Состояние матча</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="stateMatch"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Количество зрителей</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="viewerMatch"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Техническое поражение</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="techMatch">
                                <button style="padding:4px 16px;" id="homeTech">@if( $match->home){{ $match->home->name }}@else хозяевам @endif</button>
                                <button style="padding:4px 16px;" id="awayTech">@if( $match->away){{ $match->away->name }}@else гостям @endif</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resultButton" class="btn btn-success">Ввести результат</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<input id="level_id" type="hidden" value="{{ $match->mainstage->levels_id }}">
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxswitchbutton.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxbuttongroup.js').'?v='.config('app.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets/jqxradiobutton.js').'?v='.config('app.version') }}"></script>
<script>
    $('#dialog').modal('toggle')

    $('#stateMatch').jqxSwitchButton({ height: 27, width: 160,  checked: true, onLabel:'ЗАВЕРШЁН', offLabel: 'ИДЁТ' })
    $('#homeScore').jqxNumberInput({ value: {{ $match->homescore == null ? 0 : $match->homescore }}, width: 70, height: '35px', spinButtons: true, digits: 2,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
    $('#awayScore').jqxNumberInput({ value: {{ $match->awayscore == null ? 0 : $match->awayscore }}, width: 70, height: '35px', spinButtons: true, digits: 2,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
    $('#viewerMatch').jqxNumberInput({ value: {{ $match->viewers == null ? 0 : $match->viewers }}, width: 100, height: '35px', spinButtons: true, digits: 6,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 200000, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
    $('#techMatch').jqxButtonGroup({ template: "primary", mode: 'checkbox' });
    $('#resultButton').on('click', function () {

        $('#dialog').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('resultRoute'),
            data: {id: {{ $match->id }}, homeScore: $('#homeScore').val(), awayScore: $('#awayScore').val(), state: $('#stateMatch').val(), viewer: $('#viewerMatch').val(), tp: $('#techMatch').jqxButtonGroup('getSelection'), hasAddTime: $('#addtime').length > 0 ? $('#addtime').jqxCheckBox('checked') : false, hasPenalty: $('#penaltytime').length > 0 ? $('#penaltytime').jqxCheckBox('checked') : false, homeAddScore: $('#addtime').length > 0 ? $('#homeAddScore').val() : 0,awayAddScore: $('#addtime').length > 0 ? $('#awayAddScore').val() : 0,homePenaltyScore: $('#addtime').length > 0 ? $('#homePenaltyScore').val() : 0,awayPenaltyScore: $('#addtime').length > 0 ? $('#awayPenaltyScore').val() : 0,},
        }).done(function(response) {
            //response = JSON.parse(response)
            try {
                response = JSON.parse(response)
            } catch(errorThrown) {
                console.log(errorThrown)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            }
            $('#loader').jqxLoader('close')
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                var gg = $('#table-'+response['match']['mainstage_id']+' tbody tr[data-match-id="'+response['match']['id']+'"]')
                if(gg) {
                    gg.remove()
                    console.log(gg)
                    var table = $('#tableFinish-'+response['match']['mainstage_id']+' > tbody:last')
                    table.append("<tr><td colspan=\"7\" class=\"text-center\"><h5><strong><u>"+response['match']['tour']["shortname"]+"</u></strong></h5></td></tr>")
                    table.append('<tr class="popoverable border-top" data-match-id="'+response['match']['id']+'" data-match-status="2">\n' +
                        '                        <td class="text-center p-2 hidden-xs">'+response['match']['number']+'</td>\n' +
                        '                        <td class="text-center"><small>'+response['match']['datetime']+'</small></td>\n' +
                        '                        <td class="text-center hidden-xs"><small>'+response['match']['stage']['shortname']+'</small></td>\n' +
                        '                        <td class="text-center hidden-xs">'+response['match']['place']['field']['arena']['name']+" ("+response['match']['place']['field']['number']+')</td>\n' +
                        '                        <td class="text-right">'+response['match']['home']['name']+'</td>\n' +
                        '                        <td class="text-center">'+response['match']['homescore']+' : '+response['match']['awayscore']+'</td>\n' +
                        '                        <td class="text-left">'+response['match']['away']['name']+'</td>\n' +
                        '                    </tr>')
                }
                $("#message").html('Результат матча введён!')
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
                popover()
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            console.log('fail' + response)
            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })
    if($('#addtime').length > 0) { // если есть допвремя
        $('#addtime').jqxCheckBox({ width: '100%', height: 25 })
        $('#penaltytime').jqxCheckBox({ width: '100%', height: 25 })
        $('#addtime').on('change', function (event) {
            var checked = event.args.checked;
            if(checked) $('#addTimePanel').fadeIn()
            else $('#addTimePanel').fadeOut()
        })
        $('#homeAddScore').jqxNumberInput({ value: 0, width: 70, height: '35px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
        $('#awayAddScore').jqxNumberInput({ value: 0, width: 70, height: '35px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
        $('#penaltytime').on('change', function (event) {
            var checked = event.args.checked;
            if(checked) $('#panaltyPanel').fadeIn()
            else $('#panaltyPanel').fadeOut()
        })
        $('#homePenaltyScore').jqxNumberInput({ value: 0, width: 70, height: '35px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
        $('#awayPenaltyScore').jqxNumberInput({ value: 0, width: 70, height: '35px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap' })
    }
</script>
