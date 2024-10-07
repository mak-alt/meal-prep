@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.categories.index') }}

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive-lg">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Key</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->key }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($category->description) }}</td>
                                            <td>
                                                <div class="table_actions_btns">
                                                    <a href="{{ route('backend.categories.edit', $category->id) }}"
                                                       class="btn btn-block btn-primary">
                                                        Edit
                                                    </a>
                                                    @if($category->id > 5)
                                                        <a href="{{ route('backend.categories.destroy', $category->id) }}"
                                                           class="btn btn-block btn-danger" data-action="delete-record">
                                                            Delete
                                                        </a>
                                                    @endif
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
        </section>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/backend/js/categories.js')}}"></script>
@endpush
