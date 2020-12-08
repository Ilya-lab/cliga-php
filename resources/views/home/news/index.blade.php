@extends('layouts.main')

@section('title')Новости @endsection

@section('js')
    <script src="{{ asset('js/translite.js') }}"></script>
    <script src="{{ asset('js/other.js') }}"></script>
@endsection
@section('css')
    <link href="{{ asset('js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icheck/flat/green.css') }}" rel="stylesheet" type="text/css" />

    <!-- editor -->
    <link href="{{ asset('css/font-awesome.css?v1001') }}" rel="stylesheet">
    <link href="{{ asset('css/editor/external/google-code-prettify/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/editor/index.css') }}" rel="stylesheet">
    <!-- select2 -->
    <link href="{{ asset('css/select/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <!-- datetimepicker -->
    <link href="{{ asset('css/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <!-- dropzone -->
    <!-- <link href="{{ asset('css/dropzone/dropzone.min.css') }}" rel="stylesheet"> -->
@endsection

@section('js_footer')
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatables/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatables/buttons.html5.min.js?ff2') }}"></script>
    <script src="{{ asset('js/datatables/buttons.print.min.js?ff') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('js/icheck/icheck.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('js/select/select2.full.js?dfv') }}"></script>
    <script src="{{ asset('js/toggle/js/bootstrap4-toggle.min.js') }}"></script>

    <!-- datetimepicker -->
    <script src="{{ asset('js/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- dropzone -->
    <script src="{{ asset('js/dropzone/dropzone.js?v14') }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>

    <script>
        function IsJsonString(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }

        $(function () {
            var dt = new Date();
            $('#date').datetimepicker({
                locale: 'ru',
                format: 'DD.MM.YYYY   HH:mm'
            });
        });

        (function() {

            $(".dropzone").dropzone({
                url: '{{ route('loadNewsPhoto') }}',
                token: '{{ csrf_token() }}',
                margin: 0,
                params:{
                    'action': 'save'
                },
                allowedFileTypes: 'jpg,jpeg,png',
                success: function(res, index){
                    console.log(res.responseText, index)
                    try {
                        rs = JSON.parse(res.responseText)
                    } catch(errorThrown) {
                        console.log(errorThrown)
                        alert(errorThrown)
                    }
                    //rs = JSON.parse(res.responseText);
                    if(rs['status'] == 'OK') {
                        //$('#image').hide();
                        $('.nniicc-dropzoneParent').hide();
                        $('#image_preview').show();
                        $('#image_preview').attr('class','visible');
                        $('#image_preview img').attr('src', '{{ env("APP_URL") }}' + '/' + rs['files'][0]);
                        $('#file_name').attr('value', rs['files'][0]);

                    } else alert(rs['text']);
                },
                error: function(res){
                    console.log('error');
                },
            });
        }());

        tinymce.init({
            selector: '#news',
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
                var token = '{{ csrf_token() }}';
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
                formData.append('type', 'news');
                formData.append('url', $('#url').val());
                xhr.send(formData);
            },
        });
    </script>
    <script src="{{ asset('js/pace/pace.min.js') }}"></script>
    <script>
        var handleDataTableButtons = function() {
                "use strict";
                0 !== $("#datatable-responsive").length && $("#datatable-responsive").DataTable({
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "copy",
                        className: "btn-sm"
                    }, {
                        extend: "excel",
                        className: "btn-sm"
                    }, {
                        extend: "pdf",
                        className: "btn-sm"
                    }, {
                        extend: "print",
                        className: "btn-sm"
                    }],
                    responsive: !0
                })
            },
            TableManageButtons = function() {
                "use strict";
                return {
                    init: function() {
                        handleDataTableButtons()
                    }
                }
            }();
    </script>
    <script type="text/javascript">
        function removeNews(id) {
            if(confirm('Удалить новость?')) {
                $.ajax({
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url()->current() }}',
                    data: {
                        "id": id
                    }
                }).done(function(response) {
                    try {
                        response = JSON.parse(response)
                    } catch(errorThrown) {
                        console.log(errorThrown)
                        alert('Ошибка ' + errorThrown)
                    }
                    //response = JSON.parse(response);
                    if(response['status'] == 'OK') {
                        $("#news"+response['id']).remove();
                        alert(response['text']);
                    } else {
                        alert('Ошибка! ' + response['text']);
                    }
                }).fail(function(response, textStatus, errorThrown) {
                    console.log('fail');
                    alert('Ошибка! ' + errorThrown);
                });
            }
        }
        function arjNews(id) {
            if(confirm('Поместить новость в архив?')) {
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url()->current() }}/archive',
                    data: {
                        "id": id
                    }
                }).done(function(response) {
                    try {
                        response = JSON.parse(response)
                    } catch(errorThrown) {
                        console.log(errorThrown)
                        alert('Ошибка ' + errorThrown)
                    }
                    //response = JSON.parse(response);
                    if(response['status'] == 'OK') {
                        $("#news"+response['id']).remove();
                        alert(response['text']);
                    } else {
                        alert('Ошибка! ' + response['text']);
                    }
                }).fail(function(response, textStatus, errorThrown) {
                    console.log('fail');
                    alert('Ошибка! ' + errorThrown);
                });
            }
        }

        function editNews(id) {
            edit = true;
            $('#name').val('');
            $('#desc').val('');
            $('#url').val('');
            $('#news').val('');
            $('#file_name').val('');
            tinyMCE.activeEditor.setContent('');
            $('#file_name').attr('value', '');
            var dt = new Date();
            $('#date').data("DateTimePicker").date(dt);
            $('#image_preview').attr('class','hidden');

            $('#name').prop('disabled', true);
            $('#save').prop('disabled', true);
            $('#desc').prop('disabled', true);
            $('.select2_single').prop('disabled', true);
            $('#date').prop('disabled', true);
            $('#head').prop('disabled', true);
            $('#visible').prop('disabled', true);
            $('#top').prop('disabled', true);
            $('.nniicc-dropzoneParent').hide();
            tinyMCE.activeEditor.getBody().setAttribute('contenteditable',false);
            $('#loader').removeClass('hidden');
            $('#dialog').modal('toggle');

            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url()->current() }}/'+id
            }).done(function(response) {
                try {
                    response = JSON.parse(response)
                } catch(errorThrown) {
                    console.log(errorThrown)
                    $('#loader').addClass('hidden');
                    if(newWin) newWin.close();
                    alert('Ошибка! ' + errorThrown);
                }
                //response = JSON.parse(response);
                if(response['status'] == 'OK') {
                    $('#news-id').val(response['news']['id']);
                    $('#name').val(response['news']['title']);
                    $('#desc').val(response['news']['desc']);
                    $('#url').val(response['news']['url']);
                    $('#news').val(response['news']['news']);
                    tinyMCE.activeEditor.setContent(response['news']['news']);
                    var dt = new Date(response['news']['date']);
                    $('#date').data("DateTimePicker").date(dt);
                    $('#category').val(response['news']['cat_id']);
                    $('#select2-category-container').html(response['news']['catname']);


                    $('#name').prop('disabled', false);
                    $('#save').prop('disabled', false);
                    $('#desc').prop('disabled', false);
                    $('.select2_single').prop('disabled', false);
                    $('#date').prop('disabled', false);
                    $('#head').prop('disabled', false);
                    $('#visible').prop('disabled', false);
                    $('#top').prop('disabled', false);
                    $('.nniicc-dropzoneParent').hide();
                    tinyMCE.activeEditor.getBody().setAttribute('contenteditable',true);

                    $('#top').prop('checked',response['news']['top'] == 1 ? true : false);
                    $('#lenta').prop('checked',response['news']['head'] == 1 ? true : false);
                    $('#visible').prop('checked',response['news']['visible'] == 1 ? true : false);
                    if(response['news']['visible'] == 1) $('#visible').bootstrapToggle('on');
                    else {
                        $('#visible').bootstrapToggle('off');
                    }
                    if(response['news']['top'] == 1) $('#top').bootstrapToggle('on');
                    else {
                        $('#top').bootstrapToggle('off');
                    }
                    if(response['news']['head'] == 1) $('#lenta').bootstrapToggle('on');
                    else {
                        $('#lenta').bootstrapToggle('off');
                    }

                    $('#loader').addClass('hidden');
                    if(response['news']['image2'].trim().length > 0) {
                        // если картинка есть
                        $('.nniicc-dropzoneParent').hide();
                        $('#image_preview').show();
                        $('#image_preview').attr('class','visible');
                        $('#image_preview img').attr('src', '{{ env("APP_URL") }}' + '/' + response['news']['image2']);
                        $('#file_name').attr('value', response['news']['image2']);
                    } else {
                        $('.nniicc-dropzoneParent').show();
                    }
                } else {
                    $('#loader').addClass('hidden');
                    if(newWin) newWin.close();
                    alert('Ошибка! ' + response['text']);
                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail');
                $('#loader').addClass('hidden');
                if(newWin) newWin.close();
                alert('Ошибка! ' + errorThrown);
            });
        }

        var newWin = null;
        var edit = false;
        $(document).ready(function() {
            $('#datatable-responsive').DataTable();
            $('#dialog').on('show.bs.modal', function () {
                var dt = new Date();
                $('#date').data("DateTimePicker").date(dt);
            });
            $('#dialog').on('hide.bs.modal', function () {
                if(newWin) newWin.close();
            });
            $('#save').on('click', function () {
                if(edit === false) {
                    if(!empty($('#name').val())) {
                        $('#name').prop('disabled', true);
                        $('#save').prop('disabled', true);
                        $('#loader').removeClass('hidden');
                        tinyMCE.triggerSave();
                        $.ajax({
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ url()->current() }}',
                            data: {
                                "name": $('#name').val(),
                                "url": $('#url').val(),
                                "desc": $('#desc').val(),
                                "date": $('#date').val(),
                                "news": $('#news').val(),
                                "category": $('#category').val(),
                                "lenta": $('#lenta').prop('checked'),
                                "visible": $('#visible').prop('checked'),
                                "top": $('#top').prop('checked'),
                                "file_name": $('#file_name').val()
                            }
                        }).done(function(response) {
                            try {
                                response = JSON.parse(response)
                            } catch(errorThrown) {
                                console.log(errorThrown)
                                $('#name').prop('disabled', false)
                                $('#save').prop('disabled', false)
                                $('#loader').addClass('hidden')
                                alert('Ошибка! ' + errorThrown)
                            }
                            //response = JSON.parse(response);

                            $('#name').prop('disabled', false);
                            $('#save').prop('disabled', false);
                            $('#loader').addClass('hidden');
                            if(response['status'] === 'fail') alert('Ошибка! ' + response['text']);
                            else {
                                $('#datatable-responsive tbody')
                                    .append('<tr class="even pointer" id="news'+response['id']+'">' +
                                        '<td class="align-content-center">'+($('#datatable-responsive tbody tr').length + 1).toString()+'</td>' +
                                        '<td>\n' +
                                        '                    <button class="btn-info news-edit" attr-id="' + response['id'] +'" onclick="editNews('+response['id']+')">изменить</button>\n' +
                                        '                    <button class="btn-danger news-del" attr-id="' + response['id'] +'" onclick="removeNews('+response['id']+')">удалить</button>\n' +
                                        '                    <button class="btn-warning news-arj" attr-id="' + response['id'] +'" onclick="arjNews('+response['id']+')">архив</button>\n' +
                                        '</td>' +
                                        '<td>'+$('#name').val()+'</td>' +
                                        '<td>'+$('#desc').val()+'</td>' +
                                        '<td>'+$('#category option:selected').text()+'</td>' +
                                        '<td>'+$('#date').val()+'</td>' +
                                        '</tr>');
                                $('#name').val('');
                                $('#desc').val('');
                                $('#url').val('');
                                $('#news').val('');
                                $('#file_name').val('');
                                tinyMCE.activeEditor.setContent('');
                                $('#file_name').attr('value', '');
                                var dt = new Date();
                                $('#date').data("DateTimePicker").date(dt);

                                $('.nniicc-dropzoneParent').show();
                                $('#image_preview').attr('class','hidden');
                                $('#dialog').modal('toggle');
                                alert(response['text']);
                            }
                        }).fail(function(response) {
                            console.log('fail');
                            $('#name').prop('disabled', false);
                            $('#save').prop('disabled', false);
                            $('#loader').addClass('hidden');
                            alert('Ошибка! ' + response['text']);
                        });
                    } else alert('Введите наименование');
                } else {
                    if(!empty($('#name').val())) {
                        $('#name').prop('disabled', true);
                        $('#save').prop('disabled', true);
                        $('#loader').removeClass('hidden');
                        tinyMCE.triggerSave();
                        $.ajax({
                            type: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ url()->current() }}',
                            data: {
                                "id": $('#news-id').val(),
                                "name": $('#name').val(),
                                "url": $('#url').val(),
                                "desc": $('#desc').val(),
                                "date": $('#date').val(),
                                "news": $('#news').val(),
                                "category": $('#category').val(),
                                "lenta": $('#lenta').prop('checked'),
                                "visible": $('#visible').prop('checked'),
                                "top": $('#top').prop('checked'),
                                "file_name": $('#file_name').val()
                            }
                        }).done(function(response) {
                            try {
                                response = JSON.parse(response)
                            } catch(errorThrown) {
                                console.log(errorThrown)
                                $('#name').prop('disabled', false)
                                $('#save').prop('disabled', false)
                                $('#loader').addClass('hidden')
                                $('#news-id').val(0)
                                alert('Ошибка! ' + response['text'])
                            }
                            //response = JSON.parse(response);

                            $('#name').prop('disabled', false);
                            $('#save').prop('disabled', false);
                            $('#loader').addClass('hidden');
                            if(response['status'] === 'fail') alert('Ошибка! ' + response['text']);
                            else {
                                $('#news'+response['id']+' > td:eq(2)').html($('#name').val());
                                $('#news'+response['id']+' > td:eq(3)').html($('#desc').val());
                                $('#news'+response['id']+' > td:eq(4)').html($('#category option:selected').text());
                                $('#news'+response['id']+' > td:eq(5)').html($('#date').val());

                                $('#name').val('');
                                $('#desc').val('');
                                $('#url').val('');
                                $('#news').val('');
                                $('#news-id').val(0);
                                $('#file_name').val('');
                                tinyMCE.activeEditor.setContent('');
                                $('#file_name').attr('value', '');
                                var dt = new Date();
                                $('#date').data("DateTimePicker").date(dt);

                                $('.nniicc-dropzoneParent').show();
                                $('#image_preview').attr('class','hidden');
                                $('#dialog').modal('toggle');
                                alert(response['text']);
                            }
                        }).fail(function(response) {
                            console.log('fail');
                            $('#name').prop('disabled', false);
                            $('#save').prop('disabled', false);
                            $('#loader').addClass('hidden');
                            $('#news-id').val(0);
                            alert('Ошибка! ' + response['text']);
                        });
                    } else alert('Введите наименование');
                }
            });
            $('.select2_single').select2({
                placeholder: "Выберите категорию новости",
                allowClear: true,
                dropdownParent: $('#dialog')
            });
            $('#image_preview').on('click', function () {
                $('#image_preview img').attr('src','');
                //this.hide();
                var $removeEls = $(".progress-bar:not(.active)").parents('.extra-progress-wrapper');
                $removeEls.each(function(index, el) {
                    el.remove();
                });
                $('#file_name').attr('value', '');
                $('.nniicc-dropzoneParent').show();
                $(this).attr('class','hidden');
            });
            $('#image_preview').hover(function(){
                    $(this).find('.closed').animate({opacity:1},100)
                },function(){
                    $(this).find('.closed').animate({opacity:0},100)
                }
            );
            $('.news-add').on('click', function () {
                edit=false;
                $('#name').val('');
                $('#desc').val('');
                $('#url').val('');
                $('#news').val('');
                tinyMCE.activeEditor.setContent('');
                $('#category').val(1);
                $('#select2-category-container').html('Все сайты');

                $('#name').prop('disabled', false);
                $('#save').prop('disabled', false);
                $('#desc').prop('disabled', false);
                $('.select2_single').prop('disabled', false);
                $('#date').prop('disabled', false);
                $('#head').prop('disabled', false);
                $('#visible').prop('disabled', false);
                $('#top').prop('disabled', false);

                $('#top').prop('checked', false);
                $('#lenta').prop('checked', false);
                $('#visible').prop('checked', true);

                $('#image_preview img').attr('src','');
                var $removeEls = $(".progress-bar:not(.active)").parents('.extra-progress-wrapper');
                $removeEls.each(function(index, el) {
                    el.remove();
                });
                $('#file_name').attr('value', '');
                $('.nniicc-dropzoneParent').show();
                $('#image_preview').attr('class','hidden');

                $('#top').bootstrapToggle('off');
                $('#lenta').bootstrapToggle('off');
                $('#visible').bootstrapToggle('on');
            });
            $('.news-edit').on('click', function () {
                var id = $(this).attr("attr-id");
                editNews(id);
            });
            $('.news-del').on('click', function () {
                var id = $(this).attr("attr-id");
                removeNews(id);
            });
            $('.news-arj').on('click', function () {
                var id = $(this).attr("attr-id");
                arjNews(id);
            });
        });
        TableManageButtons.init();
    </script>
