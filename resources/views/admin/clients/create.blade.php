@extends('admin.layouts.master')
@section('name')
    Clients
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Clients</li>
@endsection
@section('content')
    <form class="card" method="post" action="{{route('admin.clients.store')}}" enctype="multipart/form-data">
        <div class="card-header  w-100">
            <h3 class="card-title p-2 d-block">Clients Management</h3>
            <div class="card-tools">
                <button class="btn btn-primary" type="submit"> save </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            <div class="row">
                <div class="form-group col-4">
                    <label>First Name <span class="text-danger">*</span></label>
                    <input type="text" required value="{{old('first_name')}}" name="first_name" class="form-control">
                    @error('first_name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group  col-4">
                    <label >Middle Name</label>
                    <input type="text"  value="{{old('mid_name')}}" name="mid_name" class="form-control">
                    @error('mid_name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label>Last Name <span class="text-danger">*</span></label>
                    <input type="text" required value="{{old('last_name')}}" name="last_name" class="form-control">
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
                    <input type="email" required value="{{old('email')}}" name="email" class="form-control" id="exampleInputEmail1">
                    @error('email')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" required value="{{old('phone')}}" name="phone" class="form-control" id="phone">
                    @error('phone')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Password <span class="text-danger">*</span></label>
                    <input type="password" required name="password" class="form-control" id="exampleInputEmail1">
                    @error('password')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Password Confirmation <span class="text-danger">*</span></label>
                    <input type="password" required name="password_confirmation" class="form-control" id="phone">
                    @error('password_confirmation')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Longitude<span class="text-danger">*</span></label>
                    <input type="text" required value="{{old('longitude')}}" name="longitude"  class="form-control"  id="#lng">
                    @error('longitude')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Latitude<span class="text-danger">*</span></label>
                    <input type="text" required value="{{old('latitude')}}" name="latitude" class="form-control"  id="#lng">
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
                            <input required type="file" class="custom-file-input" name="image" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    @error('image')
                    <span class="text-danger d-block">
                                {{$message}}
                        </span>
                    @enderror
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
                    <span class="text-danger d-block">
                        {{$message}}
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </form>
@endsection
@section('js')

{{--    <script>--}}
{{--        // $(document).ready(function () {--}}
{{--        let map;--}}
{{--        let marker;--}}
{{--        async function initMap() {--}}
{{--            navigator.geolocation.getCurrentPosition(function (position) {--}}
{{--                const myLatlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude );--}}
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
{{--            });--}}
{{--        }--}}
{{--        window.initMap = initMap;--}}
{{--        // Function for adding a marker to the page.--}}
{{--        function addMarker(location) {--}}
{{--            if (marker && marker.setMap) {--}}
{{--                marker.setMap(null);--}}
{{--            }--}}

{{--            $('#lng').val(location.lng());--}}
{{--            $('#lat').val(location.lat());--}}

{{--            marker = new google.maps.Marker({--}}
{{--                position: location,--}}
{{--                map: map--}}
{{--            });--}}
{{--        }--}}
{{--        // })--}}
{{--    </script>--}}
{{--    <script--}}
{{--        src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&callback=initMap&language=ar&region=EG"--}}
{{--        async defer></script>--}}
@endsection

