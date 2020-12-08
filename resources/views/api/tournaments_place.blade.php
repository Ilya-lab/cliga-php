@extends('layouts.mainapi')

@section('title')Соревнования. Метод place. @endsection
@section('header')Метод place @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
                                                                    array('name' => 'Метод place', 'url' => route('api_doc_tournaments_place')),
]                                                                ])
@endsection

@section('content')
    <p>Метод <code translate="no" dir="ltr">place</code> ресурса <code translate="no" dir="ltr">tournaments</code> возвращает призёров соревнования. Данный метод работает только для завершённых соревнований. В противном случае возвращается пустой массив.
        <a href="{{ route('api_tournaments_place',400) }}">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded="">{{ route('api_tournaments_place',400) }}</pre>
    <ul>Запрос выполняется с параметрами:
        <li><code translate="no" dir="ltr">tournament_id</code> - идентификатор <a href="{{ route('api_doc_tournaments') }}">соревнования;</a></li>
    </ul>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#stagename">stagename</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    "<a href="#team_id">team_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#place">place</a>&quot;: <var class="apiparam">unsigned integer</var>,
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
        <tr id="id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор этапа в соревновании.</td>
        </tr>
        <tr id="stagename">
            <td><code itemprop="property" translate="no" dir="ltr"><span>stagename</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование этапа в турнире.</td>
        </tr>
        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование команды.</td>
        </tr>
        <tr id="team_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>team_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор команды в турнирной таблице этапа соревнования.</td>
        </tr>
        <tr id="place">
            <td><code itemprop="property" translate="no" dir="ltr"><span>place</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Место в турнире (этапе) турнира.</td>
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
@endsection

