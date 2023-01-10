<!-- jQuery -->
<script src="{{url('admin')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{url('admin')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="{{url('admin')}}/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="{{url('admin')}}/plugins/toastr/toastr.min.js"></script>
<!-- page level plugin -->
@yield('js-plugin')
<!-- AdminLTE App -->
<script src="{{url('admin')}}/js/adminlte.min.js"></script>
<!-- page level js -->
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        }
    });
    const sConfirm = Swal.mixin({
        buttonsStyling: true,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
    })
    function confirmAction(callback,msg=''){
        sConfirm.fire('Are your sure ? ',msg,'warning').then(callback)
    }
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    function deleteRecord (node ,datatable) {
        confirmAction((choice) => {
            if (choice.value){
                const btn = $(node)
                const html = btn.html();
                $.ajax({
                    url : btn.data('url'),
                    method : 'delete',
                    beforeSend:()=>btn.html('<i class="fa fa-spinner fa-spin"></>').prop('disabled',true),
                    complete:()=> btn.html(html).prop('disabled',false),
                    success :(res)=>{
                        datatable.ajax.reload();
                        toastr.success(res.msg)
                    },
                    fail:(res)=>{
                        console.log(res)
                    }
                })
            }
        });
    }
    $(document).ready(function (){
        @if(session()->has('success'))
        toastr.success("{{session('success')}}")
        @endif
        @if(session()->has('error'))
        toastr.error("{{session('error')}}")
        @endif
    })

</script>
@yield('js')
