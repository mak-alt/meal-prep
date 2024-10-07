@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.ingredients.index') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive-lg">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($ingredients as $ingredient)
                                                <tr>
                                                    <td>{{ $ingredient->id }}</td>
                                                    <td>{{ $ingredient->name }}</td>
                                                    <td>
                                                        {{ strip_tags(\Illuminate\Support\Str::limit($ingredient->description)) }}
                                                    </td>
                                                    <td>
                                                        <div class="table_actions_btns">
                                                            <a href="{{ route('backend.ingredients.edit', $ingredient->id) }}"
                                                               class="btn btn-block btn-primary">
                                                                Edit
                                                            </a>
                                                            <a href="{{ route('backend.ingredients.destroy', $ingredient->id) }}"
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
                                        {{ $ingredients->links() }}
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
