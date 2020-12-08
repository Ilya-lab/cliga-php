<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Загрузка изображений</title>
    <link href="<?php echo e(asset('css/fileloader.css?m6')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/jcrop.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/bootstrap.min.css?dff1')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('js/datatables/buttons.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/imageloader.js?cc14')); ?>"></script>
    <script src="<?php echo e(asset('js/jcrop/jcrop.min.js')); ?>"></script>
</head>


<body>
<h2>Загрузка изображений</h2>
<form action="<?php echo e(url()->current()); ?>" method="post" id="my_form" enctype="multipart/form-data">
<div class="file-drop-area">
    <span class="fake-btn">Выберите файл</span>
    <span class="file-msg">или перенесите его в эту область</span>
        <input type="file" name="my_file" id="my_file" class="file-input" accept="image/jpeg,image/png">
</div>
</form>
<progress id="progressbar" value="0" max="100"></progress>
<button id="close" type="button" class="btn btn-info">Закрыть окно и применить изображение</button>
<div id="images">
</div>
<input type="hidden" id="upload_path" value="" />
<input type="hidden" id="file" name="file" value="" />
<input type="hidden" id="x1" name="x1" value="0" />
<input type="hidden" id="y1" name="y1" value="0" />
<input type="hidden" id="x2" name="x2" value="0" />
<input type="hidden" id="y2" name="y2" value="0" />
<input type="hidden" id="ww" name="ww" value="0" />
<input type="hidden" id="hh" name="hh" value="0" />
</body>
</html>