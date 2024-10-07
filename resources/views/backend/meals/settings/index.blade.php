@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.meals.settings.index') }}

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('backend.layouts.partials.alerts.flash-messages')

                    <form action="{{ route('backend.meals.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="col-md-12">
                                        <h4>
                                            Portion sizes
                                            <button type="button" class="btn btn-sm btn-primary"
                                                    data-action="add-portion-size"
                                                    data-listener="{{ route('backend.meals.settings.render-portion-size-table-item') }}">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                        </h4>
                                    </div>
                                    <div class="col-md-12 table-responsive-lg">
                                        <table class="table table-bordered table-striped"
                                               id="meals-portion-sizes-table">
                                            <thead>
                                            <tr>
                                                <th style="min-width: 100px;">Size (Oz)</th>
                                                <th>Addition to the total cost (%)</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($portionSizes as $portionSize)
                                                @include('backend.meals.settings.partials.portion-size-table-item', ['index' => $loop->index, 'withDeleteButton' => true])
                                            @empty
                                                @include('backend.meals.settings.partials.portion-size-table-item', ['index' => 0, 'portionSize' => ['size' => 5, 'percentage' => 0], 'disablePercentageEdition' => true])
                                            @endforelse
                                            </tbody>
                                        </table>
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
    <script src="{{ asset('assets/backend/js/meals-settings.js') }}"></script>
@endpush
