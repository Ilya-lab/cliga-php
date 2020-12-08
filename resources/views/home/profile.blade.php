@extends('layouts.main')

@section('title')Анкета пользователя @endsection

@section('css')<link rel="stylesheet" href="{{ asset('css/switchery/switchery.min.css') }}" />
    <link href="{{ asset('js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icheck/flat/green.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js_footer')
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatables/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatables/buttons.html5.min.js?ff2') }}"></script>
    <script src="{{ asset('js/datatables/buttons.print.min.js?ff') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('js/icheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/pace/pace.min.js') }}"></script>
    <script>
        var handleDataTableButtons = function() {
                "use strict";
                0 !== $("#datatable-responsive").length && $("#datatable-responsive").DataTable({
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "copy",
                        className: "btn-sm"
                    }, {
                        extend: "excel",
                        className: "btn-sm"
                    }, {
                        extend: "pdf",
                        className: "btn-sm"
                    }, {
                        extend: "print",
                        className: "btn-sm"
                    }],
                    responsive: !0
                })
            },
            TableManageButtons = function() {
                "use strict";
                return {
                    init: function() {
                        handleDataTableButtons()
                    }
                }
            }();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable-responsive').DataTable();
        });
        TableManageButtons.init();
    </script>
@endsection

@section('content')

@component('components.main_block')
    @slot('title'){{ $user->name }} @endslot
    @slot('description')анкета пользователя системы @endslot
    <form method="POST" action="{{ route('profile_update', ['id' => $user->id]) }}" class="form-horizontal form-label-left">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="form-group row">
            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Имя пользователя</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" class="has-feedback-left form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                @if ($errors->has('name'))
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required">{{ $errors->first('name') }}</li></ul>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">E-Mail</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="email" class="has-feedback-left form-control" name="email" disabled="disabled" value="{{ $user->email }}" required>
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                @if ($errors->has('email'))
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required">{{ $errors->first('email') }}</li></ul>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Изменить пароль</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="password" class="has-feedback-left form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ $user->password }}">
                <span class="fa fa-terminal form-control-feedback left" aria-hidden="true"></span>
                @if ($errors->has('password'))
                    <ul class="parsley-errors-list filled" id="parsley-id-7"><li class="parsley-required">{{ $errors->first('password') }}</li></ul>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="control-label col-md-3 col-sm-3 col-xs-12">Подтверждение пароля</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password-confirm" type="password" class="has-feedback-left form-control" name="password_confirmation" value="{{ $user->password }}">
                <span class="fa fa-terminal form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        @if(Auth::user()->isAdmin() && Auth::user()->id != $user->id)
        <div class="form-group row">
            <label for="admin" class="control-label col-md-3 col-sm-3 col-xs-12">Администратор системы</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>
                    <input id="admin" name="user_type" type="checkbox" class="js-switch" {{ $user->user_type == 1 ? 'checked' : '' }}/>
                </label>
            </div>
        </div>
        <div class="form-group row">
            <label for="user_active" class="control-label col-md-3 col-sm-3 col-xs-12">Включен</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>
                    <input id="user_active" name="active" type="checkbox" class="js-switch" {{ $user->active == 1 ? 'checked' : '' }} />
                </label>
            </div>
        </div>
        @endif
        <div class="ln_solid"></div>
        <div class="form-group row mb-0">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-primary">
                    Обновить
                </button>
                @if(Auth::user()->isAdmin() && Auth::user()->id != $user->id)
                <button type="button" class="btn btn-success" onclick="if(!confirm('Удалить пользователя?')) return false; window.location.href='{{ url()->current().'/delete' }}'">
                    Удалить
                </button>
                @endif
            </div>
        </div>
    </form>
@endcomponent

@if(Auth::user()->isAdmin())
@component('components.main_block')
    @slot('title')Роли @endslot
    @slot('description')пользователя системы @endslot
    @if($user->isAdmin())
    Администратор имеет права на любые операции
    @else
        <div class="ln_solid"></div>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap responsive-utilities" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Роль</th>
                <th>Описание</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user->roles as $role)
                <tr class="even pointer">
                    <td class="align-content-center">{{ $loop->index + 1 }}</td>
                    <td class="a-center">{{ $role->name }}</td>
                    <td class="a-center"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endcomponent
@endif
<script src="{{ asset('js/switchery/switchery.min.js') }}"></script>
@endsection
