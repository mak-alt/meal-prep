@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.settings.index') }}

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('backend.layouts.partials.alerts.flash-messages')

                    <form action="{{ route('backend.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <h4>SEO</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="seo-title">Title</label>
                                            <input type="text" class="form-control" id="seo-title" name="seo_title"
                                                   placeholder="Title..."
                                                   value="{{ old('seo_title', $seoData['title'] ?? '') }}" required>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'seo_title'])
                                        </div>
                                        <div class="form-group">
                                            <label for="seo-description">Description</label>
                                            <textarea name="seo_description" id="seo-description" class="form-control"
                                                      style="text-align: left; min-height: 100px;"
                                                      placeholder="Description..."
                                                      required>{{ old('seo_description', $seoData['description'] ?? '') }}</textarea>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'seo_description'])
                                        </div>
                                        <div class="form-group">
                                            <label for="seo-keywords">Keywords</label>
                                            <textarea name="seo_keywords" id="seo-keywords" class="form-control"
                                                      style="text-align: left; min-height: 100px;"
                                                      placeholder="Keywords...">{{ old('seo_keywords', $seoData['keywords'] ?? '') }}</textarea>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'seo_keywords'])
                                        </div>
                                        <div class="form-group">
                                            <label for="thumb">Landing Main Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/x-png,image/gif,image/jpeg"
                                                           class="custom-file-input thumb" id="thumb" name="thumb">
                                                    <label class="custom-file-label thumb-label" for="thumb"></label>
                                                </div>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'thumb'])
                                        </div>
                                        <div class="form-group">
                                            <label for="thumb2">Newsletter Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/x-png,image/gif,image/jpeg"
                                                           class="custom-file-input thumb" id="thumb2" name="thumb2">
                                                    <label class="custom-file-label thumb-label" for="thumb2"></label>
                                                </div>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'thumb2'])
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <h4>Support Info</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="support-email">Site Email</label>
                                                <input type="email" class="form-control" id="support-email"
                                                       name="support_email"
                                                       placeholder="Email..."
                                                       value="{{ old('support_email', $supportData['email']) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'support_email'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="order-email">Email Order Confirmation</label>
                                                <input type="email" class="form-control" id="order-email"
                                                       name="order_email"
                                                       placeholder="Email..."
                                                       value="{{ old('order_email', $supportData['order_email']) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'order_email'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="support-phone-number">Phone number</label>
                                                <input type="text" class="form-control phone-number__mask"
                                                       id="support-phone-number" name="support_phone_number"
                                                       placeholder="(000) 000-0000"
                                                       value="{{ old('support_phone_number', $supportData['phone_number']) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'support_phone_number'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="support-location">Location</label>
                                                <input type="text" class="form-control address-input"
                                                       id="support-location" name="support_location"
                                                       placeholder="Location..."
                                                       autocomplete="off"
                                                       value="{{ old('support_location', $supportData['location']) }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'support_location'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <h4>Social Media URLs</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="facebook-url">Facebook</label>
                                                <input type="url" class="form-control" id="facebook-url"
                                                       name="facebook_url"
                                                       placeholder="Facebook URL..."
                                                       value="{{ old('facebook_url', $socialMediaData['facebook_url']) }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'facebook_url'])
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="twitter-url">Twitter</label>
                                                <input type="url" class="form-control" id="twitter-url"
                                                       name="twitter_url"
                                                       placeholder="Twitter URL..."
                                                       value="{{ old('twitter_url', $socialMediaData['twitter_url']) }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'twitter_url'])
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="instagram-url">Instagram</label>
                                                <input type="url" class="form-control" id="instagram-url"
                                                       name="instagram_url"
                                                       placeholder="Instagram URL..."
                                                       value="{{ old('instagram_url', $socialMediaData['instagram_url']) }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'instagram_url'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-12">
                                        <h4>PayPal credentials</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="paypal-mode">PayPal mode</label>
                                                <input type="text" class="form-control" id="paypal-mode"
                                                       name="payments_credentials[paypal_mode]"
                                                       placeholder="PayPal mode..."
                                                       value="{{ old('payments_credentials.paypal_mode', $paymentsCredentials['paypal_mode']) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.paypal_mode'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="paypal-client-id">PayPal client ID</label>
                                                <input type="text" class="form-control" id="paypal-client-id"
                                                       name="payments_credentials[paypal_client_id]"
                                                       placeholder="PayPal client ID..."
                                                       value="{{ old('payments_credentials.paypal_client_id', $paymentsCredentials['paypal_client_id']) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.paypal_client_id'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="paypal-client-secret">PayPal client secret</label>
                                                <input type="text" class="form-control" id="paypal-client-secret"
                                                       name="payments_credentials[paypal_client_secret]"
                                                       placeholder="PayPal client secret..."
                                                       value="{{ old('payments_credentials.paypal_client_secret', $paymentsCredentials['paypal_client_secret']) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.paypal_client_secret'])
                                            </div>
                                        </div>
                                        <br>
                                        {{--<div class="col-md-12">
                                            <h4>Payeezy credentials</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="payeezy-api">Payeezy Api Key</label>
                                                <input type="text" class="form-control" id="payeezy-api"
                                                       name="payments_credentials[payeezy_api]"
                                                       placeholder="Payeezy Api Key..."
                                                       value="{{ old('payments_credentials.payeezy_api', $paymentsCredentials['payeezy_api'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.payeezy_api'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="payeezy-api-secret">Payeezy Api Secret</label>
                                                <input type="text" class="form-control" id="payeezy-api-secret"
                                                       name="payments_credentials[payeezy_api_secret]"
                                                       placeholder="Payeezy Api Secret..."
                                                       value="{{ old('payments_credentials.payeezy_api_secret', $paymentsCredentials['payeezy_api_secret'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.payeezy_api_secret'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="payeezy-merchant-token">Payeezy Merchant Token</label>
                                                <input type="text" class="form-control" id="payeezy-merchant-token"
                                                       name="payments_credentials[payeezy_merchant_token]"
                                                       placeholder="Payeezy Merchant Token..."
                                                       value="{{ old('payments_credentials.payeezy_merchant_token', $paymentsCredentials['payeezy_merchant_token'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.payeezy_merchant_token'])
                                            </div>
                                        </div>--}}


                                        <div class="col-md-12">
                                            <h4>Authorize credentials</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="merchant_login_id_key">Merchant Login Id Key</label>
                                                <input type="text" class="form-control" id="merchant_login_id_key"
                                                       name="payments_credentials[merchant_login_id_key]"
                                                       placeholder="Merchant Login Id Key..."
                                                       value="{{ old('payments_credentials.merchant_login_id_key', $paymentsCredentials['merchant_login_id_key'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.merchant_login_id_key'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="merchant_transaction_key">Merchant Transaction Key</label>
                                                <input type="text" class="form-control" id="merchant_transaction_key"
                                                       name="payments_credentials[merchant_transaction_key]"
                                                       placeholder="Merchant Transaction Key..."
                                                       value="{{ old('payments_credentials.merchant_transaction_key', $paymentsCredentials['merchant_transaction_key'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'payments_credentials.merchant_transaction_key'])
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <br>
                                <div>
                                    <div class="col-md-12">
                                        <h4>Google Analytics</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="ga-snippet">ID</label>
                                                <textarea name="snippetID" id="ga-snippet" class="form-control"
                                                          style="text-align: left; min-height: 100px;"
                                                          placeholder="Google Analytics ID...">{{$googleAnalyticsID}}</textarea>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'snippetID'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <div class="col-md-12">
                                        <h4>Referral amounts</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="inviter">Inviter Amount</label>
                                                <input type="number" class="form-control" id="inviter"
                                                       name="amountInviterGets"
                                                       placeholder="Amount..."
                                                       value="{{ old('inviter', $inviter) }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'amountInviterGets'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="invitee">Invitee Amount</label>
                                                <input type="number" class="form-control" id="invitee"
                                                       name="amountInviteeGets"
                                                       placeholder="Amount..."
                                                       value="{{ old('invitee', $invitee) }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'amountInviteeGets'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <div class="col-md-12">
                                        <h4>Mailchimp credentials</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="stripe-key">API key</label>
                                                <input type="text" class="form-control"
                                                       name="mailchimp[api_key]"
                                                       placeholder="API key..."
                                                       value="{{ old('mailchimp.api_key', $mailchimpCredentials['api_key'] ?? '') }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'mailchimp.api_key'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="stripe-key">List ID (Audience ID)</label>
                                                <input type="text" class="form-control"
                                                       name="mailchimp[list_id]"
                                                       placeholder="List ID..."
                                                       value="{{ old('mailchimp.stripe_key', $mailchimpCredentials['list_id'] ?? '') }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'mailchimp.list_id'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <div class="col-md-12">
                                        <h4>Twillio credentials</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="stripe-key">Twillio SID</label>
                                                <input type="text" class="form-control"
                                                       name="twillio[sid]"
                                                       placeholder="SID..."
                                                       value="{{ old('twillio.sid', $twillioCredentials['sid'] ?? '') }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'twillio.sid'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="stripe-key">Twillio From</label>
                                                <input type="text" class="form-control"
                                                       name="twillio[from]"
                                                       placeholder="From..."
                                                       value="{{ old('twillio.api_key', $twillioCredentials['from'] ?? '') }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'twillio.from'])
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="stripe-key">Twillio Token</label>
                                                <input type="text" class="form-control"
                                                       name="twillio[token]"
                                                       placeholder="Token..."
                                                       value="{{ old('twillio.token', $twillioCredentials['token'] ?? '') }}">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'twillio.token'])
                                            </div>
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
    <script>
        $('.thumb').on('change', function (){
            if($(this).prop('files').length > 0){
                $(this).parent().find('.thumb-label').empty();
                $(this).parent().find('.thumb-label').append($(this).prop('files')[0].name);
            }
        });
    </script>
@endpush
