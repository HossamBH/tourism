@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Edit Banner')


@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Edit New Banner</h2>
            </div>
            <div class="body">
                <form method="POST" enctype="multipart/form-data"
                    action="{{route('admin.banners.update',['banner'=>$banner->id])}}" id="advanced-form"
                    data-parsley-validate novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="text-input1">English Title</label>
                                <input type="text" id="text-input1" class="form-control" required name="title_en"
                                    value="{{$banner->title_en}}">
                                @error('title_en')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="text-input2">Arabic Title</label>
                                <input type="text" id="text-input2" class="form-control" required name="title_ar"
                                    value="{{$banner->title_ar}}">
                                @error('title_ar')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>English Description</label>
                                <textarea class="form-control" name="description_en" rows="5"
                                    cols="30">{{$banner->description_en}}</textarea>

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Arabic Description</label>
                                <textarea class="form-control" name="description_ar" rows="5"
                                    cols="30">{{$banner->description_ar}}</textarea>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="file" class="dropify" name="image">
                            <div class="mt-3"></div>
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
    $(function() {
    // validation needs name of the element
    $('#food').multiselect();

    // initialize after multiselect
    $('#basic-form').parsley();
});
</script>
@stop
