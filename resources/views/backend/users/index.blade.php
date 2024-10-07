@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.users.index') }}

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
                                    <th>Email</th>
                                    <th>Account Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $user->email }}" class="btn-link">{{ $user->email }}</a>
                                        </td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.users.edit', $user->id) }}"
                                                   class="btn btn-block btn-primary">
                                                    Edit
                                                </a>
                                                <a href="{{ route('backend.users.destroy', $user->id) }}"
                                                   class="btn btn-block btn-danger" data-action="delete-record">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
