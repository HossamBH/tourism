@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Edit Role')


@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Edit Role</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{route('admin.users.update',['user'=>$user->id])}}" id="advanced-form"
                    data-parsley-validate novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <b>Name</b>
                                <input type="text" class="form-control" placeholder="Enter User Name"
                                    value="{{old('name', $user->name)}}" name="name"><br>
                                @error('name')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <b>Email</b>
                                <input type="email" class="form-control" value="{{old('email', $user->email)}}"
                                    placeholder="Enter User Email" name="email"><br>
                                @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <b>Password</b>
                                <input type="password" class="form-control" placeholder="Enter Password"
                                    name="password"><br>
                                @error('password')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <b>Password Confirmation</b>
                                <input type="password" class="form-control" placeholder="Enter Password Confirmation"
                                    name="password_confirmation"><br>
                                @error('password_confirmation')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="form-group">
                            <b for="roles_list[]">Role List</b>
                            </br>
                            <input id="select-all" type="checkbox"><label for='select-all'>Select All</label>
                            </br>
                            <div class="row">
                                @foreach($roles as $role)
                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        @if($user->hasRole($role->name))
                                        <input type="checkbox" value="{{$role->id}}" name="roles_list[]" checked>
                                        @else
                                        <input type="checkbox" value="{{$role->id}}" name="roles_list[]">
                                        @endif
                                        <label>{{$role->name}}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('roles_list')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-9 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="guard_name" value="web" hidden>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@stop

@section('page-script')
<script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
<script>
    $("#select-all").click(function(){
      $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });
</script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    $(function() {
    // validation needs name of the element
    $('#food').multiselect();

    // initialize after multiselect
    $('#basic-form').parsley();
});
</script>
@stop
