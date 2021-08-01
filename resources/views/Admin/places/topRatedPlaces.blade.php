@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Top Rating Places')


@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
            </div>
            <div class="body">
                <div class="table-responsive">

                    <table class="table table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Activation</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($topRatedPlaces as $place)


                            <tr>
                                <td>{{$place->id}}</td>
                                <td>{{$place->name_en}}</td>
                                <td>{{$place->description_en}}</td>
                                <td>{{$place->category->name_en}}</td>
                                <td>{{$place->area->name_en}} {{$place->city->name_en}}</td>
                                <td><button class="btn {{$place->active_topRating==1?'btn-info':'btn-danger '}} btn-xs"
                                        disabled="disabled">{{$place->active_topRating==1?'Acive':'Not Active'}}</button>
                                </td>
                                <td>
                                    <div class="col-12">
                                        <form action="{{url("/activation/{$place->id}")}}" method="post" class="delete">
                                            <input type="hidden" name="active_topRating"
                                                value={{$place->active_topRating==1?0:1}}>
                                            <button type="submit"
                                                class="btn {{$place->active_topRating==1?'btn-danger':'btn-info'}}">{{$place->active_topRating==1?'Deactivate':'Activate'}}</button>
                                            @csrf
                                        </form>
                                    </div>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}" />
<style>
    td.details-control {
        background: url('../assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('../assets/images/details_close.png') no-repeat center center;
    }
</style>
@stop

@section('page-script')
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@stop
