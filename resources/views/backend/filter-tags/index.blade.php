@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.filter-tags.index') }}

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
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tags as $tag)
                                                <tr>
                                                    <td>{{ $tag->id }}</td>
                                                    <td>{{ $tag->name }}</td>
                                                    <td>
                                                        <div class="table_actions_btns">
                                                            <a href="{{ route('backend.filter-tags.edit', $tag->id) }}"
                                                               class="btn btn-block btn-primary">
                                                                Edit
                                                            </a>
                                                            <a href="{{ route('backend.filter-tags.destroy', $tag->id) }}"
                                                               class="btn btn-block btn-danger"
                                                               data-action="delete-record">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{ $tags->links() }}
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
