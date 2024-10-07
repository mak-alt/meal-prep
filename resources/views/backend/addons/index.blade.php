@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.addons.index') }}

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive-sm">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Required Meals Amount</th>
                                    <th>Menu Categories</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($addons as $addon)
                                    <tr>
                                        <td>{{ $addon->id }}</td>
                                        <td>{{ $addon->name }}</td>
                                        <td>{{ $addon->required_minimum_meals_amount }}</td>
                                        <td>{{ $addon->categories->implode('name', ', ') }}</td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.addons.edit', $addon->id) }}"
                                                   class="btn btn-block btn-primary">
                                                    Edit
                                                </a>
                                                <a href="{{ route('backend.addons.destroy', $addon->id) }}"
                                                   class="btn btn-block btn-danger" data-action="delete-record">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $addons->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
