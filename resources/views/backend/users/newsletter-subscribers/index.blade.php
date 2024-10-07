@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.users.newsletter.index') }}

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive-sm">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Subscribed At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($newsletterSubscribers as $newsletterSubscriber)
                                    <tr>
                                        <td>{{ $newsletterSubscriber->id }}</td>
                                        <td>
                                            <a href="mailto:{{ $newsletterSubscriber->email }}" class="btn-link">
                                                {{ $newsletterSubscriber->email }}
                                            </a>
                                        </td>
                                        <td>{{ $newsletterSubscriber->created_at->format('m.d.Y H:i') }}</td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.users.newsletter.destroy', $newsletterSubscriber->id) }}"
                                                   class="btn btn-block btn-danger" data-action="delete-record">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $newsletterSubscribers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
