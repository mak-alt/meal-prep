@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.gifts.edit', $gift) }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.gifts.update', $gift->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    @include('backend.layouts.partials.alerts.flash-messages')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Sender name</label>
                                                <input type="text" name="sender_name" class="form-control" id="name"
                                                       placeholder="Sender name..."
                                                       value="{{ old('sender_name', $gift->sender_name) }}"
                                                       autocomplete="name" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'sender_name'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Receiver {{ $gift->sent_via === 'email' ? "email" : 'phone'}}</label>
                                                <input type="email" name="sent_to" class="form-control" id="email"
                                                       placeholder="Receiver email..." autocomplete="email"
                                                       value="{{ old('sent_to', $gift->sent_to) }}" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'sent_to'])
                                            </div>
                                        </div>
                                        @if($gift->sent_via === 'email')
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="delivery-date">Delivery date</label>
                                                    <input type="date" name="delivery_date" class="form-control"
                                                           id="delivery-date"
                                                           value="{{ old('delivery_date', $gift->delivery_date->format('Y-m-d')) }}"
                                                           placeholder="Delivery date..." required>
                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_date'])
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="amount">Amount ($)</label>
                                                <input type="number" name="amount" class="form-control" id="amount"
                                                       placeholder="Amount..." min="1"
                                                       value="{{ old('amount', $gift->amount) }}" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'amount'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="message">Message</label>
                                                <textarea class="form-control" name="message" id="message" rows="8"
                                                          required>{{ old('message', $gift->message) }}</textarea>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'message'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
