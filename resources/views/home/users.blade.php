@extends('layouts.main')

@section('title')Пользователи системы @endsection
@section('css')
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
    @slot('title')Пользователи @endslot
    @slot('description')список пользователей системы @endslot
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap responsive-utilities jambo_table bulk_action" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Активен</th>
            <th>Дата регистрации</th>
            <th>Дата обновления</th>
            <th>Роли</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="even pointer">
                <td class="align-content-center">{{ $loop->index + 1 }}</td>
                <td>@if($user->user_type == 1) <strong><a href="{{ route('profile', [ 'id' => $user->id]) }}">{{ $user->name }}</a></strong> @else <a href="{{ route('profile', [ 'id' => $user->id]) }}">{{ $user->name }}</a> @endif</td>
                <td>{{ $user->email }}</td>
                <td class="a-center"><input type="checkbox" class="flat" disabled @if($user->active == 1) checked @endif></td>
                <td class="a-center">{{ date('d.m.Y', strtotime($user->created_at)) }}</td>
                <td class="a-center">{{ date('d.m.Y', strtotime($user->updated_at)) }}</td>
                <td>&nbsp;</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endcomponent

@endsection
