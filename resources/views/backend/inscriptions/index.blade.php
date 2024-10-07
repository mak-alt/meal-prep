@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.inscriptions.index') }}

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
                                                <th>Page</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($inscriptions as $inscription)
                                                <tr>
                                                    <td class="sorting_1">{{ $inscription->id }}</td>
                                                    <td>{{ $inscription->data ?? '' }}</td>
                                                    <td>
                                                        @if($inscription->page === '/')
                                                            <a href="{{ $inscription->page ?? '#' }}">{{ $inscription->page ?? '' }}</a>
                                                        @elseif($inscription->page === 'checkout')
                                                            <a href="#">{{ $inscription->page ?? '' }}</a>
                                                        @else
                                                            <a href="{{ '/' . ($inscription->page ?? '') }}">{{ $inscription->page ?? '' }}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="table_actions_btns">
                                                            <a href="{{ route('backend.inscriptions.edit', $inscription->id) }}"
                                                               class="btn btn-block btn-primary">Edit</a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{$inscriptions->links()}}
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
