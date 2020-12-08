<?php $__env->startSection('title'); ?>Сезоны <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Описание работы с сезонами <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
                                                                    array('name' => 'Сезоны', 'url' => route('api_doc_seasons')),
]                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>В данном разделе описаны методы, предназначенные для получения сезонов (ресурс <code translate="no" dir="ltr">seasons</code>), сезонов в лигах.</p>

    <devsite-heading text="Полный список соревнований" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Полный список сезонов<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    <p>Для получения всех сезонов необходимо вызвать ресурс  <code translate="no" dir="ltr">seasons</code>.</p>

    <devsite-heading text="Методы" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Методы<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    Методы, доступные через API ресурса <code translate="no" dir="ltr">seasons</code>:
    <dt class="notranslate"><a href="<?php echo e(route('api_doc_seasons_all')); ?>">all</a></dt>
    <dd>Возвращает все сезоны во всех лигах.
        <a href="<?php echo e(route('api_seasons')); ?>">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="<?php echo e(route('api_doc_seasons_league')); ?>">league</a></dt>
    <dd>Возвращает все сезоны за конкретную лигу.
        <a href="<?php echo e(route('api_seasons_leagues',1)); ?>">Выполнить</a>.</dd>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>