@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.settings.delivery') }}
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('backend.layouts.partials.alerts.flash-messages')

                    <form action="{{ route('backend.settings.delivery.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="support-email">WITHIN THE PERIMETER OF I-285</label>
                                                <input type="text" class="form-control"
                                                       name="delivery[within_i_285]"
                                                       placeholder="0"
                                                       value="{{ old('delivery.within_i_285', $delivery['within_i_285'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.within_i_285'])
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="support-phone-number">ADDRESSES OUTSIDE OF I-285</label>
                                                <input type="text" class="form-control"
                                                       name="delivery[outside_i_285]"
                                                       placeholder="15"
                                                       value="{{ old('delivery.outside_i_285', $delivery['outside_i_285'] ?? '') }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.outside_i_285'])
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Default Delivery Price</label>
                                                <input type="text" class="form-control"
                                                       name="delivery[default_price]" id="default"
                                                       placeholder="0"
                                                       value="{{ old('delivery.default_price', $delivery['default_price'] ?? 0) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.default_price'])
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                <label for="support-email">ZIP Code</label>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <label for="support-email">Price</label>
                                            </div>
                                        </div>
                                        <div class="zip_codes">
                                            @foreach($delivery['zip_codes'] as $key => $item)
                                                <div class="row zip_code_block" data-number="{{ $loop->index }}">
                                                    <div class="col-md-5 form-group">
                                                        <input type="number" class="form-control code-input"
                                                               name="delivery[zip_codes][{{ $loop->index }}][code]"
                                                               placeholder="0"
                                                               value="{{ old('delivery.zip_codes' . $loop->index . 'code', $item['code'] ?? '') }}"
                                                               required>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.zip_codes'.$loop->index.'code'])
                                                    </div>
                                                    <div class="col-md-5 form-group">
                                                        <input type="number" class="form-control price-input"
                                                               name="delivery[zip_codes][{{ $loop->index }}][price]"
                                                               placeholder="15"
                                                               value="{{ old('delivery.zip_codes' . $loop->index . 'price', $item['price'] ?? '') }}"
                                                               required>
                                                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'delivery.zip_codes'.$loop->index.'price'])
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <button class="btn btn-danger delete_zip_code" data-id="{{ $loop->index }}">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button class="btn btn-sm btn-primary add_zip_code_button">
                                        <i class="fa fa-plus"></i> Add new zip code
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
        let toChangeArray = [];
        let startValue = $('#default').val();
        $(document).on('click', '.delete_zip_code', function (e) {
            e.preventDefault();
            $(this).closest('.zip_code_block').remove();
        });

        $('.add_zip_code_button').click(function (e) {
            e.preventDefault();
            let $number = $(document).find('.zip_code_block:last').data('number') + 1;
            let value = $('#default').val();

            $('.zip_code_block:last').clone()
                .attr('data-number', $number)
                .find('input').val('').end()
                .find('.code-input').attr('name', 'delivery[zip_codes][' + $number + '][code]').end()
                .find('.price-input').attr('name', 'delivery[zip_codes][' + $number + '][price]').end()
                .find('.price-input').val(value).end()
                .find('.delete_zip_code').attr('data-id', $number).end()
                .appendTo('.zip_codes:last');
        });

        $('#default').on('change', function () {
            let value = $(this).val();

            if(toChangeArray.length > 0){
                $('.zip_code_block').each(function (index,item){
                    if(toChangeArray.includes($(item).data('number'))){
                        $(item).find('.price-input').val(value);
                    }
                });
            }
            else{
                $('.price-input').each(function (index,item) {
                    if ($(item).val() === startValue){
                        $(item).val(value);
                        toChangeArray.push($(item).parents('.zip_code_block').data('number'));
                    }
                });
            }
        });

    </script>
@endpush
