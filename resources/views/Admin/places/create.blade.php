@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Create Place')


@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Create New Place</h2>
            </div>
            <div class="body">
                <form method="POST" enctype="multipart/form-data" action="{{route('admin.places.store')}}"
                    id="advanced-form" data-parsley-validate novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="text-input1">English Title</label>
                                <input type="text" value="{{old('name_en')}}" id="text-input1" class="form-control"
                                    required name="name_en">
                                @error('name_en')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="text-input2">Arabic Title</label>
                                <input type="text" value="{{old('name_ar')}}" id="text-input2" class="form-control"
                                    required name="name_ar">
                                @error('name_ar')
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
                                    cols="30">{{old('description_en')}}</textarea>
                                @error('description_en')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Arabic Description</label>
                                <textarea class="form-control" name="description_ar" rows="5"
                                    cols="30">{{old('description_ar')}}</textarea>
                                @error('description_ar')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                            <label for="city_id">City</label>
                            <select name="city_id" class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="city">
                                <option value="">Choose City</option>

                                @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name_en}}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                            <label for="area_id">Area</label>
                            <select name="area_id" class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="area">
                            
                                <option value=""></option>
                              
                            </select>
                            @error('area_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                            <label for="category_id">choose Category</label>
                            <select name="category_id" class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            
                                <option value="">choose</option>
                                @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->name_en}}</option>
                                    
                                @endforeach
                              
                            </select>
                            @error('category_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>English Description</label>
                                <textarea class="form-control" name="address_en" rows="5"
                                    cols="30">{{old('address_en')}}</textarea>
                                @error('address_en')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Arabic Description</label>
                                <textarea class="form-control" name="address_ar" rows="5"
                                    cols="30">{{old('address_ar')}}</textarea>
                                @error('address_ar')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="text-input1">Latirude</label>
                                <input type="number" value="{{old('longitude')}}" id="text-input1" class="form-control"
                                    required name="longitude">
                                @error('longitude')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="text-input2">Longitude</label>
                                <input type="number" value="{{old('latitude')}}" id="text-input2" class="form-control"
                                    required name="latitude">
                                @error('latitude')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                            <label for="city_id">Active Top Rating</label>
                            <select name="active_topRating" class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                            <label for="area_id">Active Popular</label>
                            <select name="active_popular" class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="1">Active</option>
                                <option value="0">Not Active</option> 
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Main Image</h2>
                                </div>
                                <div class="body">      
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="file" value="{{old('main_image')}}" class="dropify" name="main_image">
                                            @error('main_image')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                            <div class="mt-3"></div>
                                        </div>
                                    </div>                                  
                            </div>
                        </div>
                    </div>
                    </div>         
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Gallery</h2>
                                </div>
                                <div class="body">
                                <div class="row">
                                    @for ($i =0 ; $i <12 ; $i++)
                                    <div class="col-3">
                                        <input type="file"  class="dropify" name="images[]"  multiple>
                                        @error('images.0')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        <div class="mt-3"></div>
                                    </div>
                                    @endfor   
                                    </div>      
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-primary">Create</button>
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
