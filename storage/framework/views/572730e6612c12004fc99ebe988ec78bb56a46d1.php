<?php $__env->startSection('title'); ?>Главная <?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>Описание для работы с API <?php $__env->stopSection(); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('api.block_menu',['menu' => [
                                                                    array('name' => 'Описание', 'url' => route('api_doc')),
]                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Программный интерфейс (API) сервиса Корпоративной лиги позволяет использовать функции системы статистики непосредственно в вашем приложении или на вашем веб-сайте. Например, если вы хотите разработать мобильное приложение, то с помощью API вы сможете получить: список соревнований, календарь матчей, турнирные таблицы, игроков команды, лучших игроков в различных номинациях и т.д...</p>
    <devsite-heading text="Соглашения" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Соглашения<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    <p>Приняты следующие соглашения при использовании API:</p>
    <ul>
        <li>Пустые поля всегда возвращаются в ответе со значением <code translate="no" dir="ltr">null</code>. В случае массива возвращается пустой массив, в случае объекта возвращается пустой объект;</li>
        <li>Все поля связанные с датой и временем передаются в формате <code translate="no" dir="ltr">YYYY-MM-DD hh:mm:ss;</code></li>
        <li>Запросы к API выполняются с помощью методов <code translate="no" dir="ltr">GET</code>, <code translate="no" dir="ltr">POST</code>, <code translate="no" dir="ltr">PUT</code>, <code translate="no" dir="ltr">PATCH</code>, <code translate="no" dir="ltr">DELETE</code>;</li>
        <li>Все параметры в запросах/ответах, а также в структурах данных в формате JSON и название методов именуются в стиле Snake Case - разделение слов через нижнее подчёркивание;</li>
        <li>Данные возвращаются только в <code translate="no" dir="ltr">JSON</code> формате согласно спецификации RFC 7159. Заголовок Accept игнорируется;</li>
        <li>Кодировка данных <code translate="no" dir="ltr">UTF-8</code>;</li>
        <li>Заголовок Content-Type должен быть <code translate="no" dir="ltr">application/json; charset=UTF-8</code>;</li>
        <li>Заголовок <code translate="no" dir="ltr">Content-Length</code> должен содержать корректную длину сообщения, следуя спецификации HTTP/1.1</li>
    </ul>

    <devsite-heading text="Базовый URL для доступа к API" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Базовый URL для доступа к API<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    <p>Базовый URL для доступа к API соответствует следующему шаблону:</p>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded="">&lt;protocol&gt; :// &lt;hostname&gt; / api / &lt;method&gt;</pre>
    <ol>
        <li><code translate="no" dir="ltr">&lt;protocol&gt;</code> - http;</li>
        <li><code translate="no" dir="ltr">&lt;hostname&gt;</code> - cliga.ru;</li>
        <li><code translate="no" dir="ltr">&lt;method&gt;</code> - вызываем метод API.</li>
    </ol>

    <devsite-heading text="Properties" for="properties_1" level="h2" link="" toc=""><h2 is-upgraded="" id="properties_1">Основные ресурсы</h2></devsite-heading>
    <p>Основные ресурсы, используемые в API:</p>
    <table class="responsive properties" id="property-table">
        <thead>
        <tr>
            <th colspan="2">Основные ресурсы</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><a href="<?php echo e(route('api_doc_tournaments')); ?>"><code itemprop="property" translate="no" dir="ltr">tournaments</code></a></td>
            <td>Все зарегистрированные соревнования</td>
        </tr>
        <tr>
            <td><a href="<?php echo e(route('api_doc_sports')); ?>"><code itemprop="property" translate="no" dir="ltr">sports</code></a></td>
            <td>Виды спорта</td>
        </tr>
        <tr>
            <td><a href="<?php echo e(route('api_doc_leagues')); ?>"><code itemprop="property" translate="no" dir="ltr">leagues</code></a></td>
            <td>Виды спорта</td>
        </tr>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainapi', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>