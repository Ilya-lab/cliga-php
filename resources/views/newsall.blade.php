@extends('layouts.general')

@section('title')Все новости@endsection
@section('desc')Все новости Корпоративной лиги@endsection

@section('content')
    @foreach($news as $nn)
        {{ $nn->title }} <br>
    @endforeach
    {{ var_dump($news) }}
@endsection

@section('jsfooter')
@endsection

