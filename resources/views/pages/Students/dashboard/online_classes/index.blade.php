@extends('layouts.master')

@section('css')
    @toastr_css
@endsection

@section('title')
    {{ trans('Students_trans.Online_classes') }}
@endsection

@section('page-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">{{ trans('Students_trans.Online_classes') }}</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm table-bordered text-center">
                            <thead class="alert-success">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Students_trans.Class_title') }}</th>
                                    <th>{{ trans('Students_trans.Start_date') }}</th>
                                    <th>{{ trans('Students_trans.Class_time') }}</th>
                                    <th>{{ trans('Students_trans.Share_link') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($online_classes as $index => $class)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $class->topic }}</td>
                                    <td>{{ $class->start_at ? $class->start_at->format('Y-m-d H:i') : 'غير محدد' }}</td>
                                    <td>{{ $class->duration }} دقائق</td>
                                    <td>
                                        <a href="{{ $class->join_url }}" target="_blank" class="btn btn-primary btn-sm">
                                            {{ trans('Students_trans.Join_now') }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد حصص متاحة حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection