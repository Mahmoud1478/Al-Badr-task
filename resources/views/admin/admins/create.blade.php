@extends('admin.layouts.master')
@section('name')
    Users
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
    <form class="card" method="post" action="{{route('admin.users.store')}}" enctype="multipart/form-data">
        <div class="card-header  w-100">
            <h3 class="card-title p-2 d-block">Users Management</h3>
            <div class="card-tools">
                <button class="btn btn-primary" type="submit"> save</button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            <div class="row">
                <div class="form-group col-6">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text"  required value="{{old('name')}}" name="name" class="form-control">
                    @error('name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                    <input type="email"  required value="{{old('email')}}"  name="email" class="form-control" id="exampleInputEmail1">
                    @error('email')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" required name="password" class="form-control" id="exampleInputEmail1">
                    @error('password')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Password Confirmation</label>
                    <input type="password" required name="password_confirmation" class="form-control" id="phone">
                    @error('password_confirmation')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

            </div>

            <div class="row">
                @foreach(\App\Classes\Permission::all() as $key=>$value)
                    <div class="col-md-2 col-md-3 col-lg-4">
                        <input type="checkbox" value="{{$key}}" @checked(in_array($key, old('permissions')??[])) name="permissions[]">
                        <label>{{$value['name']}}</label>

                    </div>
                @endforeach

            </div>
            @error('permissions')
            <span class="text-danger">
                            {{$message}}
                        </span>
            @enderror
            @error('permissions.*')
            <span class="text-danger">
                            {{$message}}
                        </span>
            @enderror
        </div>
        <!-- /.card-body -->
    </form>
@endsection
@section('js')
@endsection
