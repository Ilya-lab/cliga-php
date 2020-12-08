var memberPlayers = []
var typeGoal = 4
var typeCard = 1
var loading = false
$(document).ready(function () {
    $("#loader").jqxLoader({  width: 100, height: 60, imagePosition: 'top', text: 'Выполнение операции', isModal: true })
    popover()
    $("#messageNotification").jqxNotification({
        width: 350, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 8000
    });
    $('#homeScore').jqxNumberInput({ value: $('#_homeScore').val(), width: 100, height: '50px', spinButtons: true, digits: 2,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
    $('#awayScore').jqxNumberInput({ value: $('#_awayScore').val(), width: 100, height: '50px', spinButtons: true, digits: 2,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
    $('#homeScore').on('valueChanged', function (event) { saveResult() })
    $('#awayScore').on('valueChanged', function (event) { saveResult() })
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

    if($('#homeFoul').length > 0 && $('#awayFoul').length > 0) {
        $('#homeFoul').jqxNumberInput({ value: $('#_homeFoul').val(), width: 100, height: '50px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#awayFoul').jqxNumberInput({ value: $('#_awayFoul').val(), width: 100, height: '50px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 100, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#homeFoul').on('valueChanged', function (event) { saveFoul() })
        $('#awayFoul').on('valueChanged', function (event) { saveFoul() })
    }
    if($('#countViewers').length > 0) {
        $('#countViewers').jqxNumberInput({ value: $('#_countViewers').val(), width: 100, height: '30px', spinButtons: true, digits: 7,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 1000000, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#countViewers').on('change', function (event) {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('saveviewersRoute'),
                data: {id: $('#_match').val(), count: $('#countViewers').val()},
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                response = JSON.parse(response);
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    // записано количество зрителей на матче
                    $("#message").html(response['text'])
                    $('#messageNotification').jqxNotification({ template: 'info' })
                    $("#messageNotification").jqxNotification("open")
                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
    }
    if($('#homeShots').length > 0 && $('#awayShots').length > 0 && $('#homeShotsOnGoal').length > 0 && $('#awayShotsOnGoal').length > 0) {
        $('#homeShots').jqxNumberInput({ value: $('#_homeShots').val(), width: 100, height: '30px', spinButtons: true, digits: 4,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 1000, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#awayShots').jqxNumberInput({ value: $('#_awayShots').val(), width: 100, height: '30px', spinButtons: true, digits: 4,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 1000, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#homeShotsOnGoal').jqxNumberInput({ value: $('#_homeShotsOnGoal').val(), width: 100, height: '30px', spinButtons: true, digits: 4,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 1000, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#awayShotsOnGoal').jqxNumberInput({ value: $('#_awayShotsOnGoal').val(), width: 100, height: '30px', spinButtons: true, digits: 4,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 1000, spinButtonsWidth: 30, textAlign: 'center', theme: 'bootstrap', disabled: $('#_status').val() == 2 ? true : false })
        $('#homeShots').on('valueChanged', function (event) { saveShots() })
        $('#awayShots').on('valueChanged', function (event) { saveShots() })
        $('#homeShotsOnGoal').on('valueChanged', function (event) { saveShots() })
        $('#awayShotsOnGoal').on('valueChanged', function (event) { saveShots() })
    }
    if($('#homeDefenders').length > 0 && $('#awayDefenders').length > 0) {
        $('#homeDefenders').jqxDropDownList({ width: '100%', height: 30,})
        $('#awayDefenders').jqxDropDownList({width: '100%', height: 30,})
        $('#homeDefenders').on('change', function (event) {
            if(loading) return false
            var args = event.args;
            if (args) {
                var item = args.item;
                var value = item.value;

                $('#loader').jqxLoader('open')
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $('#grid').data('savedefenderRoute'),
                    data: {id: $('#_match').val(), player: value, type: 1},
                }).done(function(response) {
                    $('#loader').jqxLoader('close')
                    response = JSON.parse(response);
                    if(response['status'] === 'fail') {
                        console.log(response['text'])
                        $("#message").html('Ошибка. ' + response['text'])
                        $('#messageNotification').jqxNotification({ template: 'error' })
                        $("#messageNotification").jqxNotification("open")
                    } else {
                        $('#rowFinish').addClass('hidden')
                        $('#rowStart').addClass('hidden')
                        $('#rowCancel').removeClass('hidden')
                        disabledScore(true)
                        $("#message").html(response['text'])
                        $('#messageNotification').jqxNotification({ template: 'info' })
                        $("#messageNotification").jqxNotification("open")
                    }
                }).fail(function(response, textStatus, errorThrown) {
                    console.log('fail' + response)
                    $('#loader').jqxLoader('close')
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                })
            }
        })
        $('#awayDefenders').on('change', function (event) {
            if(loading) return false
            var args = event.args;
            if (args) {
                var item = args.item;
                var value = item.value;

                $('#loader').jqxLoader('open')
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $('#grid').data('savedefenderRoute'),
                    data: {id: $('#_match').val(), player: value, type: 2},
                }).done(function(response) {
                    $('#loader').jqxLoader('close')
                    response = JSON.parse(response);
                    if(response['status'] === 'fail') {
                        console.log(response['text'])
                        $("#message").html('Ошибка. ' + response['text'])
                        $('#messageNotification').jqxNotification({ template: 'error' })
                        $("#messageNotification").jqxNotification("open")
                    } else {
                        $('#rowFinish').addClass('hidden')
                        $('#rowStart').addClass('hidden')
                        $('#rowCancel').removeClass('hidden')
                        disabledScore(true)
                        $("#message").html(response['text'])
                        $('#messageNotification').jqxNotification({ template: 'info' })
                        $("#messageNotification").jqxNotification("open")
                    }
                }).fail(function(response, textStatus, errorThrown) {
                    console.log('fail' + response)
                    $('#loader').jqxLoader('close')
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                })
            }
        })
    }
    if($('#mvp').length > 0) {
        $('#mvp').jqxDropDownList({width: '100%', height: 30,})
        $('#mvp').on('change', function (event) {
            if(loading) return false
            var args = event.args;
            if (args) {
                var item = args.item;
                var value = item.value;

                console.log('CHANGE MVP')
                $('#loader').jqxLoader('open')
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $('#grid').data('savemvpRoute'),
                    data: {id: $('#_match').val(), player: value},
                }).done(function(response) {
                    $('#loader').jqxLoader('close')
                    response = JSON.parse(response);
                    if(response['status'] === 'fail') {
                        console.log(response['text'])
                        $("#message").html('Ошибка. ' + response['text'])
                        $('#messageNotification').jqxNotification({ template: 'error' })
                        $("#messageNotification").jqxNotification("open")
                    } else {
                        $('#rowFinish').addClass('hidden')
                        $('#rowStart').addClass('hidden')
                        $('#rowCancel').removeClass('hidden')
                        disabledScore(true)
                        $("#message").html(response['text'])
                        $('#messageNotification').jqxNotification({ template: 'info' })
                        $("#messageNotification").jqxNotification("open")
                    }
                }).fail(function(response, textStatus, errorThrown) {
                    console.log('fail' + response)
                    $('#loader').jqxLoader('close')
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                })
            }
        })
    }

    $( "#finish_button" ).click(function(){
        if(!confirm('Завершить матч со счётом '+$('#homeScore').val()+':'+$('#awayScore').val()+'?')) return false
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('stateRoute'),
            data: {id: $('#_match').val(), state: 2, homeScore: $('#homeScore').val(), awayScore: $('#awayScore').val()},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response);
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $('#rowFinish').addClass('hidden')
                $('#rowStart').addClass('hidden')
                $('#rowCancel').removeClass('hidden')
                disabledScore(true)
                $('#_status').val(2)
                $("#message").html('Матч завершён!')
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            console.log('fail' + response)
            $('#loader').jqxLoader('close')
            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })
    $( "#cancel_button" ).click(function(){
        if(!confirm('Отменить результат матча?')) return false
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('stateRoute'),
            data: {id: $('#_match').val(), state: 0, homeScore: $('#homeScore').val(), awayScore: $('#awayScore').val()},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response);
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $('#rowFinish').removeClass('hidden')
                $('#rowStart').removeClass('hidden')
                $('#rowCancel').addClass('hidden')
                disabledScore(false)
                $('#homeScore').val(0)
                $('#awayScore').val(0)
                if($('#homeFoul').length > 0 && $('#awayFoul').length > 0) {
                    $('#homeFoul').val(0)
                    $('#awayFoul').val(0)
                }
                $('#_status').val(0)
                $("#message").html('Результат матча отменён!')
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
    $( "#start_button" ).click(function(){
        if(!confirm('Начать матч?')) return false

        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('stateRoute'),
            data: {id: $('#_match').val(), state: 1, homeScore: $('#homeScore').val(), awayScore: $('#awayScore').val()},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $('#rowStart').addClass('hidden')
                $('#_status').val(1)
                $("#message").html('Статус матча изменён!')
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

    $( "#home_button" ).click(function(){
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('teamRoute'),
            data: {id: $('#_match').val(), team: $('#_home').val()},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response);
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
    $( "#away_button" ).click(function(){
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('teamRoute'),
            data: {id: $('#_match').val(), team: $('#_away').val()},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response);
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
    if($('#forma_button').length > 0) {
        $( "#forma_button" ).click(function(){
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('formaRoute'),
                data: {id: $('#_match').val(), team: $('#_away').val()},
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                response = JSON.parse(response);
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
    }

    function saveResult() {
        // сохранить счёт
        if($('#_status').val() == 1){ // если статус матча ИДЁТ
            disabledScore(true)
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('currentscoreRoute'),
                data: {id: $('#_match').val(), homeScore: $('#homeScore').val(), awayScore: $('#awayScore').val()},
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                response = JSON.parse(response)
                if(response['status'] === 'fail') {
                    disabledScore(false)
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    /*$('#rowFinish').addClass('hidden')
                    $('#rowStart').addClass('hidden')
                    $('#rowCancel').removeClass('hidden')*/
                    disabledScore(false)
                    $("#message").html('Счёт матча изменён!')
                    $('#messageNotification').jqxNotification({ template: 'info' })
                    $("#messageNotification").jqxNotification("open")
                }
            }).fail(function(response, textStatus, errorThrown) {
                disabledScore(false)
                $('#loader').jqxLoader('close')
                console.log('fail' + response)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        }
    }
    function saveFoul() {
        // сохранить счёт
            disabledScore(true)
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('currentfoulRoute'),
                data: {id: $('#_match').val(), homeFoul: $('#homeFoul').val(), awayFoul: $('#awayFoul').val()},
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                response = JSON.parse(response)
                if(response['status'] === 'fail') {
                    disabledScore(false)
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    /*$('#rowFinish').addClass('hidden')
                    $('#rowStart').addClass('hidden')
                    $('#rowCancel').removeClass('hidden')*/
                    disabledScore(false)
                    $("#message").html('Фолы изменены!')
                    $('#messageNotification').jqxNotification({ template: 'info' })
                    $("#messageNotification").jqxNotification("open")
                }
            }).fail(function(response, textStatus, errorThrown) {
                disabledScore(false)
                $('#loader').jqxLoader('close')
                console.log('fail' + response)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
    }
    if($('#homeShots').length > 0 && $('#awayShots').length > 0 && $('#homeShotsOnGoal').length > 0 && $('#awayShotsOnGoal').length > 0) {
        function saveShots() {
            // сохранить фолы
            disabledScore(true)
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('saveshotsRoute'),
                data: {
                    id: $('#_match').val(),
                    homeshots: $('#homeShots').val(),
                    awayshots: $('#awayShots').val(),
                    homeshotsongoal: $('#homeShotsOnGoal').val(),
                    awayshotsongoal: $('#awayShotsOnGoal').val()
                },
            }).done(function (response) {
                $('#loader').jqxLoader('close')
                response = JSON.parse(response)
                if (response['status'] === 'fail') {
                    disabledScore(false)
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({template: 'error'})
                    $("#messageNotification").jqxNotification("open")
                } else {
                    disabledScore(false)
                    $("#message").html(response['text'])
                    $('#messageNotification').jqxNotification({template: 'info'})
                    $("#messageNotification").jqxNotification("open")
                }
            }).fail(function (response, textStatus, errorThrown) {
                disabledScore(false)
                $('#loader').jqxLoader('close')
                console.log('fail' + response)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({template: 'error'})
                $("#messageNotification").jqxNotification("open")
            })
        }
    }

    function disabledScore(disabled) {
        $('#homeScore').jqxNumberInput({ disabled: disabled})
        $('#awayScore').jqxNumberInput({ disabled: disabled})
        if($('#homeFoul').length > 0 && $('#awayFoul').length > 0) {
            $('#homeFoul').jqxNumberInput({disabled: disabled})
            $('#awayFoul').jqxNumberInput({disabled: disabled})
        }
        if($('#countViewers').length > 0) {
            $('#countViewers').jqxNumberInput({disabled: disabled})
        }
        if($('#homeShots').length > 0 && $('#awayShots').length > 0 && $('#homeShotsOnGoal').length > 0 && $('#awayShotsOnGoal').length > 0) {
            $('#homeShots').jqxNumberInput({disabled: disabled})
            $('#awayShots').jqxNumberInput({disabled: disabled})
            $('#homeShotsOnGoal').jqxNumberInput({disabled: disabled})
            $('#awayShotsOnGoal').jqxNumberInput({disabled: disabled})
        }
        if($('#addtime').length > 0) {
            $('#addtime').jqxCheckBox({ disabled: disabled })
            $('#penaltytime').jqxCheckBox({ disabled: disabled })
            $('#homeAddScore').jqxNumberInput({ disabled: disabled})
            $('#awayAddScore').jqxNumberInput({ disabled: disabled})
            $('#homePenaltyScore').jqxNumberInput({ disabled: disabled})
            $('#awayPenaltyScore').jqxNumberInput({ disabled: disabled})
        }
    }

    $('#goalauto').change(function(){
        if ($(this).is(':checked'))
        {
            typeGoal = 6
            $('#assistantRow').addClass('hidden')
            $('#gkRow').addClass('hidden')
            $('#gkRowAG').removeClass('hidden')
        }
    })
    $('#goalpenalty').change(function(){
        if ($(this).is(':checked'))
        {
            typeGoal = 5
            $('#assistantRow').addClass('hidden')
            $('#gkRowAG').addClass('hidden')
            $('#gkRow').removeClass('hidden')
        }
    })
    $('#goalgame').change(function(){
        if ($(this).is(':checked'))
        {
            typeGoal = 4
            $('#assistantRow').removeClass('hidden')
            $('#gkRowAG').addClass('hidden')
            $('#gkRow').removeClass('hidden')
        }
    })
    $('#yellowcard').change(function(){
        if ($(this).is(':checked'))
        {
            typeCard = 1
            $('#redcardReasonRow').addClass('hidden')
            $('#yellowcardReasonRow').removeClass('hidden')
        }
    })
    $('#twoyellowcard').change(function(){
        if ($(this).is(':checked'))
        {
            typeCard = 2
            $('#redcardReasonRow').addClass('hidden')
            $('#yellowcardReasonRow').removeClass('hidden')
        }
    })
    $('#redcard').change(function(){
        if ($(this).is(':checked'))
        {
            typeCard = 3
            $('#yellowcardReasonRow').addClass('hidden')
            $('#redcardReasonRow').removeClass('hidden')
        }
    })

    $('#assistant').jqxDropDownList({ width: 300, height: 30, })
    $('#gk').jqxDropDownList({ width: 300, height: 30, })
    $('#gkAG').jqxDropDownList({ width: 300, height: 30, })
    $('#minute').jqxNumberInput({ value: 0, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    $('#opponent').jqxDropDownList({ width: 300, height: 30, })
    $('#yellowcardReason').jqxDropDownList({ width: 300, height: 30, })
    $('#redcardReason').jqxDropDownList({ width: 300, height: 30, })
    $('#minuteCard').jqxNumberInput({ value: 0, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    /*$('#minuteClock').jqxNumberInput({ value: 0, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    $('#minuteAllClock').jqxNumberInput({ value: 0, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })*/

    $('body').on('click', '#goal',function () {
        // клик по всплывающей подсказке на иконку гол
        var playerID = $(this).parent().attr("data-id")
        $('#_currentPlayer').val(playerID)
        $('#_currentTeam').val($(this).parent().attr("data-team-id"))
        $('#assistant').jqxDropDownList('clear')
        $('#assistant').jqxDropDownList('addItem', { label: 'Нет', value: 0} )
        $('#assistant').jqxDropDownList('selectIndex', 0 )
        $('#gk').jqxDropDownList('clear')
        $('#gk').jqxDropDownList('addItem', { label: 'Нет', value: 0} )
        $('#gk').jqxDropDownList('selectIndex', 0 )
        $('#gkAG').jqxDropDownList('clear')
        $('#gkAG').jqxDropDownList('addItem', { label: 'Нет', value: 0} )
        $('#gkAG').jqxDropDownList('selectIndex', 0 )
        $('#family').html($(this).parent().attr("data-player-name"))
        memberPlayers[$(this).parent().attr("data-team-id")].forEach(function(entry) { // за свои
            //console.log(entry);
            if(playerID != entry.player_id) {
                if(entry.number > 0) $('#assistant').jqxDropDownList('addItem', { label: entry.number + '. ' + entry.family + ' ' + entry.name, value: entry.player_id} )
                else $('#assistant').jqxDropDownList('addItem', { label: '#. ' + entry.family + ' ' + entry.name, value: entry.player_id} )
                if(entry.is_goalkeeper) {
                    if(entry.number > 0) $('#gkAG').jqxDropDownList('addItem', { label: entry.number + '. ' + entry.family + ' ' + entry.name, value: entry.player_id} )
                    else $('#gkAG').jqxDropDownList('addItem', { label: '#. ' + entry.family + ' ' + entry.name, value: entry.player_id} )
                }
            }
        })
        memberPlayers[$(this).parent().attr("data-opponent-id")].forEach(function(entry) { // за противника
            if(playerID != entry.player_id) {
                if (entry.is_goalkeeper) {
                    if (entry.number > 0) $('#gk').jqxDropDownList('addItem', {
                        label: entry.number + '. ' + entry.family + ' ' + entry.name,
                        value: entry.player_id
                    })
                    else $('#gk').jqxDropDownList('addItem', {
                        label: '#. ' + entry.family + ' ' + entry.name,
                        value: entry.player_id
                    })
                }
            }
        })
        //$('#loader').jqxLoader('open')
        $('#dialogGoal').modal('toggle')
    })
    $('body').on('click', '#card',function () {
        // карточка в матче
        var playerID = $(this).parent().attr("data-id")
        $('#_currentPlayer').val(playerID)
        $('#_currentTeam').val($(this).parent().attr("data-team-id"))
        $('#opponent').jqxDropDownList('clear')
        $('#opponent').jqxDropDownList('addItem', { label: 'Нет', value: 0} )
        $('#opponent').jqxDropDownList('selectIndex', 0 )
        $('#familyCard').html($(this).parent().attr("data-player-name"))
        memberPlayers[$(this).parent().attr("data-opponent-id")].forEach(function(entry) { // за противника
            if(playerID != entry.player_id) {
                    if (entry.number > 0) $('#opponent').jqxDropDownList('addItem', {
                        label: entry.number + '. ' + entry.family + ' ' + entry.name,
                        value: entry.player_id
                    })
                    else $('#opponent').jqxDropDownList('addItem', {
                        label: '#. ' + entry.family + ' ' + entry.name,
                        value: entry.player_id
                    })
            }
        })
        $('#dialogCard').modal('toggle')
    })
    $('body').on('click', '#gkMinute',function () {
        // карточка в матче
        var playerID = $(this).parent().attr("data-id")
        $('#_currentPlayer').val(playerID)
        $('#_currentTeam').val($(this).parent().attr("data-team-id"))
        $('#familyClock').html($(this).parent().attr("data-player-name"))
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('minupdateeventRoute'),
            data: {id: $('#_match').val(), player: playerID, team: $(this).parent().attr("data-team-id")},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response);
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
    $('body').on('click', '#resultSaveGoal',function () {
        $('#dialogGoal').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('saveeventRoute'),
            data: {id: $('#_match').val(), player_id: $('#_currentPlayer').val(), minute: $('#minute').val(), type: typeGoal, assistant_id: typeGoal == 4 ? $('#assistant').val() : 0, opponent_id: typeGoal == 6 ? $('#gkAG').val() : $('#gk').val(), team_id: $('#_currentTeam').val(), table: true},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // обработка ответа
                $('#eventbox').html(response['table'])
                $("#message").html('Событие матча записано!')
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
    $('body').on('click', '#resultSaveCard',function () {
        $('#dialogCard').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('saveeventRoute'),
            data: {id: $('#_match').val(), player_id: $('#_currentPlayer').val(), minute: $('#minuteCard').val(), type: typeCard, assistant_id: 0, opponent_id: $('#opponent').val(), team_id: $('#_currentTeam').val(), reason_id: typeCard == 3 ? $('#redcardReason').val() : $('#yellowcardReason').val(), table: true},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // обработка ответа
                $('#eventbox').html(response['table'])
                $("#message").html('Событие матча записано!')
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
    $('body').on('click', 'td.remove',function () {
        if(!confirm('Удалить событие матча?')) return false
        //alert($(this).parent().attr('data-event-id'))
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('removeeventRoute'),
            data: {id: $(this).parent().attr('data-event-id'), table: true},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // обработка ответа
                $('#eventbox').html(response['table'])
                $("#message").html('Событие в матче удалено!')
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
})

function popover() {
    if($('.popoverable').length == 0) return false
    $('.popoverable').jqxTooltip({ content: '', position: 'mouse', name: 'movieTooltip', autoHideDelay: 8000, theme: 'bootstrap', trigger: 'click'})
    $('.popoverable').bind('opening',function () {

        var cont = '<i id="goal" title="Гол в матче" class="fa fa-futbol-o remove p-2"></i><i id="card" title="Карточка в матче" class="fa fa-square remove p-2"></i>'
        if($("#_hasMinuteEditor").val() == 1) cont = cont + '<i id="gkMinute" title="Количество минут в поле" class="fa fa-clock-o remove p-2"></i>';

            $(this).jqxTooltip({ content: '<div data-id="'+$(this).attr("data-player-id")+'" data-team-id="'+$(this).attr("data-team-id")+'" data-opponent-id="'+$(this).attr("data-opponent-id")+'" data-player-name="'+$(this).attr("data-player-name")+'">'+cont+'</div>'})
    })
}
