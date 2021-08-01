@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Show Notification')


@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Show Notification</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" readonly value="{{$notification->subject}}" id="text-input1"
                                class="form-control" required name="subject">
                            @error('subject')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" readonly required name="body" rows="5"
                                cols="30">{{$notification->body}}</textarea>
                            @error('body')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="city_id">City</label>
                            <input type="text" readonly value="{{optional($notification->city)->name_en}}" id="city_id"
                                class="form-control" required name="city_id">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="area_id">Area</label>
                            <input type="text" readonly value="{{optional($notification->area)->name_en}}" id="area_id"
                                class="form-control" required name="area_id">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="created_at">Date/Time</label>
                            <input type="text" readonly value="{{$notification->created_at}}" id="created_at"
                                class="form-control" required name="created_at">
                        </div>
                    </div>
                </div>
                <div class="m-auto">
                    <input type="checkbox" {{$notification->is_pushed? 'checked' : ''}} id="is_pushed" disabled
                        name="is_pushed">
                    <label for="is_pushed">Push</label>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/dropify/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@stop

@section('page-script')
<script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
<script src="{{ asset('assets/vendor/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/forms/dropify.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    var config ={
    _url:"{{url('/get_areas/')}}"
    }
</script>
<script src="{{ asset('assets/js/pages/getAreas.js') }}"></script>
<script>
    $(function() {
    // validation needs name of the element
    $('#food').multiselect();

    // initialize after multiselect
    $('#basic-form').parsley();
});
</script>
@stop
