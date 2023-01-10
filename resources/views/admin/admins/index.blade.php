@extends('admin.layouts.master')
@section('name')
    Users
@endsection
@section('css_plugin')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('admin')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{url('admin')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{url('admin')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header w-100">
            <h3 class="card-title p-2 d-block">Clients Management</h3>
                <div class="card-tools">
                    @if(auth('admin')->id() == 1)
                        <a href="{{route("admin.users.create")}}" class="btn btn-primary"> New </a>
                    @endif
                </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
              <tbody></tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection

@section('js-plugin')
    <!-- DataTables  & Plugins -->
    <script src="{{url('admin')}}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{url('admin')}}/plugins/jszip/jszip.min.js"></script>
    <script src="{{url('admin')}}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{url('admin')}}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{url('admin')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
@endsection

@section('js')
    <script>
        $(function () {
            const dt = $("#example1").DataTable({
                lengthMenu: [[10, 25, 50], [10, 25, 50]],
                dom: "<'mb-2' B><'d-flex mt-2 align-items-center justify-content-between' lf> rt <'d-flex align-items-center justify-content-between' ip>",
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                ajax:{
                    url: "{{route('admin.users.datatable')}}",
                    delay: 250,
                    type: "get"
                },
                columns:[
                    {data: "name", name: "name"},
                    {data: "email", name: "email"},
                    {data: "actions", searchable: false , orderable:false},
                ],
            });
            @if(auth('admin')->id()==1)
                $(document).on('click','.delete-btn', (e)=> deleteRecord(e.target, dt))
            @endif


        });
    </script>
@endsection
