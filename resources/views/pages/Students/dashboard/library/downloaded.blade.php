@extends('layouts.master')

@section('css')
    @toastr_css
@section('title')
    {{ trans('Students_trans.Downloaded_Books') }}
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Students_trans.Downloaded_Books') }}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
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
                                <th>{{ trans('Students_trans.Books_name') }}</th>
                                <th>{{ trans('Students_trans.Downloaded_books') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($downloadedBooks as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>
                                        <a href="{{ route('student.library.download', $book->file_name) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-download"></i> {{ trans('Students_trans.Download') }}
                                        </a>
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
<!-- row closed -->
@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection