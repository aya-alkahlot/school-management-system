@extends('layouts.master')
@section('css')
@section('title')
{{ trans('Students_trans.List_of_test_results') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{ trans('Students_trans.List_of_test_results') }}
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
                            <div class="table-responsive">
                                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                    data-page-length="50"
                                    style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('Students_trans.name') }}</th>
                                            <th>{{ trans('Students_trans.Test_name') }}</th>
                                            <th>{{ trans('Students_trans.Degree') }}</th>
                                            <th>{{ trans('Students_trans.Date_the_test_was_taken') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($degrees as $degree)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{$degree->student->name}}</td>
                                            <td>{{$degree->quizze->name}}</td>
                                            <td>{{$degree->score}}</td>
                                            <td>{{$degree->date}}</td>
                                        </tr>
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

@endsection