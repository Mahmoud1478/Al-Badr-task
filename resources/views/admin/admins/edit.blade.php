@extends('admin.layouts.master')
@section('name')
    Users
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
    <form class="card" method="post" action="{{route('admin.users.update',$user->id)}}" enctype="multipart/form-data">
        <div class="card-header  w-100">
            <h3 class="card-title p-2 d-block">Users Management</h3>
            <div class="card-tools">
                <button class="btn btn-primary" type="submit"> save</button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method("put")
            <div class="row">
                <div class="form-group col-6">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" required name="name" class="form-control" value="{{$user->name}}">
                    @error('name')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                    <input type="email" required name="email" class="form-control" id="exampleInputEmail1"
                           value="{{$user->email}}">
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
                    <input type="password"  name="password" class="form-control" id="exampleInputEmail1">
                    @error('password')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="phone">Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control" id="phone">
                    @error('password_confirmation')
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

            </div>
            @if(auth('admin')->id()==1)
            <div class="row">
                @foreach(\App\Classes\Permission::all() as $key=>$value)
                    <div class="col-md-2 col-md-3 col-lg-4">
                        <input type="checkbox" @checked(in_array($key,$user->permissions)) value="{{$key}}"
                               name="permissions[]">
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
            @endif
        </div>
        <!-- /.card-body -->
    </form>
@endsection
@section('js')
@endsection
