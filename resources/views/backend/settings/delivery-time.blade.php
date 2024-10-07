{{--@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.settings.delivery-time') }}
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('backend.layouts.partials.alerts.flash-messages')

                    <form action="{{ route('backend.settings.delivery-time.update') }}" method="PUT" id="timeForm">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <div class="date">
                                            <div class="row">
                                                <h2 style="margin: 0;">Delivery</h2>
                                                <a href="" class="btn btn-green add_new_day ml-2">Add New Order Day</a>
                                            </div>
                                            @if(empty($deliveryTimes))
                                                <div class="line" data-line="1">
                                                    <div class="row">
                                                        <div class="col-md-5 form-group">
                                                            <label>Order Day</label>
                                                            <select name="delivery[1][day]" class="form-control day-select" required>
                                                                <option value="" selected disabled>Select day</option>
                                                                <option value="1">Monday</option>
                                                                <option value="2">Tuesday</option>
                                                                <option value="3">Wednesday</option>
                                                                <option value="4">Thursday</option>
                                                                <option value="5">Friday</option>
                                                                <option value="6">Saturday</option>
                                                                <option value="7">Sunday</option>
                                                            </select>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.1.day', 'isAjax' => true])
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Delivery Deadline</label>
                                                            <input type="time" class="form-control time-input"
                                                                   name="delivery[1][time]"
                                                                   required>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.1.time', 'isAjax' => true])
                                                        </div>
                                                        <div class="col-md-2 form-group mt-auto">
                                                            <button class="btn btn-danger remove-day-delivery">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="timeframes" style="">
                                                        <div class="day_time" data-day-id="1">
                                                            <div class="row">
                                                                <div class="col-md-10 form-group">
                                                                    <label>Delivery Day</label>
                                                                    <select name="delivery[1][days_available][1][day]" class="form-control delivery_day" required>
                                                                        <option value="" selected disabled>Select day</option>
                                                                        <option value="2">Monday</option>
                                                                        <option value="3">Tuesday</option>
                                                                        <option value="4">Wednesday</option>
                                                                        <option value="5">Thursday</option>
                                                                        <option value="6">Friday</option>
                                                                        <option value="7">Saturday</option>
                                                                        <option value="1">Sunday</option>
                                                                    </select>
                                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.1.days_available.1.day', 'isAjax' => true])
                                                                </div>
                                                                <div class="col-md-2 form-group mt-auto">
                                                                    <button class="btn btn-danger delivery-day-delete">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="times">
                                                                <div class="row time_block" data-number="1">
                                                                    <div class="col-md-5 form-group">
                                                                        <input type="text" class="form-control since-input time_picker"
                                                                               name="delivery[1][days_available][1][times][1][since]"
                                                                               placeholder="0:00 PM"
                                                                               value=""
                                                                               required>
                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.1.days_available.1.times.1.since', 'isAjax' => true])
                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <input type="text" class="form-control until-input time_picker"
                                                                               name="delivery[1][days_available][1][times][1][until]"
                                                                               placeholder="0:00 PM"
                                                                               value=""
                                                                               required>
                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.1.days_available.1.times.1.until', 'isAjax' => true])
                                                                    </div>
                                                                    <div class="col-md-2 form-group">
                                                                        <button class="btn btn-danger delete_time_block" data-id="1">
                                                                            <i class="fa fa-trash-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-sm btn-primary add_time_button">
                                                                <i class="fa fa-plus"></i> Add new timeframe
                                                            </button>
                                                            <button class="btn btn-sm btn-green add_delivery_day_button">
                                                                <i class="fa fa-plus"></i> Delivery day
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            @else
                                                @foreach($deliveryTimes as $key => $orderDay)
                                                    <div class="line" data-line="{{$key}}">
                                                        <div class="row">
                                                            <div class="col-md-5 form-group">
                                                                <label>Order Day</label>
                                                                <select name="delivery[{{$key}}][day]" class="form-control day-select" required>
                                                                    <option value="" selected disabled>Select day</option>
                                                                    <option value="1" {{$orderDay['day'] === '1' ? 'selected' : ''}}>Monday</option>
                                                                    <option value="2" {{$orderDay['day'] === '2' ? 'selected' : ''}}>Tuesday</option>
                                                                    <option value="3" {{$orderDay['day'] === '3' ? 'selected' : ''}}>Wednesday</option>
                                                                    <option value="4" {{$orderDay['day'] === '4' ? 'selected' : ''}}>Thursday</option>
                                                                    <option value="5" {{$orderDay['day'] === '5' ? 'selected' : ''}}>Friday</option>
                                                                    <option value="6" {{$orderDay['day'] === '6' ? 'selected' : ''}}>Saturday</option>
                                                                    <option value="7" {{$orderDay['day'] === '7' ? 'selected' : ''}}>Sunday</option>
                                                                </select>
                                                                @include('backend.layouts.partials.alerts.input-error', ['name' => "delivery.$key.day", 'isAjax' => true])
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <label for="">Delivery Deadline</label>
                                                                <input type="time" class="form-control time-input"
                                                                       name="delivery[{{$key}}][time]" value="{{$orderDay['time']}}"
                                                                       required>
                                                                @include('backend.layouts.partials.alerts.input-error', ['name' => "delivery.$key.time", 'isAjax' => true])
                                                            </div>
                                                            <div class="col-md-2 form-group mt-auto">
                                                                <button class="btn btn-danger remove-day-delivery">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="timeframes" style="">
                                                            @foreach($orderDay['days_available'] as $d => $deliveryDay)
                                                                <div class="day_time" data-day-id="{{$d}}">
                                                                    <div class="row">
                                                                        <div class="col-md-10 form-group">
                                                                            <label>Delivery Day</label>
                                                                            <select name="delivery[{{$key}}][days_available][{{$d}}][day]" class="form-control delivery_day" required>
                                                                                <option value="" selected disabled>Select day</option>
                                                                                <option value="2" {{$deliveryDay['day'] === '2' ? 'selected' : ''}}>Monday</option>
                                                                                <option value="3" {{$deliveryDay['day'] === '3' ? 'selected' : ''}}>Tuesday</option>
                                                                                <option value="4" {{$deliveryDay['day'] === '4' ? 'selected' : ''}}>Wednesday</option>
                                                                                <option value="5" {{$deliveryDay['day'] === '5' ? 'selected' : ''}}>Thursday</option>
                                                                                <option value="6" {{$deliveryDay['day'] === '6' ? 'selected' : ''}}>Friday</option>
                                                                                <option value="7" {{$deliveryDay['day'] === '7' ? 'selected' : ''}}>Saturday</option>
                                                                                <option value="1" {{$deliveryDay['day'] === '1' ? 'selected' : ''}}>Sunday</option>
                                                                            </select>
                                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => "delivery.$key.days_available.$d.day", 'isAjax' => true])
                                                                        </div>
                                                                        <div class="col-md-2 form-group mt-auto">
                                                                            <button class="btn btn-danger delivery-day-delete">
                                                                                <i class="fa fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="times">
                                                                        @if(isset($deliveryDay['times']) && !empty($deliveryDay['times']))
                                                                            @foreach($deliveryDay['times'] as $keyT => $time)
                                                                                <div class="row time_block" data-number="{{$keyT}}">
                                                                                    <div class="col-md-5 form-group">
                                                                                        <input type="text" class="form-control since-input time_picker"
                                                                                               name="delivery[{{$key}}][days_available][{{$d}}][times][{{$keyT}}][since]"
                                                                                               placeholder="0:00 PM"
                                                                                               value="{{$time['since']}}"
                                                                                               required>
                                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => "delivery.$key.days_available.$d.times.$keyT.since", 'isAjax' => true])
                                                                                    </div>
                                                                                    <div class="col-md-5 form-group">
                                                                                        <input type="text" class="form-control until-input time_picker"
                                                                                               name="delivery[{{$key}}][days_available][{{$d}}][times][{{$keyT}}][until]"
                                                                                               placeholder="0:00 PM"
                                                                                               value="{{$time['until']}}"
                                                                                               required>
                                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => "delivery.$key.days_available.$d.times.$keyT.until", 'isAjax' => true])
                                                                                    </div>
                                                                                    <div class="col-md-2 form-group">
                                                                                        <button class="btn btn-danger delete_time_block" data-id="{{$keyT}}">
                                                                                            <i class="fa fa-trash-alt"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <button class="btn btn-sm btn-primary add_time_button">
                                                                        <i class="fa fa-plus"></i> Add new timeframe
                                                                    </button>
                                                                    <button class="btn btn-sm btn-green add_delivery_day_button" style="{{$d === array_key_last($orderDay['days_available']) ? '' : 'display : none;'}}">
                                                                        <i class="fa fa-plus"></i> Delivery day
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="pickup">
                                            <div class="row mt-5">
                                                <h2 style="margin: 0;">Pickup Decatur</h2>
                                                <a href="" class="btn btn-green add_new_day_pickup ml-2">Add New Day</a>
                                            </div>
                                            @if(empty($pickupTimes))
                                                <div class="line" data-line="1">
                                                    <div class="row">
                                                        <div class="col-md-5 form-group">
                                                            <label>Order Day</label>
                                                            <select name="pickup[1][day]" class="form-control day-select" required>
                                                                <option value="" selected disabled>Select day</option>
                                                                <option value="1">Monday</option>
                                                                <option value="2">Tuesday</option>
                                                                <option value="3">Wednesday</option>
                                                                <option value="4">Thursday</option>
                                                                <option value="5">Friday</option>
                                                                <option value="6">Saturday</option>
                                                                <option value="7">Sunday</option>
                                                            </select>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickup.1.day', 'isAjax' => true])
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Delivery Deadline</label>
                                                            <input type="time" class="form-control time-input"
                                                                   name="pickup[1][time]"
                                                                   required>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickup.1.time', 'isAjax' => true])
                                                        </div>
                                                        <div class="col-md-2 form-group mt-auto">
                                                            <button class="btn btn-danger remove-day-pickup">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="timeframes" style="">
                                                        <div class="day_time" data-day-id="1">
                                                            <div class="row">
                                                                <div class="col-md-10 form-group">
                                                                    <label>Delivery Day</label>
                                                                    <select name="pickup[1][days_available][1][day]" class="form-control delivery_day" required>
                                                                        <option value="" selected disabled>Select day</option>
                                                                        <option value="2">Monday</option>
                                                                        <option value="3">Tuesday</option>
                                                                        <option value="4">Wednesday</option>
                                                                        <option value="5">Thursday</option>
                                                                        <option value="6">Friday</option>
                                                                        <option value="7">Saturday</option>
                                                                        <option value="1">Sunday</option>
                                                                    </select>
                                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickup.1.days_available.1.day', 'isAjax' => true])
                                                                </div>
                                                                <div class="col-md-2 form-group mt-auto">
                                                                    <button class="btn btn-danger pickup-day-delete">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="times">
                                                                <div class="row time_block" data-number="1">
                                                                    <div class="col-md-5 form-group">
                                                                        <input type="text" class="form-control since-input time_picker"
                                                                               name="pickup[1][days_available][1][times][1][since]"
                                                                               placeholder="0:00 PM"
                                                                               value=""
                                                                               required>
                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickup.1.days_available.1.times.1.since', 'isAjax' => true])
                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <input type="text" class="form-control until-input time_picker"
                                                                               name="pickup[1][days_available][1][times][1][until]"
                                                                               placeholder="0:00 PM"
                                                                               value=""
                                                                               required>
                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickup.1.days_available.1.times.1.until', 'isAjax' => true])
                                                                    </div>
                                                                    <div class="col-md-2 form-group">
                                                                        <button class="btn btn-danger delete_time_block" data-id="1">
                                                                            <i class="fa fa-trash-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-sm btn-primary add_time_button_pickup">
                                                                <i class="fa fa-plus"></i> Add new timeframe
                                                            </button>
                                                            <button class="btn btn-sm btn-green add_pickup_day_button">
                                                                <i class="fa fa-plus"></i> Delivery day
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            @else
                                                @foreach($pickupTimes as $key => $orderDay)
                                                    <div class="line" data-line="{{$key}}">
                                                        <div class="row">
                                                            <div class="col-md-5 form-group">
                                                                <label>Order Day</label>
                                                                <select name="pickup[{{$key}}][day]" class="form-control day-select" required>
                                                                    <option value="" selected disabled>Select day</option>
                                                                    <option value="1" {{$orderDay['day'] === '1' ? 'selected' : ''}}>Monday</option>
                                                                    <option value="2" {{$orderDay['day'] === '2' ? 'selected' : ''}}>Tuesday</option>
                                                                    <option value="3" {{$orderDay['day'] === '3' ? 'selected' : ''}}>Wednesday</option>
                                                                    <option value="4" {{$orderDay['day'] === '4' ? 'selected' : ''}}>Thursday</option>
                                                                    <option value="5" {{$orderDay['day'] === '5' ? 'selected' : ''}}>Friday</option>
                                                                    <option value="6" {{$orderDay['day'] === '6' ? 'selected' : ''}}>Saturday</option>
                                                                    <option value="7" {{$orderDay['day'] === '7' ? 'selected' : ''}}>Sunday</option>
                                                                </select>
                                                                @include('backend.layouts.partials.alerts.input-error', ['name' => "pickup.$key.day", 'isAjax' => true])
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <label for="">Delivery Deadline</label>
                                                                <input type="time" class="form-control time-input"
                                                                       name="pickup[{{$key}}][time]" value="{{$orderDay['time']}}"
                                                                       required>
                                                                @include('backend.layouts.partials.alerts.input-error', ['name' => "pickup.$key.time", 'isAjax' => true])
                                                            </div>
                                                            <div class="col-md-2 form-group mt-auto">
                                                                <button class="btn btn-danger remove-day-pickup">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="timeframes" style="">
                                                            @foreach($orderDay['days_available'] as $d => $pickupDay)
                                                                <div class="day_time" data-day-id="{{$d}}">
                                                                    <div class="row">
                                                                        <div class="col-md-10 form-group">
                                                                            <label>Delivery Day</label>
                                                                            <select name="pickup[{{$key}}][days_available][{{$d}}][day]" class="form-control delivery_day" required>
                                                                                <option value="" selected disabled>Select day</option>
                                                                                <option value="2" {{$pickupDay['day'] === '2' ? 'selected' : ''}}>Monday</option>
                                                                                <option value="3" {{$pickupDay['day'] === '3' ? 'selected' : ''}}>Tuesday</option>
                                                                                <option value="4" {{$pickupDay['day'] === '4' ? 'selected' : ''}}>Wednesday</option>
                                                                                <option value="5" {{$pickupDay['day'] === '5' ? 'selected' : ''}}>Thursday</option>
                                                                                <option value="6" {{$pickupDay['day'] === '6' ? 'selected' : ''}}>Friday</option>
                                                                                <option value="7" {{$pickupDay['day'] === '7' ? 'selected' : ''}}>Saturday</option>
                                                                                <option value="1" {{$pickupDay['day'] === '1' ? 'selected' : ''}}>Sunday</option>
                                                                            </select>
                                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => "pickup.$key.days_available.$d.day", 'isAjax' => true])
                                                                        </div>
                                                                        <div class="col-md-2 form-group mt-auto">
                                                                            <button class="btn btn-danger pickup-day-delete">
                                                                                <i class="fa fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="times">
                                                                        @if(isset($pickupDay['times']) && !empty($pickupDay['times']))
                                                                            @foreach($pickupDay['times'] as $keyT => $time)
                                                                                <div class="row time_block" data-number="{{$keyT}}">
                                                                                    <div class="col-md-5 form-group">
                                                                                        <input type="text" class="form-control since-input time_picker"
                                                                                               name="pickup[{{$key}}][days_available][{{$d}}][times][{{$keyT}}][since]"
                                                                                               placeholder="0:00 PM"
                                                                                               value="{{$time['since']}}"
                                                                                               required>
                                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => "pickup.$key.days_available.$d.times.$keyT.since", 'isAjax' => true])
                                                                                    </div>
                                                                                    <div class="col-md-5 form-group">
                                                                                        <input type="text" class="form-control until-input time_picker"
                                                                                               name="pickup[{{$key}}][days_available][{{$d}}][times][{{$keyT}}][until]"
                                                                                               placeholder="0:00 PM"
                                                                                               value="{{$time['until']}}"
                                                                                               required>
                                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => "pickup.$key.days_available.$d.times.$keyT.until", 'isAjax' => true])
                                                                                    </div>
                                                                                    <div class="col-md-2 form-group">
                                                                                        <button class="btn btn-danger delete_time_block" data-id="{{$keyT}}">
                                                                                            <i class="fa fa-trash-alt"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <button class="btn btn-sm btn-primary add_time_button_pickup">
                                                                        <i class="fa fa-plus"></i> Add new timeframe
                                                                    </button>
                                                                    <button class="btn btn-sm btn-green add_pickup_day_button" style="{{$d === array_key_last($orderDay['days_available']) ? '' : 'display : none;'}}">
                                                                        <i class="fa fa-plus"></i> Delivery day
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="pickupB">
                                            <div class="row mt-5">
                                                <h2 style="margin: 0;">Pickup Brookhaven</h2>
                                                <a href="" class="btn btn-green add_new_day_pickupB ml-2">Add New Day</a>
                                            </div>
                                            @if(empty($pickupTimesB))
                                                <div class="line" data-line="1">
                                                    <div class="row">
                                                        <div class="col-md-5 form-group">
                                                            <label>Order Day</label>
                                                            <select name="pickupB[1][day]" class="form-control day-select" required>
                                                                <option value="" selected disabled>Select day</option>
                                                                <option value="1">Monday</option>
                                                                <option value="2">Tuesday</option>
                                                                <option value="3">Wednesday</option>
                                                                <option value="4">Thursday</option>
                                                                <option value="5">Friday</option>
                                                                <option value="6">Saturday</option>
                                                                <option value="7">Sunday</option>
                                                            </select>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickupB.1.day', 'isAjax' => true])
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Delivery Deadline</label>
                                                            <input type="time" class="form-control time-input"
                                                                   name="pickupB[1][time]"
                                                                   required>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickupB.1.time', 'isAjax' => true])
                                                        </div>
                                                        <div class="col-md-2 form-group mt-auto">
                                                            <button class="btn btn-danger remove-day-pickupB">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="timeframes" style="">
                                                        <div class="day_time" data-day-id="1">
                                                            <div class="row">
                                                                <div class="col-md-10 form-group">
                                                                    <label>Delivery Day</label>
                                                                    <select name="pickupB[1][days_available][1][day]" class="form-control delivery_day" required>
                                                                        <option value="" selected disabled>Select day</option>
                                                                        <option value="2">Monday</option>
                                                                        <option value="3">Tuesday</option>
                                                                        <option value="4">Wednesday</option>
                                                                        <option value="5">Thursday</option>
                                                                        <option value="6">Friday</option>
                                                                        <option value="7">Saturday</option>
                                                                        <option value="1">Sunday</option>
                                                                    </select>
                                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickupB.1.days_available.1.day', 'isAjax' => true])
                                                                </div>
                                                                <div class="col-md-2 form-group mt-auto">
                                                                    <button class="btn btn-danger pickupB-day-delete">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="times">
                                                                <div class="row time_block" data-number="1">
                                                                    <div class="col-md-5 form-group">
                                                                        <input type="text" class="form-control since-input time_picker"
                                                                               name="pickupB[1][days_available][1][times][1][since]"
                                                                               placeholder="0:00 PM"
                                                                               value=""
                                                                               required>
                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickupB.1.days_available.1.times.1.since', 'isAjax' => true])
                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <input type="text" class="form-control until-input time_picker"
                                                                               name="pickupB[1][days_available][1][times][1][until]"
                                                                               placeholder="0:00 PM"
                                                                               value=""
                                                                               required>
                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'pickupB.1.days_available.1.times.1.until', 'isAjax' => true])
                                                                    </div>
                                                                    <div class="col-md-2 form-group">
                                                                        <button class="btn btn-danger delete_time_block" data-id="1">
                                                                            <i class="fa fa-trash-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-sm btn-primary add_time_button_pickupB">
                                                                <i class="fa fa-plus"></i> Add new timeframe
                                                            </button>
                                                            <button class="btn btn-sm btn-green add_pickupB_day_button">
                                                                <i class="fa fa-plus"></i> Delivery day
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            @else
                                                @foreach($pickupTimesB as $key => $orderDay)
                                                    <div class="line" data-line="{{$key}}">
                                                        <div class="row">
                                                            <div class="col-md-5 form-group">
                                                                <label>Order Day</label>
                                                                <select name="pickupB[{{$key}}][day]" class="form-control day-select" required>
                                                                    <option value="" selected disabled>Select day</option>
                                                                    <option value="1" {{$orderDay['day'] === '1' ? 'selected' : ''}}>Monday</option>
                                                                    <option value="2" {{$orderDay['day'] === '2' ? 'selected' : ''}}>Tuesday</option>
                                                                    <option value="3" {{$orderDay['day'] === '3' ? 'selected' : ''}}>Wednesday</option>
                                                                    <option value="4" {{$orderDay['day'] === '4' ? 'selected' : ''}}>Thursday</option>
                                                                    <option value="5" {{$orderDay['day'] === '5' ? 'selected' : ''}}>Friday</option>
                                                                    <option value="6" {{$orderDay['day'] === '6' ? 'selected' : ''}}>Saturday</option>
                                                                    <option value="7" {{$orderDay['day'] === '7' ? 'selected' : ''}}>Sunday</option>
                                                                </select>
                                                                @include('backend.layouts.partials.alerts.input-error', ['name' => "pickupB.$key.day", 'isAjax' => true])
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <label for="">Delivery Deadline</label>
                                                                <input type="time" class="form-control time-input"
                                                                       name="pickupB[{{$key}}][time]" value="{{$orderDay['time']}}"
                                                                       required>
                                                                @include('backend.layouts.partials.alerts.input-error', ['name' => "pickupB.$key.time", 'isAjax' => true])
                                                            </div>
                                                            <div class="col-md-2 form-group mt-auto">
                                                                <button class="btn btn-danger remove-day-pickupB">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="timeframes" style="">
                                                            @foreach($orderDay['days_available'] as $d => $pickupBDay)
                                                                <div class="day_time" data-day-id="{{$d}}">
                                                                    <div class="row">
                                                                        <div class="col-md-10 form-group">
                                                                            <label>Delivery Day</label>
                                                                            <select name="pickupB[{{$key}}][days_available][{{$d}}][day]" class="form-control delivery_day" required>
                                                                                <option value="" selected disabled>Select day</option>
                                                                                <option value="2" {{$pickupBDay['day'] === '2' ? 'selected' : ''}}>Monday</option>
                                                                                <option value="3" {{$pickupBDay['day'] === '3' ? 'selected' : ''}}>Tuesday</option>
                                                                                <option value="4" {{$pickupBDay['day'] === '4' ? 'selected' : ''}}>Wednesday</option>
                                                                                <option value="5" {{$pickupBDay['day'] === '5' ? 'selected' : ''}}>Thursday</option>
                                                                                <option value="6" {{$pickupBDay['day'] === '6' ? 'selected' : ''}}>Friday</option>
                                                                                <option value="7" {{$pickupBDay['day'] === '7' ? 'selected' : ''}}>Saturday</option>
                                                                                <option value="1" {{$pickupBDay['day'] === '1' ? 'selected' : ''}}>Sunday</option>
                                                                            </select>
                                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => "pickupB.$key.days_available.$d.day", 'isAjax' => true])
                                                                        </div>
                                                                        <div class="col-md-2 form-group mt-auto">
                                                                            <button class="btn btn-danger pickupB-day-delete">
                                                                                <i class="fa fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="times">
                                                                        @if(isset($pickupBDay['times']) && !empty($pickupBDay['times']))
                                                                            @foreach($pickupBDay['times'] as $keyT => $time)
                                                                                <div class="row time_block" data-number="{{$keyT}}">
                                                                                    <div class="col-md-5 form-group">
                                                                                        <input type="text" class="form-control since-input time_picker"
                                                                                               name="pickupB[{{$key}}][days_available][{{$d}}][times][{{$keyT}}][since]"
                                                                                               placeholder="0:00 PM"
                                                                                               value="{{$time['since']}}"
                                                                                               required>
                                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => "pickupB.$key.days_available.$d.times.$keyT.since", 'isAjax' => true])
                                                                                    </div>
                                                                                    <div class="col-md-5 form-group">
                                                                                        <input type="text" class="form-control until-input time_picker"
                                                                                               name="pickupB[{{$key}}][days_available][{{$d}}][times][{{$keyT}}][until]"
                                                                                               placeholder="0:00 PM"
                                                                                               value="{{$time['until']}}"
                                                                                               required>
                                                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => "pickupB.$key.days_available.$d.times.$keyT.until", 'isAjax' => true])
                                                                                    </div>
                                                                                    <div class="col-md-2 form-group">
                                                                                        <button class="btn btn-danger delete_time_block" data-id="{{$keyT}}">
                                                                                            <i class="fa fa-trash-alt"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <button class="btn btn-sm btn-primary add_time_button_pickupB">
                                                                        <i class="fa fa-plus"></i> Add new timeframe
                                                                    </button>
                                                                    <button class="btn btn-sm btn-green add_pickupB_day_button" style="{{$d === array_key_last($orderDay['days_available']) ? '' : 'display : none;'}}">
                                                                        <i class="fa fa-plus"></i> Delivery day
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/backend/js/time-settings.js')}}"></script>
@endpush--}}
@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.settings.delivery-time') }}
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('backend.layouts.partials.alerts.flash-messages')

                    <form action="{{ route('backend.settings.delivery-time.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-10 form-group">
                                                <label for="support-email">Delivery timeframe</label>
                                            </div>
                                        </div>
                                        <div class="times">
                                            @forelse($deliveryTime['times'] as $item)
                                                <div class="row time_block" data-number="{{ $loop->index }}">
                                                    <div class="col-md-5 form-group">
                                                        <input type="text" class="form-control since-input time_picker"
                                                               name="delivery_time[{{ $loop->index }}][since]"
                                                               placeholder="0:00 PM"
                                                               value="{{ old('delivery_time' . $loop->index . 'since', $item['since'] ?? '') }}"
                                                               required>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_time'.$loop->index.'since'])
                                                    </div>
                                                    <div class="col-md-5 form-group">
                                                        <input type="text" class="form-control until-input time_picker"
                                                               name="delivery_time[{{ $loop->index }}][until]"
                                                               placeholder="0:00 PM"
                                                               value="{{ old('delivery_time' . $loop->index . 'until', $item['until'] ?? '') }}"
                                                               required>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_time'.$loop->index.'until'])
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <button class="btn btn-danger delete_time_block" data-id="{{ $loop->index }}">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="row time_block" data-number="1">
                                                    <div class="col-md-5 form-group">
                                                        <input type="text" class="form-control since-input time_picker"
                                                               name="delivery_time[1][since]"
                                                               placeholder="0:00 PM"
                                                               value=""
                                                               required>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_time.1.since'])
                                                    </div>
                                                    <div class="col-md-5 form-group">
                                                        <input type="text" class="form-control until-input time_picker"
                                                               name="delivery_time[1][until]"
                                                               placeholder="0:00 PM"
                                                               value=""
                                                               required>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_time.1.until'])
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <button class="btn btn-danger delete_time_block" data-id="1">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>

                                    <button class="btn btn-sm btn-primary add_time_button">
                                        <i class="fa fa-plus"></i> Add new timeframe
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        refresh();
        $(document).on('click', '.delete_time_block', function (e) {
            e.preventDefault();
            if ($('.time_block').length > 1){
                $(this).closest('.time_block').remove();
            }
            else{
                swal.fire('Warning.', 'You have to have at least one timeframe set up!', 'warning');
            }
        });

        $('.add_time_button').click(function (e) {
            e.preventDefault();
            let $number = $(document).find('.time_block:last').data('number') + 1;

            $('.time_block:last').clone()
                .attr('data-number', $number)
                .find('input').val('').end()
                .find('.since-input').attr('name', 'delivery_time[' + $number + '][since]').end()
                .find('.until-input').attr('name', 'delivery_time[' + $number + '][until]').end()
                .find('.delete_time_block').attr('data-id', $number).end()
                .appendTo('.times:last');
            refresh();
        });

        function refresh() {
            $(".time_picker").datetimepicker({
                format: "LT",
                icons: {
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down"
                }
            });
        }

    </script>
@endpush
