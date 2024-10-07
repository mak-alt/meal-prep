<div class="col-lg-12 block_page">
    <h4>Contacts block</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <label for="contacts-title">Title</label>
            <input type="text" class="form-control w-100" name="data[contact_info][title]" placeholder="Title..."
                   id="contacts-title"
                   value="{{ old('data.contact_info.title', $page->data['contact_info']['title']) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.contact_info.title'])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control address-input" id="address" name="data[contact_info][address]"
                   value="{{ old('data.contact_info.address', $page->data['contact_info']['address'] ?? (optional(\App\Models\Setting::key('support_location')->first())->data ?? '')) }}"
                   placeholder="Address..." required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.contact_info.address'])
        </div>
        <div class="col-md-6 form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control w-100" id="email" name="data[contact_info][email]"
                   placeholder="Email..."
                   value="{{ old('data.contact_info.email', $page->data['contact_info']['email'] ?? (optional(\App\Models\Setting::key('support_email')->first())->data ?? '')) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.contact_info.email'])
        </div>
        <div class="col-md-6 form-group">
            <label for="phone-number">Phone number</label>
            <input type="text" class="form-control w-100 phone-number__mask" id="phone-number"
                   name="data[contact_info][phone]"
                   placeholder="(000) 000-0000"
                   value="{{ old('data.contact_info.phone', $page->data['contact_info']['phone'] ?? (optional(\App\Models\Setting::key('support_phone_number')->first())->data ?? '')) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.contact_info.phone'])
        </div>
    </div>
</div>

<div class="col-lg-12 block_page">
    <h4>Delivery fees block</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <label for="delivery-title">Title</label>
            <input type="text" class="form-control w-100" name="data[delivery_fees][title]" placeholder="Title..."
                   id="delivery-title"
                   value="{{ old('data.delivery_fees.title', $page->data['delivery_fees']['title']) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.delivery_fees.title'])
        </div>
    </div>
    <div class="form-group">
        <label for="delivery-fee-coefficient">Coefficient delivery fees ($/mile)</label>
        <input type="number" step="0.01" class="form-control w-100" id="delivery-fee-coefficient"
               name="data[delivery_fees][coefficient]"
               placeholder="Coefficient delivery fees..."
               value="{{ old('data.delivery_fees.coefficient', $page->data['delivery_fees']['coefficient'] ?? '') }}"
               required>
        @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.delivery_fees.coefficient'])
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="data[delivery_fees][description]" class="form-control" id="description"
                          placeholder="Description..."
                          style="width: 100%; height: 125px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; color: #495057; padding: 10px;">{{ old('data.delivery_fees.description', $page->data['delivery_fees']['description']) }}</textarea>
                @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.delivery_fees.description'])
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="placeholder">Placeholder</label>
                <input type="text" class="form-control w-100" id="placeholder"
                       name="data[delivery_fees][placeholder]"
                       placeholder="Placeholder..."
                       value="{{ old('data.delivery_fees.placeholder', $page->data['delivery_fees']['placeholder']) }}"
                       required>
                @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.delivery_fees.placeholder'])
            </div>
            <div class="form-group">
                <label for="button">Button</label>
                <input type="text" class="form-control w-100" id="button" name="data[delivery_fees][button]"
                       placeholder="Button text..."
                       value="{{ old('data.delivery_fees.button', $page->data['delivery_fees']['button']) }}"
                       required>
                @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.delivery_fees.button'])
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 block_page">
    <h4>Delivery & Pickup timing block</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <label for="delivery-and-pickup-title">Title</label>
            <input type="text" class="form-control w-100" name="data[delivery_and_pickup_timing][title]"
                   id="delivery-and-pickup-title"
                   placeholder="Delivery & pickup timing..."
                   value="{{ old('data.delivery_and_pickup_timing.title', $page->data['delivery_and_pickup_timing']['title']) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.delivery_and_pickup_timing.title'])
        </div>
    </div>
    <div class="timings">
        @foreach($page->data['delivery_and_pickup_timing']['items'] ?? [] as $item)
            <div class="row add_timing_block" data-number="{{ $loop->index }}">
                <div class="form-group col-lg-5">
                    <label for="title_timing">Title</label>
                    <input type="text" class="form-control w-100" id="title_timing"
                           name="data[delivery_and_pickup_timing][items][{{ $loop->index }}][title]"
                           placeholder="Title..." required
                           value="{{ old("data.delivery_and_pickup_timing.items.$loop->index.title", $item['title'] ?? '') }}">
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.delivery_and_pickup_timing.items.$loop->index.title"])
                </div>
                <div class="form-group col-lg-5">
                    <label for="description_timing">Description</label>
                    <textarea name="data[delivery_and_pickup_timing][items][{{ $loop->index }}][description]"
                              id="description_timing" class="form-control"
                              placeholder="Description..."
                              style="width: 100%; height: 125px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; color: #495057; padding: 10px;">{{ old("data.delivery_and_pickup_timing.items.$loop->index.description", $item['description']) }}</textarea>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.delivery_and_pickup_timing.items.$loop->index.description"])
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="pickup-timing">Actions</label>
                        <button class="btn btn-sm btn-danger remove-timing" data-id="{{ $loop->index }}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="btn btn-sm btn-primary add_timing_button">
        <i class="fa fa-plus"></i> Add delivery & pickup timings
    </button>
</div>

<div class="col-lg-12 block_page">
    <h4>Pickup locations block</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <label for="pickup-title">Title</label>
            <input type="text" class="form-control w-100" name="data[pickup_locations][title]"
                   id="pickup-title"
                   placeholder="Title..."
                   value="{{ old('data.pickup_locations.title', $page->data['pickup_locations']['title'] ?? '') }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.pickup_locations.title'])
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <div class="form-group">
                <label for="pickup-description">Description</label>
                <textarea name="data[pickup_locations][description]" id="pickup-description"
                          placeholder="Description..." class="form-control"
                          style="width: 100%; height: 125px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; color: #495057; padding: 10px;">{{ old("data.pickup_locations.description", $page->data['pickup_locations']['description']) }}</textarea>
            </div>
            @include('backend.layouts.partials.alerts.input-error', ['name' => "data.pickup_locations.description"])
        </div>
    </div>
    <div class="addresses">
        @foreach($page->data['pickup_locations']['items'] ?? [] as $item)
            <div class="row add_address_block" data-number="{{ $loop->index }}">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control w-100 name-input" id="name"
                               name="data[pickup_locations][items][{{ $loop->index }}][name]"
                               placeholder="Name..."
                               value="{{ old("data.pickup_locations.items.$loop->index.name", $item['name'] ?? '') }}"
                               required>
                        @include('backend.layouts.partials.alerts.input-error', ['name' => "data.pickup_locations.items.$loop->index.name"])
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="pickup-address">Address</label>
                        <input type="text" class="form-control w-100 address-input" id="pickup-address"
                               name="data[pickup_locations][items][{{ $loop->index }}][address]"
                               placeholder="Address..."
                               value="{{ old("data.pickup_locations.items.$loop->index.address", $item['address'] ?? '') }}"
                               required>
                        @include('backend.layouts.partials.alerts.input-error', ['name' => "data.pickup_locations.items.$loop->index.address"])
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="pickup-address">Actions</label>
                        <button class="btn btn-sm btn-danger remove-address" data-id="{{ $loop->index }}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="btn btn-sm btn-primary add_address_button">
        <i class="fa fa-plus"></i> Add new address
    </button>
</div>

@push('js')
    <script src="{{ asset('assets/backend/js/delivery-and-pickup.js') }}"></script>
@endpush
