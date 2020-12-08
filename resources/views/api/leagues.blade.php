@extends('layouts.mainapi')

@section('title')Лиги. @endsection
@section('header')Лиги @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Лиги', 'url' => route('api_doc_leagues')),
]                                                                ])
@endsection

@section('content')
    <p>Возвращает все лиги. Данный ресурс необходим если Корпоративная лига является не единственной в системе статистики.
        <a href="{{ route('api_leagues') }}">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded="">{{ route('api_leagues') }}</pre>
    <p>Запрос выполняется без параметров</p>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#desc">desc</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#url">url</a>&quot;: <var class="apiparam">string</var>,
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
                Уникальный идентификатор <code translate="no" dir="ltr"><span>лиги</span></code>.</td>
        </tr>
        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование лиги.</td>
        </tr>
        <tr id="desc">
            <td><code itemprop="property" translate="no" dir="ltr"><span>desc</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Подробное описание лиги в формате HTML.</td>
        </tr>
        <tr id="url">
            <td><code itemprop="property" translate="no" dir="ltr"><span>url</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование лиги в транслите. Используется в URL сайта.</td>
        </tr>
        </tbody>
    </table>
@endsection

