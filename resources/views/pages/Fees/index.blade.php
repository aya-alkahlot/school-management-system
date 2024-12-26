@extends('layouts.master')
@section('css')
@toastr_css
@section('title')
{{trans('main_trans.Fees')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('main_trans.Fees')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="col-xl-12 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <a href="{{route('Fees.create')}}" class="btn btn-success btn-sm" role="button"
                                aria-pressed="true">{{trans('Students_trans.Add_tuition_fees')}}</a><br><br>
                            <div class="table-responsive">
                                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                    data-page-length="50"
                                    style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{trans('Students_trans.title')}}</th>
                                            <th>{{trans('Students_trans.Amount')}}</th>
                                            <th>{{trans('Students_trans.Academic_stage')}}</th>
                                            <th>{{trans('Students_trans.classrooms')}}</th>
                                            <th>{{trans('Students_trans.Academic_year')}}</th>
                                            <th>{{trans('Students_trans.Fee_type')}}</th>
                                            <th>{{trans('Students_trans.comments')}}</th>
                                            <th>{{trans('Students_trans.Processes')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fees as $fee)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{$fee->title}}</td>
                                            <td>{{$fee->amount}}</td>
                                            <td>{{$fee->grade->Name}}</td>
                                            <td>{{$fee->classroom->Name_Class}}</td>
                                            <td>{{$fee->year}}</td>
                                            <td>{{$fee->Fee_type}}</td>
                                            <td>{{$fee->description}}</td>
                                            <td>
                                                <a href="{{route('Fees.edit',$fee->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#Delete_Fee{{ $fee->id }}" title="{{ trans('Grades_trans.Delete') }}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @include('pages.Fees.Delete')
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection