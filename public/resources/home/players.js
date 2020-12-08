function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function formDisabled(dis) {
    $('#family').prop('disabled', dis);
    $('#name').prop('disabled', dis);
    $('#surname').prop('disabled', dis);
    $('#birthdate').prop('disabled', dis);
    $('#email').prop('disabled', dis);
    $('#phone').prop('disabled', dis);
    $('#comment').prop('disabled', dis);
    $('#other').prop('disabled', dis);
    $('#active').prop('disabled', dis);

    if(dis) {
        $('#loader').removeClass('hidden');
        $('#preview').addClass('hidden');
        $('#save').addClass('hidden');
        $('#photo_box').addClass("hidden");
        $("#photo").jqxDropDownList('clear');
    } else {
        $('#loader').addClass('hidden');
        $('#preview').removeClass('hidden');
        $('#save').removeClass('hidden');
    }
}
function formClear() {
    $('#family').val('');
    $('#name').val('');
    $('#surname').val('');
    $('#birthdate').val('');
    $('#email').val('');
    $('#phone').val('');
    $('#comment').val('');
    tinyMCE.activeEditor.setContent('');
    $('#other').prop('checked', false);
    $('#active').prop('checked', true);
    $('#photo_box').addClass("hidden");
    $('#closed').attr('class', 'closed hidden');
    $('#uploaded_preview').attr('src','/images/no_image.jpg');
    $('#uploaded_preview').attr('style','width: 100px; height: 100px; cursor: pointer;');
}
$(function () {
    $('#birthdate').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        maxDate: new Date(),
        date: new Date(1990,0,1),
    });
    $('#other').change(function() {
        if($(this).prop('checked')) $('#otherbox').removeClass('hidden')
        else $('#otherbox').addClass('hidden')
    })
});

tinymce.init({
    selector: '#comment',
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount imagetools'
    ],
    toolbar: 'forecolor backcolor | undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright',
    browser_spellcheck: true,
    language: 'ru',
    images_upload_url: 'postAcceptor.php',
    height: '300px',

    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'images/upload_desc');
        var token = $('meta[name="csrf-token"]').attr('content');
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP ошибка: ' + xhr.status);
                return;
            }
            if(!IsJsonString(xhr.responseText)) {
                failure('Неправильный ответ от сервера');
                console.log(xhr.responseText);
                return false;
            }
            json = JSON.parse(xhr.responseText);
            if(json.status === 'ERROR') {
                failure(json.error);
                console.log(json);
                return false;
            }

            if(json.status === 'OK') {
                success(json.location);
            }
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('type', 'person');
        formData.append('url', $('#url').val());
        xhr.send(formData);
    },
});

