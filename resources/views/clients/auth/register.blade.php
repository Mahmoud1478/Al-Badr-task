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
    <form action="{{route('client.register')}}" method="post">
        <h1>Register</h1>
        @csrf
        <div class="content">
            <div class="input-field">
                <input type="text" name="first_name" placeholder="First name" autocomplete="nope">
                @error('first_name')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field">
                <input type="text"  name="mid_name" placeholder="Mid Name" autocomplete="new-password">
                @error('first_name')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field">
                <input type="text"  name="last_name" placeholder="Last name" autocomplete="new-password">
                @error('first_name')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field">
                <input type="text"  name="phone" placeholder="Phone" autocomplete="new-password">
                @error('phone')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
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
            <div class="input-field">
                <input type="password"  name="password_confirmation" placeholder="Password Confirmation" autocomplete="new-password">
                @error('password_confirmation')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field">
                <label style="text-align: left"> drive licence</label>
                <input type="file" name="image">

                @error('image')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>
            <div class="input-field">
                <label style="text-align: left"> drive licence</label>
                <input type="file" name="drive_licence">
                @error('drive_licence')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
            </div>

            <div class="input-field" >
                <label style="text-align: left"> address</label>
                @error('latitude')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
                @error('longitude')
                <span class="text-danger">
                            {{$message}}
                        </span>
                @enderror
                <div id="map"  style="height: 300px"></div>
                <input type="hidden" name="latitude" id="#lat">
                <input type="hidden" name="longitude" id="#lng">

            </div>
            <div class="input-field " style="display: flex; align-items: center">
                <input type="checkbox" style="width: 50px" name="remember_me"> <label>Remember Me</label>
            </div>
        </div>
        <div class="action">
            <a class="req" href="{{route('client.login.form')}}">Sign in</a>
            <button>Register</button>
        </div>
    </form>
</div>
<!-- partial -->
<script>
    // $(document).ready(function () {
    let map;
    let marker;
    async function initMap() {
        navigator.geolocation.getCurrentPosition(function (position) {
            const myLatlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude );
            const myOptions = {
                zoom: 14,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map"), myOptions);

            google.maps.event.addListener(map, 'click', function (event) {
                addMarker(event.latLng);
            });
            addMarker(myLatlng)
        });
    }
    window.initMap = initMap;
    // Function for adding a marker to the page.
    function addMarker(location) {
        if (marker && marker.setMap) {
            marker.setMap(null);
        }

        $('#lng').val(location.lng());
        $('#lat').val(location.lat());

        marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
    // })
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&callback=initMap&language=ar&region=EG"
    async defer></script>
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
