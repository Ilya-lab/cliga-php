@extends('layouts.mainapi')

@section('title')Соревнования. Метод sport season. @endsection
@section('header')Метод sport season @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
                                                                    array('name' => 'Метод sport season', 'url' => route('api_doc_tournaments_season_sport')),
]                                                                ])
@endsection

@section('content')
    <p>Метод <code translate="no" dir="ltr">sport season</code> ресурса <code translate="no" dir="ltr">tournaments</code> возвращает соревнования за лигу по виду спорта и сезон.
        <a href="{{ route('api_tournaments_seasonsport',[1,0,1]) }}">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded="">{{ route('api_tournaments_seasonsport',[1,0,1]) }}</pre>
    <ul>Запрос выполняется с параметрами:
        <li><code translate="no" dir="ltr">league_id</code> - идентификатор <a href="{{ route('api_doc_leagues') }}">лиги</a>;
        <li><code translate="no" dir="ltr">sport_id</code> - идентификатор <a href="{{ route('api_doc_sports') }}">вида спорта</a>;
        <li><code translate="no" dir="ltr">season_id</code> - идентификатор <a href="{{ route('api_doc_seasons') }}">сезона</a>.
    </ul>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#shortname">shortname</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#desc">desc</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#start">start</a>&quot;: <var class="apiparam">date</var>
    &quot;<a href="#finish">finish</a>&quot;: <var class="apiparam">date</var>
    &quot;<a href="#status_id">status_id</a>&quot;: <var class="apiparam">unsigned integer</var>
    &quot;<a href="#status">status</a>&quot;: {
        &quot;<a href="#status.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#status.name">name</a>&quot;: <var class="apiparam">string</var>,
    },
    &quot;<a href="#sport_id">sport_id</a>&quot;: <var class="apiparam">unsigned integer</var>
    &quot;<a href="#sport">sport</a>&quot;: {
        &quot;<a href="#sport.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#sport.name">name</a>&quot;: <var class="apiparam">string</var>,
    },
    &quot;<a href="#level_id">level_id</a>&quot;: <var class="apiparam">unsigned integer</var>
    &quot;<a href="#level">level</a>&quot;: {
        &quot;<a href="#level.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#level.name">name</a>&quot;: <var class="apiparam">string</var>,
        &quot;<a href="#level.desc">desc</a>&quot;: <var class="apiparam">string</var>,
    },
    &quot;<a href="#season_id">season_id</a>&quot;: <var class="apiparam">unsigned integer</var>
    &quot;<a href="#season">season</a>&quot;: {
        &quot;<a href="#season.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#season.name">name</a>&quot;: <var class="apiparam">string</var>,
        &quot;<a href="#season.start">start</a>&quot;: <var class="apiparam">date</var>
        &quot;<a href="#season.finish">finish</a>&quot;: <var class="apiparam">date</var>
    },
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
                Уникальный идентификатор <code translate="no" dir="ltr"><span>соревнования</span></code>.</td>
        </tr>
        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование соревнования.</td>
        </tr>
        <tr id="shortname">
            <td><code itemprop="property" translate="no" dir="ltr"><span>shortname</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Краткое наименование соревнования.</td>
        </tr>
        <tr id="desc">
            <td><code itemprop="property" translate="no" dir="ltr"><span>desc</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Описание соревнования.</td>
        </tr>
        <tr id="start">
            <td><code itemprop="property" translate="no" dir="ltr"><span>start</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>date</span></code><br>
                Дата начала соревнования. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD</span></code>).</td>
        </tr>
        <tr id="finish">
            <td><code itemprop="property" translate="no" dir="ltr"><span>finish</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>date</span></code><br>
                Дата окончания соревнования. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD</span></code>).</td>
        </tr>
        <tr id="status_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>status_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор статуса соревнования.</td>
        </tr>
        <tr id="status">
            <td><code itemprop="property" translate="no" dir="ltr"><span>status</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>object</span></code><br>
                Объект стауса соревнования.</td>
        </tr>
        <tr id="status.id">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>status.<wbr></span></span><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
            Уникальный идентификатор статуса соревнования. Идентификатор равен <a href="#status_id">status_id</a>. Статус может быть 5 типов: 0 - не начался, 1 - идёт, 2 - окончен, 3 - в архиве, 4 - остановлен.</td>
        </tr>
        <tr id="status.name">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>status.<wbr></span></span><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование статуса соревнования.</td>
        </tr>
        <tr id="sport_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>sport_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор вида спорта, в котором зарегистрировано соревнование.</td>
        </tr>
        <tr id="sport">
            <td><code itemprop="property" translate="no" dir="ltr"><span>sport</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>object</span></code><br>
                Объект Вида спорта, в котором проводится соревнование.</td>
        </tr>
        <tr id="sport.id">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>sport.<wbr></span></span><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор вида спорта. Идентификатор равен <a href="#sport_id">sport_id</a>. Идентификатор может быть: 0 - мини-футбол, 1 - футбол.</td>
        </tr>
        <tr id="sport.name">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>sport.<wbr></span></span><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование Вида спорта.</td>
        </tr>
        <tr id="level_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>level_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор Типа соревнования.</td>
        </tr>
        <tr id="level">
            <td><code itemprop="property" translate="no" dir="ltr"><span>level</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>object</span></code><br>
                Объект Типа соревнования.
                <ol>Объект может быть 3 типов:
                    <li>Чемпионат;</li>
                    <li>Кубок;</li>
                    <li>Узел.</li>
                </ol>Узел - типы соревнования. Например, Лига Чемпионов, Кубок УЕФА и т.п..</td>
        </tr>
        <tr id="level.id">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>level.<wbr></span></span><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор Типа соревнования. Идентификатор равен <a href="#level">level_id</a>. Может быть трёх типов: 0 -узел соревнований, 1 - чемпионат, 2 - кубок.</td>
        </tr>
        <tr id="level.name">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>level.<wbr></span></span><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование Типа соервнования.</td>
        </tr>
        <tr id="level.desc">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>level.<wbr></span></span><span>desc</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Описание Типа соервнования.</td>
        </tr>
        <tr id="season_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>season_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Ссылка на сезон. Может быть <code translate="no" dir="ltr">null</code>.</td>
        </tr>
        <tr id="season">
            <td><code itemprop="property" translate="no" dir="ltr"><span>season</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>object</span></code><br>
                Объект Сезона. Сезон объединяет несколько соревнований. Как правило, длится календарный год. Может быть <code translate="no" dir="ltr">null</code>, задаётся настройками соревнования.
                </td>
        </tr>
        <tr id="season.id">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>season.<wbr></span></span><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор Сезона.</td>
        </tr>
        <tr id="season.name">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>season.<wbr></span></span><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование сезона.</td>
        </tr>
        <tr id="season.start">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>season.<wbr></span></span><span>start</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>date</span></code><br>
                Дата начала сезона. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD</span></code>).</td>
        </tr>
        <tr id="season.finish">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>season.<wbr></span></span><span>finish</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>date</span></code><br>
                Дата окончания сезона. Значение определено в <a href="//www.w3.org/TR/NOTE-datetime">ISO 8601</a> как формат даты (<code translate="no" dir="ltr"><span>YYYY-MM-DD</span></code>).</td>
        </tr>
        </tbody>
    </table>
@endsection

