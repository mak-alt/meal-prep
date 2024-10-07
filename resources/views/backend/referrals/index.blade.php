@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.referrals.index') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive-lg">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Inviter name</th>
                                        <th>Invitee name</th>
                                        <th>Invitee email</th>
                                        <th>Status</th>
                                        <th>Invitation sent at</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($referrals as $referral)
                                        <tr>
                                            <td>{{ $referral->id }}</td>
                                            <td>{{ $referral->inviter->name }}</td>
                                            <td>{{ optional($referral->user)->name }}</td>
                                            <td>
                                                <a href="mailto:{{ $referral->user_email }}" class="btn-link">
                                                    {{ $referral->user_email }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($referral->isPending())
                                                    Pending
                                                @elseif($referral->isActive())
                                                    Invited
                                                    <img src="{{ asset('assets/frontend/img/Yes.svg') }}"
                                                         alt="Arrow success icon" style="width: 15px;">
                                                @endif
                                            </td>
                                            <td>{{ $referral->created_at->format('m.d.Y H:i') }}</td>
                                            <td>
                                                <div class="table_actions_btns">
{{--                                                    <a href="{{ route('backend.gifts.edit', $gift->id) }}"--}}
{{--                                                       class="btn btn-block btn-primary">--}}
{{--                                                        Edit--}}
{{--                                                    </a>--}}
                                                    <a href="{{ route('backend.referrals.destroy', $referral->id) }}"
                                                       class="btn btn-block btn-danger" data-action="delete-record">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $referrals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
