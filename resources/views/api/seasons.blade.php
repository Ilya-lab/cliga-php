@extends('layouts.mainapi')

@section('title')Сезоны @endsection
@section('header')Описание работы с сезонами @endsection
@section('menu')
    @include('api.block_menu',['menu' => [
                                                                    array('name' => 'Сезоны', 'url' => route('api_doc_seasons')),
]                                                                ])
@endsection

@section('content')
    <p>В данном разделе описаны методы, предназначенные для получения сезонов (ресурс <code translate="no" dir="ltr">seasons</code>), сезонов в лигах.</p>

    <devsite-heading text="Полный список соревнований" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Полный список сезонов<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    <p>Для получения всех сезонов необходимо вызвать ресурс  <code translate="no" dir="ltr">seasons</code>.</p>

    <devsite-heading text="Методы" for="calling-the-api" level="h2" link="" toc="" back-to-top=""><h2 id="calling-the-api" is-upgraded="">Методы<a href="#top_of_page" class="devsite-back-to-top-link material-icons" data-title="К началу"></a></h2></devsite-heading>
    Методы, доступные через API ресурса <code translate="no" dir="ltr">seasons</code>:
    <dt class="notranslate"><a href="{{ route('api_doc_seasons_all') }}">all</a></dt>
    <dd>Возвращает все сезоны во всех лигах.
        <a href="{{ route('api_seasons') }}">Выполнить</a>.</dd>
    <dt class="notranslate"><a href="{{ route('api_doc_seasons_league') }}">league</a></dt>
    <dd>Возвращает все сезоны за конкретную лигу.
        <a href="{{ route('api_seasons_leagues',1) }}">Выполнить</a>.</dd>
@endsection

