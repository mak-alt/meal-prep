@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.users.payment-history.index') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Payment service</th>
                                        <th>Transaction ID</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Receipt</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>
                                                @if($payment->user->id)
                                                    <a href="{{ route('backend.users.edit', $payment->user->id) }}"
                                                       class="btn-link">
                                                        {{ $payment->user->name }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>${{ $payment->amount }}</td>
                                            <td class="text-center">
                                                @if($payment->isStripe())
                                                    <a href="https://stripe.com/" target="_blank">
                                                        <i class="fab fa-2x fa-cc-stripe"></i>
                                                    </a>
                                                @elseif($payment->isPaypal())
                                                    <a href="https://www.paypal.com/us/webapps/mpp/home"
                                                       target="_blank">
                                                        <i class="fab fa-2x fa-cc-paypal"></i>
                                                    </a>
                                                @else
                                                    <a href="https://developer.payeezy.com/"
                                                       target="_blank">
                                                        <i class="far fa-credit-card"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $payment->transaction_id }}</td>
                                            <td>{{ ucfirst($payment->status) }}</td>
                                            <td>{{ $payment->description }}</td>
                                            <td>
                                                <div class="table_actions_btns">
                                                    @if($payment->receipt_url)
                                                        <a href="{{ $payment->receipt_url }}" target="_blank"
                                                           class="btn btn-block btn-primary">
                                                           <i class="fa fa-file-alt"></i> View
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $payments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
