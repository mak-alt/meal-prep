@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.gifts.index') }}

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
                                        <th>Name</th>
                                        <th>Voucher code</th>
                                        <th>Receiver</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($gifts as $gift)
                                        <tr>
                                            <td>{{ $gift->id }}</td>
                                            <td>${{ $gift->amount }} gift card</td>
                                            <td>{{ $gift->code }}</td>
                                            <td>{{ $gift->sent_to }}</td>
                                            <td>${{ $gift->amount }}</td>
                                            <td>
                                                <div class="table_actions_btns">
                                                    <a href="{{ route('backend.gifts.edit', $gift->id) }}"
                                                       class="btn btn-block btn-primary">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('backend.gifts.destroy', $gift->id) }}"
                                                       class="btn btn-block btn-danger" data-action="delete-record">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $gifts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
