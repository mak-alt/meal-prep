@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.users.points') }}
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="search-area row">
                                <div class="col-md-3">
                                    <input type="text" name="search" placeholder="Search..." class="form-control" id="search-field"
                                           value="{{Request::has('search') ? Request::get('search') : ''}}" >
                                </div>
                                <button class="btn {{Request::has('search') ? 'btn-danger' : 'btn-gray'}}" id="clear-filters">X</button>
                            </div>
                            <div class="card-body table-responsive-sm">
                                <table class="table table-bordered table-striped table-normal">
                                    <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Points Available</th>
                                        <th>Points Used</th>
                                        <th>Points Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($users->total() === 0)
                                        <tr id="empty_row">
                                            <td colspan="5">No orders were found.</td>
                                        </tr>
                                    @else
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->full_name ?? $user->name }}</td>
                                                <td>
                                                    <a href="mailto:{{ $user->email }}" class="btn-link">{{ $user->email }}</a>
                                                </td>
                                                <td>{{ $user->userReward->unused_points ?? 0 }}</td>
                                                <td>{{ $user->userReward->used_points ?? 0 }}</td>
                                                <td>{{ $user->userReward->total_points ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/backend/js/users.js')}}"></script>
@endpush
