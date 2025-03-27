@extends('layouts.master')

@section('css')
    @toastr_css
@section('title')
    {{ trans('Students_trans.Search_Library') }}
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Students_trans.Search_Library') }}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <form action="{{ route('student.library.search') }}" method="GET" class="mb-3">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="ابحث عن كتاب..." value="{{ request('query') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('Students_trans.Search') }}</button>
                </form>

                @if(isset($searchResults))
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-sm table-bordered p-0" 
                            data-page-length="50" style="text-align: center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Students_trans.Books_name') }}</th>
                                    <th>{{ trans('Students_trans.Teacher') }}</th>
                                    <th>{{ trans('Students_trans.Academic_stage') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($searchResults as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->teacher->Name }}</td>
                                        <td>{{ $book->grade->Name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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