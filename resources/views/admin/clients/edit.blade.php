@extends('admin.layouts.master')
@section('name')
    Clients
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Clients</li>
@endsection
@section('content')
    <form class="card" method="post" action="{{route('admin.clients.update',$client->id)}}" enctype="multipart/form-data">
        <div class="card-header  w-100">
            <h3 class="card-title p-2 d-block">Clients Management</h3>
            <div class="card-tools">
                <button class="btn btn-primary" type="submit"> save </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method("put")
            <div class="row">
                <div class="form-group col-4">
                    <label>First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" value="{{$client->first_name}}">
                    @error('first_name')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group  col-4">
                    <label >Middle Name</label>
                    <input type="text" name="mid_name" class="form-control" value="{{$client->mid_name}}">
                    @error('mid_name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label>Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control" value="{{$client->last_name}}">
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
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{$client->email}}">
                    @error('email')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{$client->phone}}">
                    @error('phone')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                    <input type="email" name="password" class="form-control" id="exampleInputEmail1">
                    @error('password')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="password_confirmation" class="form-control" id="phone">
                    @error('password_confirmation')
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
                            <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    @error('image')
                        <span class="text-danger d-block">
                                {{$message}}
                        </span>
                    @enderror
                    @if($client->image)
                        <img src="{{$client->image}}" class="img-fluid">
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
                        <span class="text-danger d-block">
                                {{$message}}
                        </span>
                    @enderror
                    @if($client->drive_licence)
                        <img src="{{$client->drive_licence}}" class="img-fluid">
                    @endif
                </div>

            </div>

            <div class="form-group ">
                <label for="phone">address <span class="text-danger">*</span></label>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" >Google Map</h3>
                    </div>
                    <div class="card-body">
                        <div id="map"  style="height: 500px"></div>
                    </div>
                    <input type="hidden" name="latitude" id="#lat">
                    <input type="hidden" name="longitude" id="#lng">
                </div>
                @error('address')
                    <span class="text-danger">
                      {{$message}}
                    </span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->
    </form>
@endsection
@section('js')

    <script>
        // $(document).ready(function () {
            let map;
            let marker;
            async function initMap() {

                const myLatlng = new google.maps.LatLng("{{$client->latitude}}","{{$client->longitude}}");
                const myOptions = {
                    zoom: 14,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("map"), myOptions);
                addMarker(myLatlng)
                google.maps.event.addListener(map, 'click', function (event) {
                    addMarker(event.latLng);
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
@endsection