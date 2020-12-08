@extends('layouts.main')

@section('title')Новости @endsection

@section('js_footer')
<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
@component('components.main_block')
    @slot('title')Новости @endslot
    @slot('description')Новости турниров @endslot
    <router-view name="newsIndex"></router-view>
    <router-view></router-view>
@endcomponent
@endsection
