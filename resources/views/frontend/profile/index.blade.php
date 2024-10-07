@extends('frontend.layouts.app')

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.content-header', ['title' => 'My profile'])
        <div class="content_main perfect_scroll">
            <div class="content_box">
                <div class="content_box_part">
                    <form action="{{ route('frontend.profile.update.personal-details') }}" method="POST"
                          id="personal-details-form">
                        @csrf
                        @method('PUT')
                        <h2 class="content_box_title">{{getInscriptions('profile-user-details',request()->path(),'Personal details')}}</h2>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_label" for="first-name">First name</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="first_name" class="input" id="first-name"
                                               autocomplete="given-name"
                                               value="{{ $user->first_name ?? '' }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'first_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_label" for="last-name">Last name</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="last_name" class="input" id="last-name"
                                               autocomplete="family-name"
                                               value="{{ $user->last_name ?? '' }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'last_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_label" for="name">Username</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="name" class="input" id="name"
                                               autocomplete="name"
                                               value="{{ $user->name ?? '' }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <button type="button" class="btn btn-green btn_save"
                                        id="submit-personal-details-form-button">
                                    {{getInscriptions('profile-save-user-details',request()->path(),'Save changes')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content_box_part">
                    <div class="box_part_wrapper">
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label">Email address</label>
                                <p class="fieldset_current current-email">{{ $user->email }}</p>
                                <a href="" class="btn btn_transparent btn_save"
                                   data-action="show-popup" data-popup-id="update-email-popup">
                                    Change email
                                </a>
                            </fieldset>
                        </div>
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label" for="password">Password</label>
                                <div class="input-wrapper view">
                                    <input type="password" class="input" id="password" value="••••••••••••" disabled>
                                </div>
                                <a href="" class="btn btn_transparent btn_save" data-action="show-popup"
                                   data-popup-id="update-password-popup">
                                    Change password
                                </a>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="content_box_part" id="add-addresses-block">
                    <div class="box_part_wrapper">
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label">Delivery address</label>
                                @empty(optional($user->profile)->delivery_country)
                                    <p class="delivery-address">You have not set up this type of address yet.</p>
                                @else
                                    <p class="delivery-address">
                                        {{ "{$user->profile->delivery_zip}, {$user->profile->delivery_country}, {$user->profile->delivery_state}, {$user->profile->delivery_city}, {$user->profile->delivery_street_address}, {$user->profile->delivery_address_opt}" }}
                                    </p>
                                @endif
                                <a href="" class="btn btn_transparent btn_save" data-action="add-delivery-address">
                                    {{ empty(optional($user->profile)->delivery_country) ? 'Add address' : 'Edit address' }}
                                </a>
                            </fieldset>
                        </div>
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label">Billing address</label>
                                @empty(optional($user->profile)->billing_country)
                                    <p class="billing-address">You have not set up this type of address yet.</p>
                                @else
                                    <p class="billing-address">
                                        {{ "{$user->profile->billing_zip}, {$user->profile->billing_country}, {$user->profile->billing_state}, {$user->profile->billing_city}, {$user->profile->billing_street_address}, {$user->profile->billing_address_opt}" }}
                                    </p>
                                @endif
                                <a href="" class="btn btn_transparent btn_save" data-action="add-billing-address">
                                    {{ empty(optional($user->profile)->billing_country) ? 'Add address' : 'Edit address' }}
                                </a>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="content_box_part" style="display: none" id="delivery-address-info">
                    <h3 class="fieldset_label mb30">Delivery address</h3>
                    <form action="{{ route('frontend.profile.update.delivery-address') }}" method="POST"
                          id="update-delivery-address-form">
                        @csrf
                        @method('PUT')
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="country">Country / Region</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="delivery_country" class="input" id="country"
                                               autocomplete="country-name"
                                               value="{{ optional($user->profile)->delivery_country ?? 'United States (US)' }}"
                                               required readonly>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_country'])
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="state">State<span>*</span></label>
                                    <div class="input-wrapper">
                                        <select class="input" name="delivery_state" required>
                                            <option selected disabled>Select a state</option>
                                            @foreach($states as $state)
                                                <option value="{{$state}}" {{optional($user->profile)->delivery_state === $state ? 'selected' : ''}}>{{$state}}</option>
                                            @endforeach
                                        </select>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_state'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="street-address">
                                        Street address<span>*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" id="street-address" name="delivery_street_address"
                                               class="input"
                                               value="{{ optional($user->profile)->delivery_street_address }}"
                                               autocomplete="street-address"
                                               required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_street_address'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="city">Town / City<span>*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" id="city" name="delivery_city" class="input"
                                               autocomplete="address-level2"
                                               value="{{ optional($user->profile)->delivery_city }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_city'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="street-address-opt">
                                        Apartment, suite, etc.
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="street-address-opt"
                                               name="delivery_address_opt" class="input"
                                               autocomplete="street-address-opt"
                                               value="{{ optional($user->profile)->delivery_address_opt }}"
                                               required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_address_opt'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="zip">ZIP<span>*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" id="zip" name="delivery_zip" class="input"
                                               autocomplete="postal-code"
                                               value="{{ optional($user->profile)->delivery_zip }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_zip'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="company">Company (optional)</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="company" name="delivery_company_name" class="input"
                                               autocomplete="organization"
                                               value="{{ optional($user->profile)->delivery_company_name }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_company_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="delivery-phone-number">
                                        Phone number<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="delivery-phone-number" name="delivery_phone_number"
                                               class="input phone-number__mask"
                                               autocomplete="tel-local"
                                               value="{{ optional($user->profile)->delivery_phone_number }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_phone_number'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item" id="delivery-first-name"
                                 style="{{ !empty(optional($user->profile)->delivery_first_name) ? '' : 'display: none;' }}">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="delivery-first-name">
                                        First name<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="delivery-first-name" name="delivery_first_name"
                                               class="input"
                                               autocomplete="given-name"
                                               value="{{ optional($user->profile)->delivery_first_name }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_first_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item" id="delivery-last-name"
                                 style="{{ !empty(optional($user->profile)->delivery_last_name) ? '' : 'display: none;' }}">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="delivery-last-name">
                                        Last name<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="delivery-last-name" name="delivery_last_name"
                                               class="input"
                                               autocomplete="family-name"
                                               value="{{ optional($user->profile)->delivery_last_name }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_last_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <div class="module_check_wrapper">
                                    <div class="module__check">
                                        <input type="checkbox"
                                               name="delivery_same_name_as_account_name"
                                               id="delivery-same-name-as-account-name" {{ !empty(optional($user->profile)->delivery_first_name) ? '' : 'checked' }}>
                                        <span class="check"></span>
                                        <label class="text" for="delivery-same-name-as-account-name">
                                            Use the same name as account name
                                        </label>
                                    </div>
                                    <div class="module__check">
                                        <input type="checkbox" name="delivery_use_address_as_billing_address"
                                               id="delivery-use-address-as-billing-address" checked>
                                        <span class="check"></span>
                                        <label class="text" for="delivery-use-address-as-billing-address">
                                            Use this address as my billing address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <button type="button"
                                        class="btn btn_save {{ $user->hasDefaultDeliveryAddressSetUp() ? 'btn-green' : 'btn_disabled' }}"
                                        data-action="save-delivery-address">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content_box_part" style="display: none" id="billing-address-info">
                    <h3 class="fieldset_label mb30">Billing address</h3>
                    <form action="{{ route('frontend.profile.update.billing-address') }}" method="POST"
                          id="update-billing-address-form">
                        @csrf
                        @method('PUT')
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-country">Country / Region</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="billing_country" class="input" id="billing-country"
                                               autocomplete="country-name"
                                               value="{{ optional($user->profile)->billing_country ?? 'United States (US)' }}"
                                               required readonly>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_country'])
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-state">State<span>*</span></label>
                                    <div class="input-wrapper">
                                        <select class="input" name="billing_state" id="billing-state" required>
                                            <option selected disabled>Select a state</option>
                                            @foreach($states as $state)
                                                <option value="{{$state}}" {{optional($user->profile)->billing_state === $state ? 'selected' : ''}}>{{$state}}</option>
                                            @endforeach
                                        </select>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_state'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-street-address">
                                        Street address<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-street-address" name="billing_street_address"
                                               class="input"
                                               value="{{ optional($user->profile)->billing_street_address }}"
                                               autocomplete="street-address"
                                               required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_street_address'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-city">
                                        Town / City<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-city" name="billing_city" class="input"
                                               autocomplete="address-level2"
                                               value="{{ optional($user->profile)->billing_city }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_city'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-address-opt">
                                        Apartment, suite, etc.
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-address-opt"
                                               name="billing_address_opt" class="input"
                                               autocomplete="billing-address-opt"
                                               value="{{ optional($user->profile)->billing_address_opt }}"
                                               required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_address_opt'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-zip">ZIP<span>*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-zip" name="billing_zip" class="input"
                                               autocomplete="postal-code"
                                               value="{{ optional($user->profile)->billing_zip }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_zip'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-company">
                                        Company (optional)
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-company" name="billing_company_name"
                                               class="input"
                                               autocomplete="organization"
                                               value="{{ optional($user->profile)->billing_company_name }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_company_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-phone-number">
                                        Phone number<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-phone-number" name="billing_phone_number"
                                               class="input phone-number__mask"
                                               autocomplete="tel-local"
                                               value="{{ optional($user->profile)->billing_phone_number }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_phone_number'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-email">
                                        Email address<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="email" id="billing-email" name="billing_email_address"
                                               class="input"
                                               autocomplete="email"
                                               value="{{ optional($user->profile)->billing_email_address ?? $user->email }}" required>
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_email_address'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item" id="billing-first-name"
                                 style="{{ !empty(optional($user->profile)->billing_first_name) ? '' : 'display: none;' }}">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-first-name">
                                        First name<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-first-name" name="billing_first_name"
                                               class="input"
                                               autocomplete="given-name"
                                               value="{{ optional($user->profile)->billing_first_name }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_first_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                            <div class="box_part_item" id="billing-last-name"
                                 style="{{ !empty(optional($user->profile)->billing_last_name) ? '' : 'display: none;' }}">
                                <fieldset class="fieldset">
                                    <label class="fieldset_sub_label" for="billing-last-name">
                                        Last name<span>*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="billing-last-name" name="billing_last_name" class="input"
                                               autocomplete="family-name"
                                               value="{{ optional($user->profile)->billing_last_name }}">
                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_last_name'])
                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <div class="module_check_wrapper">
                                    <div class="module__check">
                                        <input type="checkbox"
                                               name="billing_same_name_as_account_name"
                                               id="billing-same-name-as-account-name" {{ !empty(optional($user->profile)->billing_first_name) ? '' : 'checked' }}>
                                        <span class="check"></span>
                                        <label class="text" for="billing-same-name-as-account-name">
                                            Use the same name as account name
                                        </label>
                                    </div>
                                    <div class="module__check">
                                        <input type="checkbox" name="billing_use_address_as_delivery_address"
                                               id="billing-use-address-as-delivery-address" checked>
                                        <span class="check"></span>
                                        <label class="text" for="billing-use-address-as-delivery-address">
                                            Use this address as my delivery address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box_part_wrapper">
                            <div class="box_part_item">
                                <button type="button"
                                        class="btn btn_save {{ $user->hasDefaultBillingAddressSetUp() && !empty($user->profile->billing_email_address) ? 'btn-green' : 'btn_disabled' }}"
                                        data-action="save-billing-address">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--<div class="content_box_part">
                    <div class="box_part_wrapper">
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label">Payment information</label>
                                @if($user->paymentProfiles->isEmpty())
                                    <p class="no-payment-method">You haven't setup any payment methods yet.</p>
                                    <div id="payments-block"></div>
                                    <a href="" class="btn btn_transparent btn_save" data-action="show-popup"
                                       data-popup-id="add-credit-card-popup">
                                        Add payment
                                    </a>
                                @else
                                    @foreach($user->paymentProfiles->sortBy('created_at') as $paymentProfile)
                                        <div id="payments-block">
                                            @include('frontend.profile.partials.popups.payment-method-item', ['paymentProfile' => $paymentProfile, 'showLabel' => $loop->first])
                                        </div>
                                    @endforeach
                                    <p class="add-another-payment-method">Other payment method</p>
                                    <a href="" class="btn btn_transparent btn_save"
                                       data-action="show-popup"
                                       data-popup-id="add-credit-card-popup">
                                        Add another
                                    </a>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                </div>--}}
            </div>
            @include('frontend.layouts.partials.subscribe-left-aligned')
            @include('frontend.layouts.partials.app.footer')
        </div>
    </div>
@endsection

@section('mobile-popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true, 'fromFrontendResponse' => true])
    @endif
@endsection

@section('popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
    @endif
    @include('frontend.profile.partials.popups.update-email')
    @include('frontend.profile.partials.popups.update-email-verification')
    @include('frontend.profile.partials.popups.update-password')
    @include('frontend.profile.partials.popups.add-credit-card')
    @include('frontend.profile.partials.popups.delete-payment-method')
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/profile.js') }}"></script>
@endpush
