<?php $__env->startSection('title'); ?>Соревнования. Метод table. <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Метод table <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
                                                                    array('name' => 'Метод table', 'url' => route('api_doc_tournaments_table')),
]                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Метод <code translate="no" dir="ltr">table</code> ресурса <code translate="no" dir="ltr">tournaments</code> возвращает турнирную таблицу этапа соревнования. Данный метод работает только для стадий (этапов) с идентификатором 3 или 4. В противном случае возвращается пустой массив.
        <a href="<?php echo e(route('api_tournaments_table',[403,30])); ?>">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded=""><?php echo e(route('api_tournaments_table',[403,30])); ?></pre>
    <ul>Запрос выполняется с параметрами:
        <li><code translate="no" dir="ltr">tournament_id</code> - идентификатор <a href="<?php echo e(route('api_doc_tournaments')); ?>">соревнования;</a></li>
        <li><code translate="no" dir="ltr">stage_id</code> - идентификатор <a href="<?php echo e(route('api_doc_tournaments_stages')); ?>">этапа</a>.</li>
    </ul>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#place">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#shortname">shortname</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#city">city</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#team_id">team_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#stage_id">stage_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#win">win</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#los">los</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#nic">nic</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#zab">zab</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#prop">prop</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#points">points</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#url">url</a>&quot;: <var class="apiparam">string</var>
    }
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
        <tr id="place">
            <td><code itemprop="property" translate="no" dir="ltr"><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Место команды в турнирной таблице <code translate="no" dir="ltr"><span>этапа</span></code> в соревновании.</td>
        </tr>
        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование команды в турнире.</td>
        </tr>
        <tr id="city">
            <td><code itemprop="property" translate="no" dir="ltr"><span>city</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Город команды.</td>
        </tr>
        <tr id="id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор команды в турнирной таблице этапа соревнования.</td>
        </tr>
        <tr id="team_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>team_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор команды в общем перечне (реестре) команд.</td>
        </tr>
        <tr id="stage_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>stage_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор этапа соревнования.</td>
        </tr>
        <tr id="win">
            <td><code itemprop="property" translate="no" dir="ltr"><span>win</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Количество побед команды на этапе соревнования.</td>
        </tr>
        <tr id="los">
            <td><code itemprop="property" translate="no" dir="ltr"><span>los</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Количество поражений команды на этапе соревнования.</td>
        </tr>
        <tr id="nic">
            <td><code itemprop="property" translate="no" dir="ltr"><span>nic</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Количество ничьих команды на этапе соревнования.</td>
        </tr>
        <tr id="zab">
            <td><code itemprop="property" translate="no" dir="ltr"><span>zab</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Количество забитых мячей команды на этапе соревнования.</td>
        </tr>
        <tr id="prop">
            <td><code itemprop="property" translate="no" dir="ltr"><span>prop</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Количество пропущенных мячей команды на этапе соревнования.</td>
        </tr>
        <tr id="points">
            <td><code itemprop="property" translate="no" dir="ltr"><span>points</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Количество очков команды на этапе соревнования.</td>
        </tr>
        <tr id="url">
            <td><code itemprop="property" translate="no" dir="ltr"><span>url</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Часть уникального URL команды.</td>
        </tr>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>