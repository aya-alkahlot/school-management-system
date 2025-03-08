@extends('layouts.master')

@section('css')
    @toastr_css
@section('title')
    المواد الدراسية الخاصة بك
@stop
@endsection

@section('page-header')
@section('PageTitle')
    المواد الدراسية الخاصة بك
@stop
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-sm table-bordered p-0"
                        data-page-length="50" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المادة الدراسية</th>
                                <th>المعلم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $index => $subject)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->teacher->Name }}</td>
                                </tr>
                            @endforeach
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
