@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.users.create') }}

        <section class="content">
            <div class="row mb30">
                <div class="col-12">
                    <form action="{{ route('backend.users.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                @include('backend.layouts.partials.alerts.flash-messages')
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="first-name">First name</label>
                                            <input type="text" name="first_name" class="form-control" id="first-name"
                                                   placeholder="First name..." autocomplete="given-name"
                                                   value="{{ old('first_name') }}" required>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'first_name'])
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="last-name">Last name</label>
                                            <input type="text" name="last_name" class="form-control" id="last-name"
                                                   placeholder="Last name..." autocomplete="family-name"
                                                   value="{{ old('last_name') }}">
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'last_name'])
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name">Username</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                   placeholder="Username..." autocomplete="name"
                                                   value="{{ old('name') }}">
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                   placeholder="Email..."
                                                   value="{{ old('email') }}" autocomplete="email"
                                                   required>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'email'])
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                   placeholder="Password...">
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'password'])
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="role">Account Type</label>
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="" selected disabled>Role</option>
                                                @foreach(\App\Models\User::ROLES as $role)
                                                    <option
                                                        value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>
                                                        {{ ucfirst($role) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'role'])
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-4" id="profile-block"
                                         style="{{ empty($isCustomer) && old('role') !== \App\Models\User::ROLES['user'] ? 'display: none;' : '' }}">
                                        <h3>Profile</h3>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="display-name">Display name</label>
                                                    <input type="text" name="display_name" class="form-control"
                                                           id="display-name"
                                                           placeholder="Display name..." autocomplete="name"
                                                           value="{{ old('display_name') }}">
                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'display_name'])
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h4>Delivery address</h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="country">Country / Region</label>
                                                    <input type="text" name="delivery_country" class="form-control"
                                                           id="country"
                                                           placeholder="Country / Region..."
                                                           autocomplete="country-name"
                                                           value="{{ old('delivery_country', 'United States (US)') }}"
                                                            readonly>
                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_country'])
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label
                                                        id="state">State</label>
                                                    <input type="text" id="state" name="delivery_state"
                                                           class="form-control"
                                                           placeholder="State..."
                                                           autocomplete="address-level1"
                                                           value="{{ old('delivery_state') }}"
                                                           >
                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_state'])
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="city">Town / City</label>
                                                        <input type="text" id="city" name="delivery_city"
                                                               class="form-control"
                                                               placeholder="Town / City..."
                                                               autocomplete="address-level2"
                                                               value="{{ old('delivery_city') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_city'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="street-address">Street address</label>
                                                        <input type="text" id="street-address"
                                                               name="delivery_street_address"
                                                               class="form-control"
                                                               placeholder="Street address..."
                                                               value="{{ old('delivery_street_address') }}"
                                                               autocomplete="street-address"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_street_address'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="zip">ZIP</label>
                                                        <input type="text" id="zip" name="delivery_zip"
                                                               class="form-control"
                                                               placeholder="ZIP..."
                                                               autocomplete="postal-code"
                                                               value="{{ old('delivery_zip') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_zip'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="company">Company</label>
                                                        <input type="text" id="company" name="delivery_company_name"
                                                               class="form-control"
                                                               placeholder="Company..."
                                                               autocomplete="organization"
                                                               value="{{ old('delivery_company_name') }}">
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_company_name'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="first-name">First name</label>
                                                        <input type="text" id="first-name"
                                                               name="delivery_first_name" class="form-control"
                                                               placeholder="First name..."
                                                               autocomplete="birth-name"
                                                               value="{{ old('delivery_first_name') }}">
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_first_name'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="last-name">Last name</label>
                                                        <input type="text" id="last-name" name="delivery_last_name"
                                                               class="form-control"
                                                               placeholder="Last name..."
                                                               autocomplete="family-name"
                                                               value="{{ old('delivery_last_name') }}">
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery_last_name'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4>Billing address</h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-country">Country / Region</label>
                                                        <input type="text" name="billing_country"
                                                               class="form-control"
                                                               id="billing-country"
                                                               placeholder="Country / Region..."
                                                               autocomplete="country-name"
                                                               value="{{ old('billing_country', 'United States (US)') }}"
                                                                readonly>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_country'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-state">State</label>
                                                        <input type="text" id="billing-state"
                                                               name="billing_state" class="form-control"
                                                               placeholder="State..."
                                                               autocomplete="address-level1"
                                                               value="{{ old('billing_state') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_state'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-city">Town / City</label>
                                                        <input type="text" id="billing-city" name="billing_city"
                                                               class="form-control"
                                                               placeholder="Town / City..."
                                                               autocomplete="address-level2"
                                                               value="{{ old('billing_city') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_city'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-street-address">Street address</label>
                                                        <input type="text" id="billing-street-address"
                                                               name="billing_street_address"
                                                               class="form-control"
                                                               placeholder="Street address..."
                                                               value="{{ old('billing_street_address') }}"
                                                               autocomplete="street-address"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_street_address'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-zip">ZIP</label>
                                                        <input type="text" id="billing-zip" name="billing_zip"
                                                               class="form-control"
                                                               placeholder="ZIP..."
                                                               autocomplete="postal-code"
                                                               value="{{ old('billing_zip') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_zip'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-company">Company</label>
                                                        <input type="text" id="billing-company"
                                                               name="billing_company_name"
                                                               class="form-control"
                                                               placeholder="Company..."
                                                               autocomplete="organization"
                                                               value="{{ old('billing_company_name') }}">
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_company_name'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-phone-number">Phone number</label>
                                                        <input type="text" id="billing-phone-number"
                                                               name="billing_phone_number"
                                                               class="form-control"
                                                               placeholder="Phone number..."
                                                               autocomplete="tel-local"
                                                               value="{{ old('billing_phone_number') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_phone_number'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-email">Email address</label>
                                                        <input type="email" id="billing-email"
                                                               name="billing_email_address"
                                                               class="form-control"
                                                               placeholder="Email address..."
                                                               autocomplete="email"
                                                               value="{{ old('billing_email_address') }}"
                                                               >
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_email_address'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-first-name">First name</label>
                                                        <input type="text" id="billing-first-name"
                                                               name="billing_first_name"
                                                               class="form-control"
                                                               placeholder="First name..."
                                                               autocomplete="birth-name"
                                                               value="{{ old('billing_first_name') }}">
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_first_name'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="billing-last-name">Last name</label>
                                                        <input type="text" id="billing-last-name"
                                                               name="billing_last_name" class="form-control"
                                                               placeholder="Last name..."
                                                               autocomplete="family-name"
                                                               value="{{ old('billing_last_name') }}">
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'billing_last_name'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <div class="form-check d-inline-block">
                                    <input type="checkbox" name="update_profile"
                                           id="update-profile" {{ old('update_profile', empty($isCustomer) ? 'off' : 'on') === 'on' ? 'checked' : '' }} {{ empty($isCustomer) && old('update_profile') !== 'on' ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="update-profile">Update profile?</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/users.js') }}"></script>
@endpush
