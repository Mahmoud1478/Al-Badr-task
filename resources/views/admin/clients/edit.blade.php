@extends('admin.layouts.master')
@section('name')
    Clients
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Clients</li>
@endsection
@section('css_plugin')
    <link rel="stylesheet" href="{{url('admin')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <script src="{{url('admin')}}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
@endsection
@section('css')
   <style>
       .bootstrap-switch * ,.bootstrap-switch , .bootstrap-switch .bootstrap-switch-container span{
           height: 100% !important;
       }
       .bootstrap-switch-container{
           display: flex !important;
           align-items: center !important;
       }
       .bootstrap-switch{
           border: none !important;
           outline: none !important;
       }
       .bootstrap-switch-container span {
           line-height: 1.6!important;
           font-size:.9rem !important;
       }
   </style>
@endsection
@section('content')
    <form class="card" method="post" action="{{route('admin.clients.update',$client->id)}}"
          enctype="multipart/form-data">
        <div class="card-header  w-100">
            <h3 class="card-title p-2 d-block">Clients Management</h3>
            <div class="card-tools">
                <button class="btn btn-primary" type="submit"> save</button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method("put")
            <div class="row">
                <div class="form-group col-4">
                    <label>First Name <span class="text-danger">*</span></label>
                    <input type="text" required name="first_name" class="form-control" value="{{$client->first_name}}">
                    @error('first_name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group  col-4">
                    <label>Middle Name</label>
                    <input type="text" name="mid_name" class="form-control" value="{{$client->mid_name}}">
                    @error('mid_name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label>Last Name <span class="text-danger">*</span></label>
                    <input type="text" required name="last_name" class="form-control" value="{{$client->last_name}}">
                    @error('last_name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                    <div class="form-control p-0 d-flex align-items-center">
                        <input type="email" style="flex-grow: 1; height: 100%; padding: 2px 5px; border: none;outline: none" required name="email" id="exampleInputEmail1"
                               value="{{$client->email}}">
                        <input type="checkbox"  name="verify" @checked($client->hasVerifiedEmail()) data-bootstrap-switch>
                    </div>
                    @error('email')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" required class="form-control" id="phone" name="phone" value="{{$client->phone}}">
                    @error('phone')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="email" name="password" class="form-control" id="exampleInputEmail1">
                    @error('password')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Password Confirmation</label>
                    <input type="text" name="password_confirmation" class="form-control" id="phone">
                    @error('password_confirmation')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Longitude<span class="text-danger">*</span></label>
                    <input type="text" required name="longitude" value="{{$client->longitude}}" class="form-control"
                           id="#lng">
                    @error('longitude')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Latitude<span class="text-danger">*</span></label>
                    <input type="text" required name="latitude" value="{{$client->latitude}}" class="form-control"
                           id="#lng">
                    @error('latitude')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputFile">Image <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input  type="file" class="custom-file-input" name="image" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    @error('image')
                    <span class="text-danger d-block">
                                {{$message}}
                        </span>
                    @enderror
                    @if($client->image)
                        <img src="{{$client->image_url}}" class="img-fluid mt-2">
                    @endif
                </div>
                <div class="form-group col-6">
                    <label for="exampleInputFile">Drive Licence</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="drive_licence" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    @error('drive_licence')
                    <span class="text-danger d-block ">
                                {{$message}}
                        </span>
                    @enderror
                    @if($client->drive_licence)
                        <img src="{{$client->drive_licence_url}}" class="img-fluid mt-2">
                    @endif
                </div>

            </div>
        </div>
        <!-- /.card-body -->
    </form>
@endsection
@section('js-plugin')
    <script src="{{url('admin')}}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
          $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
          })
        })
    </script>

    {{--    <script>--}}
    {{--        // $(document).ready(function () {--}}
    {{--            let map;--}}
    {{--            let marker;--}}
    {{--            async function initMap() {--}}

    {{--                const myLatlng = new google.maps.LatLng("{{$client->latitude}}","{{$client->longitude}}");--}}
    {{--                const myOptions = {--}}
    {{--                    zoom: 14,--}}
    {{--                    center: myLatlng,--}}
    {{--                    mapTypeId: google.maps.MapTypeId.ROADMAP--}}
    {{--                }--}}
    {{--                map = new google.maps.Map(document.getElementById("map"), myOptions);--}}
    {{--                addMarker(myLatlng)--}}
    {{--                google.maps.event.addListener(map, 'click', function (event) {--}}
    {{--                    addMarker(event.latLng);--}}
    {{--                });--}}

    {{--            }--}}
    {{--            window.initMap = initMap;--}}
    {{--            // Function for adding a marker to the page.--}}
    {{--            function addMarker(location) {--}}
    {{--                if (marker && marker.setMap) {--}}
    {{--                    marker.setMap(null);--}}
    {{--                }--}}

    {{--                $('#lng').val(location.lng());--}}
    {{--                $('#lat').val(location.lat());--}}

    {{--                marker = new google.maps.Marker({--}}
    {{--                    position: location,--}}
    {{--                    map: map--}}
    {{--                });--}}
    {{--            }--}}

    {{--        // })--}}
    {{--    </script>--}}
    {{--    <script--}}
    {{--        src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&callback=initMap&language=ar&region=EG"--}}
    {{--        async defer></script>--}}
@endsection
