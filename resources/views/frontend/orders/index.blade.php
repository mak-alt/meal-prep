@extends('frontend.layouts.app')

@php($contentClasses = 'wizard')

@section('content')
    <div class="content content-scroll">
        @include('frontend.orders.partials.content-header')
        <div class="content_main perfect_scroll">
            @includeWhen($orders->isEmpty(), 'frontend.orders.partials.content-types.empty')
            @includeWhen($orders->isNotEmpty(), 'frontend.orders.partials.content-types.not-empty')
        </div>
    </div>
@endsection
