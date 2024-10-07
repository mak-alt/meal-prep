@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.addons.create') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.addons.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @include('backend.layouts.partials.alerts.flash-messages')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="{{ old('name') }}" placeholder="Name..." required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="required-meals-amount">Required meals amount</label>
                                                <input type="number" class="form-control" id="required-meals-amount"
                                                       name="required_minimum_meals_amount"
                                                       value="{{ old('required_minimum_meals_amount') }}"
                                                       placeholder="Required meals amount..." min="1"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'required_minimum_meals_amount'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="categories">Menu Categories</label>
                                                <select class="select2" autocomplete="off" name="category_ids[]"
                                                        id="categories" data-placeholder="Menu Categories..."
                                                        style="width: 100%;" multiple required>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'category_ids'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="meals">Meals</label>
                                            <div class="form-group_inner">
                                                <select name="meal_ids[]" class="select2 form-control"
                                                        id="meals" data-placeholder="Meals..."
                                                        data-listener="{{ route('backend.addons.render-selected-meals-table-items') }}"
                                                        multiple>
                                                    @foreach($meals as $meal)
                                                        <option
                                                            value="{{ $meal->id }}" {{ in_array($meal->id, old('meal_ids', [])) ? 'selected' : '' }}>
                                                            {{ $meal->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <a href="{{ route('backend.meals.create') }}"
                                                   class="btn btn-block btn-primary">
                                                    Add
                                                </a>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'meal_ids'])
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group table-responsive-lg">
                                                <table class="table table-striped table-sm table-bordered"
                                                       id="meals-table">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                        <th>Points</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @include('backend.addons.partials.meals-table-items', ['meals' => $addonMeals])
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/addons.js') }}"></script>
@endpush
