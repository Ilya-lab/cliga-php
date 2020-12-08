<?php $__env->startSection('title'); ?>Матчи соревнования <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Описание работы с матчами соревнования <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
    array('name' => 'Матчи', 'url' => route('api_doc_matches')),
]   ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>В данном разделе описаны методы, предназначенные для получения матчей соревнования (ресурс <code translate="no" dir="ltr">matches</code>).</p>

    <devsite-heading text="Методы" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Методы<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    Методы, доступные через API ресурса <code translate="no" dir="ltr">matches</code>:
    <dt class="notranslate"><a href="<?php echo e(route('api_doc_matches_lastfirst')); ?>">lastfirst</a></dt>
    <dd>Возвращает последние/ ближайшие матчи соревнований. Ограничение - 50 оконченных матчей и 50 предстоящих матчей.
        <a href="<?php echo e(route('api_tournaments_matches', array(1))); ?>">Выполнить</a>.</dd>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>