$(document).ready(function () {
    var edit = false;
    var newWin = null;
    var selectedPhotoId = 0;
    // prepare the data
    var source = {
        datatype: "json",
        type: "GET",
        datafields: [
            { name: 'id' },
            { name: 'family' },
            { name: 'name'},
            { name: 'surname' },
            { name: 'fio' },
            { name: 'birthdate' },
            { name: 'sex_id' },
            { name: 'country' },
            { name: 'email' },
            { name: 'phone' },
            { name: 'active', type: 'bool' },
        ],
        id: "id",
        url: $('#grid').data('loadRoute'),
        async: true,
    };
    var dataAdapter = new $.jqx.dataAdapter(source, {
        formatData: function (data) {
            if($("#persons").length>0) {
                if ($("#persons").val() != undefined || $("#persons").val() == '') {
                    data.person = $("#persons").val();
                    data._token = $("meta[name=csrf-token]").attr("content");
                    return data;
                }
            }
        },
        loadError: function (jqXHR, status, error) {
            console.log(error)
            $("#message").html('Ошибка. ' + error);
            $("#messageNotification").jqxNotification("open");
        },
        beforeLoadComplete: function (records) {
            for(var i=0; i<records.length; i++) {
                records[i]['country'] = records[i]['country']['name'];
            }
            return records;
        }
    });
    $("#grid").jqxGrid(
    {
        width: '100%',
        theme: 'bootstrap',
        source: dataAdapter,
        columnsresize: true,
        adaptive: true,
        localization: 'ru-RU',
        showtoolbar: true,
        rendertoolbar: function (toolbar) {
            var container = $("<div style='margin: 5px;'></div>");
            toolbar.append(container);
            container.append('<div id="persons"><input type="text"/></div>');
            $("#persons").jqxInput({
                width: '100%',
                placeHolder: 'Поиск участника',
                searchMode: 'contains'
            });
            $('#persons').on('change', function (event) {
                dataAdapter.dataBind();
            });
        },
        columns: [
            { text: 'Фамилия Имя Отчество', datafield: 'fio', align: 'center' },
            { text: 'Дата рождения', datafield: 'birthdate', width: 120, align: 'center', cellsalign: 'center',
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    if(value.length == 0) return '';
                    var dd = new Date(value);
                    var birth = birthDateToAge(dd, new Date());
                    var col = "green";
                    if(birth[0] <= 16) col = "red";
                    else if(birth[0] > 40) col = "orange";
                    return '<div class="jqx-grid-cell-middle-align" style="margin-top: 8.5px; color: '+col+'">' + dd.toLocaleDateString() + '</div>';
                }
            },
            { text: 'Пол', datafield: 'sex_id', width: 90, align: 'center', cellsalign: 'center',
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    if(value == 1) return '<div class="jqx-grid-cell-middle-align" style="margin-top: 8.5px; color: blue">муж</div>';
                    else if(value == 2) return '<div class="jqx-grid-cell-middle-align" style="margin-top: 8.5px; color: rosybrown">жен</div>';
                    return '';
                }
            },
            { text: 'Гражданство', datafield: 'country', width: 200, align: 'center', cellsalign: 'center' },
            { text: 'Телефон', datafield: 'phone', width: 150, align: 'center', cellsalign: 'center' },
            { text: 'E-Mail', datafield: 'email', width: 200, align: 'center', cellsalign: 'center' },
            { text: 'Активен', datafield: 'active', width: 90, align: 'center',  columntype: 'checkbox' }
        ]
    });
    $('#grid').on('rowdoubleclick', function (event) {
        var boundIndex = event.args.rowindex;
        formClear()
        formDisabled(true)
        edit = true
        $('#person-id').val(dataAdapter.records[boundIndex].id);
        $('#dialog').modal('toggle');
        // запрос на получение
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('showRoute') + '/' + dataAdapter.records[boundIndex].id,
        }).done(function(response) {
           // response = JSON.parse(response);
            formDisabled(false);
            $('#loader').addClass('hidden');
            $('#family').val(response.person['family']);
            $('#name').val(response.person['name']);
            $('#surname').val(response.person['surname']);
            $('#url').val(response.person['url']);
            var dt = new Date(response.person['birthdate']);
            if(dt.getMonth() == 0 && dt.getDate() == 1 && (dt.getFullYear() == 1970 || dt.getFullYear() == 1900)) {} else $('#birthdate').data("DateTimePicker").date(dt);
            $('#email').val(response.person['email']);
            $('#phone').val(response.person['phone']);
            $('#country').val(response.person['country_id']);
            $('#photo_box').removeClass("hidden")
            $("#photo").jqxDropDownList('clear');
            if(response.person['story'])
                tinyMCE.activeEditor.setContent(response.person['story']);

            if(response.person['active']) {
                $('#active').prop('checked',true);
                $('#active').bootstrapToggle('on');
            } else {
                $('#active').prop('checked',false);
                $('#active').bootstrapToggle('off');
            }
            if(response.person['sex_id'] == 1) {
                $('#sex').prop('checked',true);
                $('#sex').bootstrapToggle('on');
            } else {
                $('#sex').prop('checked',false);
                $('#sex').bootstrapToggle('off');
            }
            // photo
            var gg = 0;
            var sel = false;
            for(var key in response.person['photos']) {
                $('#photo').jqxDropDownList('addItem', { label: response.person['photos'][key]['thumb'][1]['filename'], value: response.person['photos'][key]['id'] } );
                if(response.person['photos'][key]['id'] == response.person['photo_id'])  {
                    $("#photo").jqxDropDownList('selectIndex', gg );
                    selectedPhotoId = response.person['photos'][key]['id'];
                    sel = true;
                }
                gg++;
            }
            $('#photo').jqxDropDownList('addItem', { label: '/images/no_image.jpg', value: '0'} );
            if(!sel) {
                $("#photo").jqxDropDownList('selectIndex', $("#photo").jqxDropDownList('getItems').length - 1);
                selectedPhotoId = 0;
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#dialog').modal('toggle');
            console.log('fail' + response);
            formDisabled(false);
            $('#loader').addClass('hidden');
            $("#message").html('Ошибка. ' + errorThrown);
            $('#messageNotification').jqxNotification({ template: 'error' });
            $("#messageNotification").jqxNotification("open");
        });
    });
    $("#messageNotification").jqxNotification({
        position: "top-right", opacity: 0.8,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 10000, template: "error"
    });
    $('#formVal').jqxValidator({
        rules: [
            { input: '#family', message: 'Введите фамилию', action: 'keyup, blur', rule: 'required' },
            { input: '#name', message: 'Введите имя', action: 'keyup, blur', rule: 'required' },
        ]
    });
    $('#preview').on('click', function () {
        newWin = window.open('/home/images/load', 'Загрузка логотипа', 'width=600,height=400,location=no');
    });
    $('#save').on('click', function () {
        $('#formVal').jqxValidator('validate');
    });
    $('#closed').on('click', function (event) {
        event.stopPropagation();
        $('#x1').val(0);
        $('#y1').val(0);
        $('#x2').val(0);
        $('#y2').val(0);
        $('#ww').val(0);
        $('#hh').val(0);
        $('#file').val('');
        $('#upload_path').val('');
        $('#closed').attr('class', 'closed hidden');
        $('#uploaded_preview').attr('src','/images/no_image.jpg');
        $('#uploaded_preview').attr('style','width: 100px; height: 100px; cursor: pointer;');
        if(newWin) newWin.close();
    });
    $('#formVal').on('validationSuccess', function (event) {
        formDisabled(true);
        tinyMCE.triggerSave();
        var attr = {
            "id":      $('#person-id').val(),
            "family":  $('#family').val(),
            "name":    $('#name').val(),
            "surname": $('#surname').val(),
            "url":     $('#url').val(),
            "birthdate":$('#birthdate').val(),
            "comment": $('#comment').val(),
            "email":   $('#email').val(),
            "phone":   $('#phone').val(),
            "active":  $('#active').prop('checked'),
            "sex":     $('#sex').prop('checked'),
            "country": $('#country').val(),
            "x1":      $('#x1').val(),
            "x2":      $('#x2').val(),
            "y1":      $('#y1').val(),
            "x2":      $('#x2').val(),
            "y2":      $('#y2').val(),
            "ww":      $('#ww').val(),
            "hh":      $('#hh').val(),
            "upload_path": $('#upload_path').val(),
            "file":    $('#file').val(),
            "photo":   selectedPhotoId,
        }
        if (edit === false) {
            // если новая запись
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('saveRoute'),
                data: attr,
            }).done(function(response) {
                response = JSON.parse(response);
                formDisabled(false);
                $('#loader').addClass('hidden');
                $('#dialog').modal('toggle');
                formClear();
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text']);
                    $('#messageNotification').jqxNotification({ template: 'error' });
                    $("#messageNotification").jqxNotification("open");
                } else {
                    $("#message").html('Участник добавлен!');
                    $('#messageNotification').jqxNotification({ template: 'info' });
                    $("#messageNotification").jqxNotification("open");
                    dataAdapter.dataBind();
                }
            }).fail(function(response, textStatus, errorThrown) {
                $('#dialog').modal('toggle');
                console.log('fail' + response);
                formDisabled(false);
                $('#loader').addClass('hidden');
                $("#message").html('Ошибка. ' + errorThrown);
                $('#messageNotification').jqxNotification({ template: 'error' });
                $("#messageNotification").jqxNotification("open");
            });
        } else {
            // если обновление
            $.ajax({
                type: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('updateRoute'),
                data: attr,
            }).done(function(response) {
                response = JSON.parse(response);
                formDisabled(false);
                $('#loader').addClass('hidden');
                $('#dialog').modal('toggle');
                formClear();
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text']);
                    $('#messageNotification').jqxNotification({ template: 'error' });
                    $("#messageNotification").jqxNotification("open");
                } else {
                    $("#message").html('Участник обновлён!');
                    $('#messageNotification').jqxNotification({ template: 'info' });
                    $("#messageNotification").jqxNotification("open");
                    dataAdapter.dataBind();
                }
            }).fail(function(response, textStatus, errorThrown) {
                $('#dialog').modal('toggle');
                console.log('fail' + response);
                formDisabled(false);
                $('#loader').addClass('hidden');
                $("#message").html('Ошибка. ' + errorThrown);
                $('#messageNotification').jqxNotification({ template: 'error' });
                $("#messageNotification").jqxNotification("open");
            });
        }
    });
    $('#dialog').on('hide.bs.modal', function () {
        $('#formVal').jqxValidator('hide');
        formClear()
        formDisabled(false)
        edit = false
        if(newWin) newWin.close();
    });
    $('#preview').hover(function(){
            $(this).find('.closed').animate({opacity:1},100)
        },function(){
            $(this).find('.closed').animate({opacity:0},100)
        }
    );
    $('#photo').jqxDropDownList({ autoDropDownHeight: true, itemHeight: 104, height: 104, dropDownWidth: 200,
        renderer: function (index, label, value) {
            var imgurl = label;
            var img = '<img height="100" src="' + imgurl + '"/>';
            var table = '<table style="min-width: 150px;"><tr><td>' + img + '</td></tr></table>';
            return table;
        },
        selectionRenderer: function (index, label, value) {
            var imgurl = value;
            var img = '<img height="100" src="' + imgurl + '"/>';
            var table = '<table style="min-width: 150px;"><tr><td style="padding: 2px;width: 50%;">' + img + '</td></tr></table>';
            return table;
        }
    });
    $('#photo').on('change', function (event)
    {
        var args = event.args;
        if (args) {
            var item = args.item;
            selectedPhotoId = item.value;
        }
    });
    if ($(document).width() < 800) {
        $('#photo').jqxDropDownList({ dropDownVerticalAlignment: 'top'});
    }
});
