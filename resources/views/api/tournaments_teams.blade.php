@extends('layouts.mainapi')

@section('title')Соревнования. Метод teams. @endsection
@section('header')Метод teams @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
                                                                    array('name' => 'Метод teams', 'url' => route('api_doc_tournaments_teams')),
]                                                                ])
@endsection

@section('content')
    <p>Метод <code translate="no" dir="ltr">teams</code> ресурса <code translate="no" dir="ltr">tournaments</code> возвращает все заявленные на турнир команды.
        <a href="{{ route('api_tournaments_teams',1) }}">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded="">{{ route('api_tournaments_teams',1) }}</pre>
    <ul>Запрос выполняется с параметрами:
        <li><code translate="no" dir="ltr">tournament_id</code> - идентификатор <a href="{{ route('api_doc_tournaments') }}">соревнования</a>.
    </ul>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#tourn_id">tourn_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#team_id">team_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#shortname">shortname</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#city">city</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#url">url</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#logo_id">logo_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#logo">logo</a>&quot;: {
        &quot;<a href="#logo.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#logo.type_id">type_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#logo.thumb">thumb</a>&quot;: {
            &quot;<a href="#logo.thumb.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
            &quot;<a href="#logo.thumb.filename">filename</a>&quot;: <var class="apiparam">string</var>,
        },
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
                Уникальный идентификатор <code translate="no" dir="ltr"><span>команды</span></code> в соревновании.</td>
        </tr>
        <tr id="tourn_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>tourn_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор <code translate="no" dir="ltr"><span>соревнования</span></code>. Повторяет параметр в запросе.</td>
        </tr>
        <tr id="team_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>team_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Уникальный идентификатор <code translate="no" dir="ltr"><span>команды</span></code> в реестре всех команд.</td>
        </tr>

        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование команды в заявке на соревнование.</td>
        </tr>
        <tr id="shortname">
            <td><code itemprop="property" translate="no" dir="ltr"><span>shortname</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Краткое наименование команды в заявке на соревнование.</td>
        </tr>
        <tr id="city">
            <td><code itemprop="property" translate="no" dir="ltr"><span>city</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Город команды.</td>
        </tr>
        <tr id="url">
            <td><code itemprop="property" translate="no" dir="ltr"><span>url</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Транслитированное наименование команды.</td>
        </tr>

        <tr id="logo_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>logo_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор логотипа команды. Может быть <code translate="no" dir="ltr"><span>null</span></code>, если логотипа нет.</td>
        </tr>
        <tr id="logo">
            <td><code itemprop="property" translate="no" dir="ltr"><span>logo</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>object</span></code><br>
                Объект логотипа команды. Может быть <code translate="no" dir="ltr"><span>null</span></code>, если логотипа нет.</td>
        </tr>
        <tr id="logo.id">
            <td><code itemprop="property" translate="no" dir="ltr"><span class="quiet"><span>logo.<wbr></span></span><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
            Уникальный идентификатор логотипа команды. Идентификатор равен <a href="#logo_id">logo_id</a>.</td>
        </tr>
        </tbody>
    </table>
@endsection

