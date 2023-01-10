@extends('admin.layouts.master')
@section('name')
    Clients
@endsection
@section('css_plugin')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('admin')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{url('admin')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{url('admin')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Clients</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header w-100">
            <h3 class="card-title p-2 d-block">Clients Management</h3>
                <div class="card-tools">
                    @can('create-clients')
                        <a href="{{route("admin.clients.create")}}" class="btn  btn-primary"> New </a>
                    @endcan
                </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Verified At</th>
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
                    url: "{{route('admin.clients.datatable')}}",
                    delay: 250,
                    type: "get"
                },
                columns:[
                    {data: "full_name", name: "full_name"},
                    {data: "email", name: "email"},
                    {data: "phone", name: "phone"},
                    {data: "email_verified_at", name: "email_verified_at"},
                    {data: "actions", searchable: false , orderable:false},
                ],
            });
            $(document).on('click','.delete-btn', (e)=> deleteRecord(e.target, dt))
            $(document).on('click','.toggle', (e)=> {
                const btn = $(e.target)
                const msg = btn.hasClass('btn-success') ? "Email will be verified" : "Email well be unverified"
                confirmAction((choice) => {
                    if (choice.value){
                        const html = btn.html();
                        $.ajax({
                            url : btn.data('url'),
                            method : 'patch',
                            beforeSend:()=>btn.html('<i class="fa fa-spinner fa-spin"></>').prop('disabled',true),
                            complete:()=> btn.html(html).prop('disabled',false),
                            success :(res)=>{
                                dt.ajax.reload();
                                toastr.success(res.msg)
                            },
                            fail:(res)=>{
                                console.log(res)
                            }
                        })
                    }
                },msg);
            })

        });
    </script>
@endsection
