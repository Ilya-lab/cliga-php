<?php $__env->startSection('title'); ?>Соревнования. Метод lastfirst. <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Метод lastfirst <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
                                                                    array('name' => 'Матчи', 'url' => route('api_doc_matches')),
                                                                    array('name' => 'Метод lastfirst', 'url' => route('api_doc_matches_lastfirst')),
]                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Метод <code translate="no" dir="ltr">lastfirst</code> ресурса <code translate="no" dir="ltr">matches</code> возвращает сыгранные матчи и предстоящие матчи соревнования.
        <a href="<?php echo e(route('api_tournaments_matches', array(1))); ?>">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded=""><?php echo e(route('api_tournaments_matches', array(1))); ?></pre>
    <p>Запрос выполняется с идентификатором соревнования (см. <a href="<?php echo e(route('api_doc_tournaments_all').'#id'); ?>">свойста соревнования</a>). <code translate="no" dir="ltr">В данном случае идентификатор соревнования - 1</code>. Допускается использовать несколько идентификаторов соревнований. Например, <code translate="no" dir="ltr">1,2</code>.</p>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#match_id">match_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#start">dt</a>&quot;: <var class="apiparam">datetime</var>
    &quot;<a href="#championat_id">championat_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#championat">championat</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#championat_url">championat_url</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#arena_id">arena_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#arena">arena</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#home_id">home_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#home">home</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#home_name">home_name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#home_url">home_url</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#home_logo">home_logo</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#away_id">away_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#away">away</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#away_name">away_name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#away_url">away_url</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#away_logo">away_logo</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#home_score">home_score</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#away_score">away_score</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#technicalmissed">technicalmissed</a>&quot;: <var class="apiparam">boolean</var>,
    &quot;<a href="#haspenalty">haspenalty</a>&quot;: <var class="apiparam">boolean</var>,
    &quot;<a href="#home_penalty">home_penalty</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#away_penalty">away_penalty</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#status_id">status_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#status">status</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#tour_id">tour_id</a>&quot;: <var class="apiparam">integer</var>,
    &quot;<a href="#tour">tour</a>&quot;: <var class="apiparam">string</var>,
}]</pre>
    <devsite-heading text="Свойства" for="properties_1" level="h3" link="" toc=""><h3 is-upgraded="" id="properties_1">Свойства</h3></devsite-heading>
    <p>Описание свойств возвращаемого объекта.</p>
    <table class="responsive properties" id="property-table">
        <thead>
        <tr>
            <th colspan="2">Свойство</th>
        </tr>
        </thead>
        <tbody>
        <tr id="match_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>match_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор <code translate="no" dir="ltr"><span>матча</span></code>.</td>
        </tr>
        <tr id="championat_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>championat_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор <code translate="no" dir="ltr"><span>соревнования</span></code> (см. <a href="<?php echo e(route('api_doc_tournaments_all').'#id'); ?>">свойста соревнования</a>).</td>
        </tr>
        <tr id="championat">
            <td><code itemprop="property" translate="no" dir="ltr"><span>championat</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование соревнования.</td>
        </tr>
        <tr id="championat_url">
            <td><code itemprop="property" translate="no" dir="ltr"><span>championat_url</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование URL для соревнования.</td>
        </tr>
        <tr id="dt">
            <td><code itemprop="property" translate="no" dir="ltr"><span>dt</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>datetime</span></code><br>
                Дата и время начала матча. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD dd:mm</span></code>).</td>
        </tr>
        <tr id="arena_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>arena_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор заявки <code translate="no" dir="ltr"><span>арены</span></code>  на соревнование.</td>
        </tr>
        <tr id="arena">
            <td><code itemprop="property" translate="no" dir="ltr"><span>arena</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование арены, на которой пройдёт матч.</td>
        </tr>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>