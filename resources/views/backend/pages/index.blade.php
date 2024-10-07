@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.pages.index') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive-lg">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pages as $page)
                                                <tr>
                                                    <td class="sorting_1">{{ $page->id }}</td>
                                                    <td>{{ $page->title }}</td>
                                                    <td>
                                                        <a href="{{ env('APP_URL') }}/{{ $page->slug }}">{{ $page->slug }}</a>
                                                    </td>
                                                    <td>{{ $page->status }}</td>
                                                    <td>
                                                        <div class="table_actions_btns">
                                                            <a href="{{ route('backend.pages.edit', $page->id) }}"
                                                               class="btn btn-block btn-primary">Edit</a>
                                                            <a href=""
                                                               class="btn btn-block btn-danger">Delete</a>
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
                </div>
            </div>
        </div>
    </div>
@endsection
