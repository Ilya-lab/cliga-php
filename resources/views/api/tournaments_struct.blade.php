@extends('layouts.mainapi')

@section('title')Соревнования. Метод struct. @endsection
@section('header')Метод struct @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
                                                                    array('name' => 'Метод struct', 'url' => route('api_doc_tournaments_struct')),
]                                                                ])
@endsection

@section('content')
    <p>Метод <code translate="no" dir="ltr">struct</code> ресурса <code translate="no" dir="ltr">tournaments</code> возвращает структуру турнира в древовидной форме с турнирными таблицами.
        <a href="{{ route('api_tournaments_stages',1) }}">Выполнить</a>.</p>

    <devsite-heading text="Запрос" for="properties_1" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_1">Запрос</h4></devsite-heading>
    <pre id="alt-json" class="notranslate" style="max-height: 500px; overflow: auto" dir="ltr" is-upgraded="">{{ route('api_tournaments_struct',1) }}</pre>
    <ul>Запрос выполняется с параметрами:
        <li><code translate="no" dir="ltr">tournament_id</code> - идентификатор <a href="{{ route('api_doc_tournaments') }}">соревнования</a>.
    </ul>
    <devsite-heading text="Ответ" for="properties_2" level="h4" link="" toc=""><h4 is-upgraded="" id="properties_2">Ответ</h4></devsite-heading>
    <p>В ответ будет выдан массив в формате JSON. Описание объекта:</p>
    <pre id="alt-json" class="prettyprint notranslate" style="max-height: 500px; overflow: auto" dir="ltr">
[{
    &quot;<a href="#id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    &quot;<a href="#name">name</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#shortname">shortname</a>&quot;: <var class="apiparam">string</var>,
    &quot;<a href="#parent_id">parent_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    "<a href="#levels_id">levels_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
    "<a href="#priority">priority</a>&quot;: <var class="apiparam">unsigned integer</var>
    "<a href="#child">child</a>&quot;: <var class="apiparam">Object</var>
    &quot;<a href="#table">table</a>&quot;: {
        &quot;<a href="#table.place">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.name">name</a>&quot;: <var class="apiparam">string</var>,
        &quot;<a href="#table.shortname">shortname</a>&quot;: <var class="apiparam">string</var>,
        &quot;<a href="#table.city">city</a>&quot;: <var class="apiparam">string</var>,
        &quot;<a href="#table.id">id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.team_id">team_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.stage_id">stage_id</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.win">win</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.los">los</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.nic">nic</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.zab">zab</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.prop">prop</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.points">points</a>&quot;: <var class="apiparam">unsigned integer</var>,
        &quot;<a href="#table.url">url</a>&quot;: <var class="apiparam">unsigned integer</var>,
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
                Уникальный идентификатор <code translate="no" dir="ltr"><span>этапа</span></code> в соревновании.</td>
        </tr>
        <tr id="name">
            <td><code itemprop="property" translate="no" dir="ltr"><span>name</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Наименование этапа в соревнование. Также возможно наименование группы или стадии в соревновании.</td>
        </tr>
        <tr id="shortname">
            <td><code itemprop="property" translate="no" dir="ltr"><span>shortname</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>string</span></code><br>
                Краткое наименование этапа в соревновании.</td>
        </tr>
        <tr id="parent_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>parent_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Идентификатор родительского этапа. Если значение равно <code translate="no" dir="ltr"><span>null</span></code>, значит самый высший уровень.</td>
        </tr>
        <tr id="levels_id">
            <td><code itemprop="property" translate="no" dir="ltr"><span>levels_id</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Ссылка на идентификатор справочника этапы соревнований.
                <ul>Справочник "Этапы соревнования"
                    <li>3 - Групповая стадия. Если этап оконечный, значит должна быть турнирная таблица.</li>
                    <li>4 - Групповая стадия 2 этап. Продолжение этапа 3, в котором очки, набранные на предыдущим этапе суммируются с текущим. Если этап оконечный, значит должна быть турнирная таблица.</li>
                    <li>5 - Стадия на выбывание. Этап плей-офф, навылет.</li>
                    <li>6 - Стадия квалификации. Этап навылет перед основной стадии турнира.</li>
                    <li>7 - "Золотой финал". Особый этап на вылет, в котором определяется победитель турнира.</li>
                    <li>8 - "Серебряный финал". Утешительная стадия турнира.</li>
                </ul>
            </td>
        </tr>
        <tr id="priority">
            <td><code itemprop="property" translate="no" dir="ltr"><span>priority</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>unsigned integer</span></code><br>
                Порядок следования этапа в разделе. Чем ниже значение, тем раньше этап наступает.</td>
        </tr>
        <tr id="child">
            <td><code itemprop="property" translate="no" dir="ltr"><span>child</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>Object</span></code><br>
                Ссылка на подчинённый этап. Если подчинённые этапы отстутсвуют, то значение равно <code translate="no" dir="ltr"><span>null</span></code>.</td>
        </tr>
        <tr id="table">
            <td><code itemprop="property" translate="no" dir="ltr"><span>table</span></code></td>
            <td><code class="apitype notranslate" dir="ltr"><span>Object</span></code><br>
                Таблица за этап (стадию). Если таблица не предусмотрена, то значение равно <code translate="no" dir="ltr"><span>null</span></code>.<br>
                <ul>Значение таблицы:
                    <li><code translate="no" dir="ltr"><span>place</span></code> - место в таблице</li>
                    <li><code translate="no" dir="ltr"><span>name</span></code> - наименование команды</li>
                    <li><code translate="no" dir="ltr"><span>shortname</span></code> - краткое наименование команды</li>
                    <li><code translate="no" dir="ltr"><span>city</span></code> - населённый пункт команды</li>
                    <li><code translate="no" dir="ltr"><span>id</span></code> - идентификатор команды на данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>team_id</span></code> - идентификатор команды из общего перечня команд</li>
                    <li><code translate="no" dir="ltr"><span>stage_id</span></code> - идентификатор стадии в турнире</li>
                    <li><code translate="no" dir="ltr"><span>win</span></code> - количество побед на данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>los</span></code> - количество поражений на данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>nic</span></code> - количество ничьих на данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>zab</span></code> - количество забитых мячей командой в данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>prop</span></code> - количество пропущенных мячей командой в данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>points</span></code> - количество набранных очков командой в данной стадии</li>
                    <li><code translate="no" dir="ltr"><span>url</span></code> - Часть url-ссылки для команды</li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

