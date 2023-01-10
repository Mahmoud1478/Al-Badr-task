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
<div class="login-form">
    <form action="{{route('client.login')}}" method="post">
        <h1>Login</h1>
        @csrf
        <div class="content">
            <div class="input-field">
                <input type="email" name="email" placeholder="Email" autocomplete="nope">
                @error('email')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field">
                <input type="password"  name="password" placeholder="Password" autocomplete="new-password">
                @error('password')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field " style="display: flex; align-items: center">
                <input type="checkbox" style="width: 50px" name="remember_me"> <label>Remember Me</label>
            </div>
        </div>
        <div class="action">
            <a class="req" href="{{route('client.register.form')}}">Register</a>
            <button>Sign in</button>
        </div>
    </form>
</div>
<!-- partial -->
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
</script>
</body>
</html>
