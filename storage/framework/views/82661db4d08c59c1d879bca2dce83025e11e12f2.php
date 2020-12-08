<?php $__env->startSection('title'); ?>Соревнования <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Описание работы с соревнованиями <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
]                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>В данном разделе описаны методы, предназначенные для получения соревнований (ресурс <code translate="no" dir="ltr">tournaments</code>), струкртуры турниров, турнирной таблицы, лучших игроков, календаря.</p>

    <devsite-heading text="Полный список соревнований" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Полный список соревнований<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    <p>Для получения всех соревнований необходимо вызвать ресурс  <code translate="no" dir="ltr">tournaments</code> с идентификатором <a href="<?php echo e(route('api_doc_leagues')); ?>">лиги</a> <code translate="no" dir="ltr">{id}</code>.</p>

    <devsite-heading text="Методы" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Методы<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    Методы, доступные через API ресурса <code translate="no" dir="ltr">tournaments</code>:
    <dt class="notranslate"><a href="<?php echo e(route('api_doc_tournaments_all')); ?>">all</a></dt>
    <dd>Возвращает все зарегистрированные соревнования за лигу.
        <a href="<?php echo e(route('api_tournaments',1)); ?>">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="<?php echo e(route('api_doc_tournaments_season_sport')); ?>">sport/{sport_id}/season/{season_id}</a></dt>
    <dd>Возвращает соревнования за лигу по виду спорта и сезону.
        <a href="<?php echo e(route('api_tournaments_seasonsport',[1,0,1])); ?>">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="<?php echo e(route('api_doc_tournaments_teams')); ?>">teams</a></dt>
    <dd>Возвращает заявленные команды в соревновании.
        <a href="<?php echo e(route('api_tournaments_teams',1)); ?>">Выполнить</a>.</dd>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>