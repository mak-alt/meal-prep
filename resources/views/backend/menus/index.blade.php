@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.menus.index') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Meals</th>
                                                <th>Description</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($menus as $menu)
                                                <tr>
                                                    <td>{{ $menu->id }}</td>
                                                    <td>{{ $menu->name }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($menu->meals->implode('name', ', '), 50) }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($menu->description, 50) }}</td>
                                                    <td>{{ $menu->category->name ?? 'No category' }}</td>
                                                    <td class="text-center">
                                                        @if($menu->status)
                                                            <span class="badge rounded-pill bg-success">Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="table_actions_btns">
                                                            <a href="{{ route('backend.menus.edit', $menu->id) }}"
                                                               class="btn btn-block btn-primary">
                                                                Edit
                                                            </a>
                                                            <a href="{{ route('backend.menus.destroy', $menu->id) }}"
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
                                        {{ $menus->links() }}
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
