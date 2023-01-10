<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('admin') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ url('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('admin') }}/plugins/toastr/toastr.min.css">
    <!-- page level plugin -->
    @yield('css_plugin')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('admin')}}/css/adminlte.min.css">
    <!-- page level css -->
    <style>
        .swal2-actions{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .swal2-actions button:not(:last-of-type) {
            margin-inline-end: 5px;
        }
    </style>
    @yield('css')
</head>
