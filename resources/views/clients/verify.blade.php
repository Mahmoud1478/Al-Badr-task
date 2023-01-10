<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Simple Login Form Example</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'>
    <link rel="stylesheet" href="{{ url('admin') }}/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{url('client')}}/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="login-form" style="width: 50%">
    <form action="{{route('client.try_verify')}}" method="post" style="">
        <h1>Wellcom {{$client->full_name}}</h1>
        @csrf
        <div class="content">
            <p style="text-align: left">
                we sent to your email '{{$client->email}}' code to verify your email
            </p>
            <div class="input-field">
                <input type="text" name="code" placeholder="enter your code" autocomplete="nope">
                @error('code')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
        </div>
        <div class="action">
            <button type="button" id="resend" href="#">Resend</button>
            <button>Verify</button>
        </div>
    </form>
</div>
<!-- partial -->
<script src="{{url('admin')}}/plugins/jquery/jquery.min.js"></script>
<script src="{{url('admin')}}/plugins/toastr/toastr.min.js"></script>
<script  src="{{url('client')}}/script.js"></script>
<script>
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
    $(document).ready(function (){
        @if(session()->has('success'))
        toastr.success("{{session('success')}}")
        @endif
        @if(session()->has('error'))
        toastr.error("{{session('error')}}")
        @endif
    })
    $('#resend').on('click',function (){
        const btn =$(this)
        const text = btn.html();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            url: "{{route('client.verify.resend')}}",
            method: "POST",
            type: "POST",
            beforeSend: ()=> btn.html('Resending').attr('disabled',true),
            success:(res)=>{
                btn.html(text).attr('disabled',false)
                toastr.success(res.msg)
            },
            fail:(res)=>{
                toastr.success(res.status)
            }

        })
    })
</script>

</body>
</html>
