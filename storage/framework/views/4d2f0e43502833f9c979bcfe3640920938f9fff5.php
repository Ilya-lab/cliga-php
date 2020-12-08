<!DOCTYPE html>
<head>
    <title>Турниры</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/css/widgets/standings.css').'?v='.config('app.version')); ?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo e(asset('/js/widgets/standings.js').'?v='.config('app.version')); ?>"></script>
    <script>
        var base_meccs_center_url = "<?php echo e(route('widgets_tournament')); ?>"
        getActualTurnNextTurnAndStandings(2)
        var main_class = "cliga_standings"
    </script>
</head>
<body>

<div class="cliga_standings">
    <div class="container">
        <div class="selectbox absolute_select">
            <select class="absolute_select" onchange="getActualTurnNextTurnAndStandings(this.value);" id="kiemeltSelector">
                <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tourn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tourn->id); ?>" ><?php echo e($tourn->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <h1 class="container_title" id="kiemelt_liga_nev"></h1>
        <div class="three-box-container" id="kiemelt_ligak"></div>
    </div>
</div>
</body>
</html>
