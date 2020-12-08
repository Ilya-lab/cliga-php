<?php $__env->startSection('title'); ?>Сезоны. Метод all. <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Метод all <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
                                                                    array('name' => 'Сезоны', 'url' => route('api_doc_seasons')),
                                                                    array('name' => 'Метод all', 'url' => route('api_doc_seasons_all')),
]                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Метод <code translate="no" dir="ltr">all</code> ресурса <code translate="no" dir="ltr">seasons</code> возвращает все сезоны во всех лигах.
        <a href="<?php echo e(route('api_seasons')); ?>">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded=""><?php echo e(route('api_seasons')); ?></pre>
    <p>Запрос выполняется без параметров</p>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#shortname">shortname</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#start">start</a>&quot;: <var class="apiparam">date</var>
    &quot;<a href="#finish">finish</a>&quot;: <var class="apiparam">date</var>
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
        <tr id="id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор <code translate="no" dir="ltr"><span>сезона</span></code>.</td>
        </tr>
        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование сезона.</td>
        </tr>
        <tr id="shortname">
            <td><code itemprop="property" translate="no" dir="ltr"><span>shortname</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Краткое наименование сезона.</td>
        </tr>
        <tr id="start">
            <td><code itemprop="property" translate="no" dir="ltr"><span>start</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>date</span></code><br>
                Дата начала сезона. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD</span></code>).</td>
        </tr>
        <tr id="finish">
            <td><code itemprop="property" translate="no" dir="ltr"><span>finish</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>date</span></code><br>
                Дата окончания сезона. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD</span></code>).</td>
        </tr>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>