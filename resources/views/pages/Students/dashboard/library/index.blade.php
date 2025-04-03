@extends('layouts.master')

@section('css')
    @toastr_css
@section('title')
    {{ trans('Students_trans.Book_List') }}
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Students_trans.Book_List') }}
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
                                    <table id="datatable" class="table table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('Students_trans.Books_name') }}</th>
                                            <th>{{ trans('Students_trans.Name_of_material') }}</th>
                                            <th>{{ trans('Students_trans.filename') }}</th>
                                            <th>{{ trans('Students_trans.Processes') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($books as $book)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->subject_name }}</td>
                                                <td>{{ $book->file_name }}</td>
                                                <td>

                                                    <a href="{{ route('downloadAttachmentStudent', $book->file_name) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> {{ trans('Students_trans.Download') }}
                                                    </a>

                                                </td>
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
    @toastr_js
    @toastr_render
@endsection