@endsection

@section('content')
@component('components.main_block')
    @slot('title')Новости @endslot
    @slot('description')Новости турниров @endslot
    <button type="button" class="btn btn-primary news-add" data-toggle="modal" data-target=".bs-modal">Добавить Новость</button>
    <div class="ln_solid"></div>
    <div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Новость</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left">
                        <div class="form-group row text-center hidden" id="loader">
                            <img src="{{ asset('/images/loading_3.gif') }}">
                        </div>
                        <div class="form-group row">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Заголовок</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" type="text" class="has-feedback-left form-control" name="name" value="" placeholder="введите заголовок" required autofocus onkeyup="translit(['name'],'url')">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Краткое описание</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="desc" type="text" class="has-feedback-left form-control" name="desc" value="" placeholder="введите краткое описание" required>
                                <span class="fa fa-cubes form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="url" class="control-label col-md-3 col-sm-3 col-xs-12">Строка в URL</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="url" type="text" class="has-feedback-left form-control" name="url" value="" disabled required>
                                <span class="fa fa-paper-plane form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">Категория</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="category" class="select2_single form-control" style="width: 100%;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">Изображение</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div id="image" class="dropzone"></div>
                                <div id="image_preview" class="hidden"><div class="closed"></div><img></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Дата публикации</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="date" class="has-feedback-left form-control" name="date" value="" placeholder="введите дату публикации" required>
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea id="news" name="news"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="left">
                        <input type="checkbox" id="lenta" name="lenta" data-toggle="toggle" data-on="В ленте" data-off="Не в ленте" data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                        <input type="checkbox" id="visible" name="visible" data-toggle="toggle" data-on="Активна" data-off="Не активна" data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30" checked>
                        <input type="checkbox" id="top" name="top" data-toggle="toggle" data-on="Прикреплена" data-off="Не прикрепл." data-width="120" data-height="30" data-onstyle="success" data-offstyle="danger">
                    </div>

                    <input type="hidden" id="file_name" value="">
                    <input type="hidden" id="news-id" value="">
                    <button type="button" id="save" class="btn btn-success">Сохранить</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
                </div>

            </div>
        </div>
    </div>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap responsive-utilities jambo_table bulk_action" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Действия</th>
            <th>Заголовок</th>
            <th>Описание</th>
            <th>Категория</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $nw)
            <tr class="even pointer" id="news{{ $nw->id }}" image="{{ $nw->image2 }}">
                <td class="align-content-center">{{ $loop->index + 1 }}</td>
                <td>
                    <button class="btn-info news-edit" attr-id="{{ $nw->id }}">изменить</button>
                    <button class="btn-danger news-del" attr-id="{{ $nw->id }}">удалить</button>
                    <button class="btn-warning news-arj" attr-id="{{ $nw->id }}">архив</button>
                </td>
                <td>{{ $nw->title }}</td>
                <td>{{ $nw->desc }}</td>
                <td>{{ $nw->name }}</td>
                <td>{{ $nw->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endcomponent
@endsection
