@extends('layouts.main')
@section('title')Регистрация нового пользователя @endsection
@section('css')<link rel="stylesheet" href="{{ asset('css/switchery/switchery.min.css') }}" /> @endsection
@section('content')

@component('components.main_block')
    @slot('title')Регистрация @endslot
    @slot('description')нового пользователя системы @endslot
    <form method="POST" action="{{ route('register') }}" class="form-horizontal form-label-left">
        @csrf

        <div class="form-group row">
            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Имя пользователя</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" class="has-feedback-left form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                @if ($errors->has('name'))
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required">{{ $errors->first('name') }}</li></ul>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">E-Mail</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="email" class="has-feedback-left form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                @if ($errors->has('email'))
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required">{{ $errors->first('email') }}</li></ul>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Пароль</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="password" class="has-feedback-left form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                <span class="fa fa-terminal form-control-feedback left" aria-hidden="true"></span>
                @if ($errors->has('password'))
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required">{{ $errors->first('password') }}</li></ul>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="control-label col-md-3 col-sm-3 col-xs-12">Подтверждение пароля</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password-confirm" type="password" class="has-feedback-left form-control" name="password_confirmation" required>
                <span class="fa fa-terminal form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="admin" class="control-label col-md-3 col-sm-3 col-xs-12">Администратор системы</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>
                    <input id="admin" name="user_type" type="checkbox" class="js-switch" />
                </label>
            </div>
        </div>
        <div class="form-group row">
            <label for="user_active" class="control-label col-md-3 col-sm-3 col-xs-12">Включен</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>
                    <input id="user_active" name="active" type="checkbox" class="js-switch" checked />
                </label>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group row mb-0">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-primary">
                    Зарегистрировать
                </button>
            </div>
        </div>
    </form>
@endcomponent
<script src="{{ asset('js/switchery/switchery.min.js') }}"></script>
@endsection
