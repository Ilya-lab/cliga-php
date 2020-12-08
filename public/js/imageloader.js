$(function(){
    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');
    var progressBar = $('#progressbar');
    var $preview = $('#preview img', window.opener.document);

// highlight drag area
    $fileInput.on('dragenter focus click', function() {
        $droparea.addClass('is-active');
    });

// back to normal state
    $fileInput.on('dragleave blur drop', function() {
        $droparea.removeClass('is-active');
    });

// change inner text
    $fileInput.on('change', function() {
        var filesCount = $(this)[0].files.length;
        var $textContainer = $(this).prev();

        if (filesCount === 1) {
            // if single file is selected, show file name
            var fileName = $(this).val().split('\\').pop();
            $textContainer.text(fileName);
        } else {
            // otherwise show number of files
            $textContainer.text(filesCount + ' файлов');
        }
        progressBar.val(0);
        progressBar.show();
        $('#my_form').submit();
    });


    $('#my_form').on('submit', function(e){
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0));
        $.ajax({
            url: $that.attr('action'),
            type: $that.attr('method'),
            contentType: false,
            processData: false,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            xhr: function(){
                var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
                xhr.upload.addEventListener('progress', function(evt){ // добавляем обработчик события progress (onprogress)
                    if(evt.lengthComputable) { // если известно количество байт
                        // высчитываем процент загруженного
                        var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                        // устанавливаем значение в атрибут value тега <progress>
                        // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
                        progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(json){
                if(json){
                    $droparea.fadeOut();
                    $('h2').hide();
                    $('#images').append('<img src="/'+json+'" style="width: 100%;">');
                    progressBar.hide();
                    $('#close').show();
                    $('#file', window.opener.document).attr('value',json);
                    $('#images img').Jcrop({
                        setSelect: [0,0,100,100],
                        minSize:[50,50],
                        onChange: showPreview,
                        onSelect: showPreview,
                        aspectRatio: 1
                    }).show();
                    $preview.attr('src', '/'+json);
                    $('#reset_image', window.opener.document).show();
                } else alert(json);
            }
        });
    });

    function showPreview(coords)
    {
        if (parseInt(coords.w) > 0)
        {
            var rx = 100 / coords.w;
            var ry = 100 / coords.h;

            $preview.css({
                width: Math.round(rx * $("#images img").outerWidth()) + 'px',
                height: Math.round(ry * $("#images img").outerHeight()) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });

            $('#x1', window.opener.document).attr('value',coords.x);
            $('#y1', window.opener.document).attr('value',coords.y);
            $('#x2', window.opener.document).attr('value',coords.w);
            $('#y2', window.opener.document).attr('value',coords.h);
            $('#ww', window.opener.document).attr('value',$("#images img").outerWidth());
            $('#hh', window.opener.document).attr('value',$("#images img").outerHeight());
            $('#closed', window.opener.document).attr('class', 'closed');
        }
    }
    $('#close').on('click', function () {
        $preview.show();
        window.close();
    });
});

