@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Show Client')


@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Show Client</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="fname">First Name</label>
                        <input type="text" readonly id="fname" class="form-control" required name="fname"
                            value="{{$client->fname}}">
                        @error('fname')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="lname">Last Name</label>
                        <input type="text" readonly id="lname" class="form-control" required name="lname"
                            value="{{$client->lname}}">
                        @error('lname')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" readonly id="email" class="form-control" required name="email"
                            value="{{$client->email}}">
                        @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="text" readonly id="phone" class="form-control" required name="phone"
                            value="{{$client->phone}}">
                        @error('phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="city_id">City</label>
                        <input type="text" readonly id="city_id" class="form-control" required name="city_id"
                            value="{{$client->city->name_en}}">
                        @error('city_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="area_id">Area</label>
                        <input type="text" readonly id="area_id" class="form-control" required name="area_id"
                            value="{{$client->area->name_en}}">
                        @error('area_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <img src="{{url($client->image)}}" alt="Lights" style="width:100%; margin-left: 200px;">
                        <div class="mt-3"></div>
                    </div>
                </div>
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
