@extends('layouts.mainapi')

@section('title')Соревнования @endsection
@section('header')Описание работы с соревнованиями @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Соревнования', 'url' => route('api_doc_tournaments')),
]                                                                ])
@endsection

@section('content')
    <p>В данном разделе описаны методы, предназначенные для получения соревнований (ресурс <code translate="no" dir="ltr">tournaments</code>), струкртуры турниров, турнирной таблицы, лучших игроков, календаря.</p>

    <devsite-heading text="Полный список соревнований" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Полный список соревнований<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    <p>Для получения всех соревнований необходимо вызвать ресурс  <code translate="no" dir="ltr">tournaments</code> с идентификатором <a href="{{ route('api_doc_leagues') }}">лиги</a> <code translate="no" dir="ltr">{id}</code>.</p>

    <devsite-heading text="Методы" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Методы<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    Методы, доступные через API ресурса <code translate="no" dir="ltr">tournaments</code>:
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_all') }}">all</a></dt>
    <dd>Возвращает все зарегистрированные соревнования за лигу.
        <a href="{{ route('api_tournaments',1) }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_season_sport') }}">sport/{sport_id}/season/{season_id}</a></dt>
    <dd>Возвращает соревнования за лигу по виду спорта и сезону.
        <a href="{{ route('api_tournaments_seasonsport',[1,0,1]) }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_teams') }}">teams</a></dt>
    <dd>Возвращает заявленные команды в соревновании.
        <a href="{{ route('api_tournaments_teams',1) }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_stages') }}">stages</a></dt>
    <dd>Возвращает этапы соревнования.
        <a href="{{ route('api_tournaments_stages',1) }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_struct') }}">struct</a></dt>
    <dd>Возвращает этапы соревнования.
        <a href="{{ route('api_tournaments_struct',1) }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_table') }}">struct/{struct_id}/table</a></dt>
    <dd>Возвращает турнирную таблицу этапа соревнования.
        <a href="{{ route('api_tournaments_table',[403,30]) }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_tournaments_place') }}">place</a></dt>
    <dd>Возвращает призёров завершившегося турнира.
        <a href="{{ route('api_tournaments_place',400) }}">Выполнить</a>.</dd>
@endsection

