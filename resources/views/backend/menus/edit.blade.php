@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.menus.edit', $menu) }}
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.menus.update', $menu->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    @include('backend.layouts.partials.alerts.flash-messages')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                       value="{{ old('name', $menu->name) }}" placeholder="Name..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control" name="category_id" id="category" required>
                                                    <option selected disabled>Category</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'category_id'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="number" name="price" class="form-control" id="price"
                                                       value="{{ old('price', $menu->price) }}" placeholder="Price..."
                                                       data-action="calculate-points"
                                                       data-listener="{{ route('backend.menus.calculate-points') }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'price'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="points">Points</label>
                                                <input type="number" name="points"
                                                       class="form-control points__calculatable" id="points"
                                                       value="{{ old('points', $menu->points) }}"
                                                       placeholder="Points..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'points'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="calories">Calories</label>
                                                <input type="number" name="calories" class="form-control" id="calories"
                                                       placeholder="Calories..."
                                                       value="{{ old('calories', $menu->calories ?? 0) }}" min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'calories'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="fats">Fats</label>
                                                <input type="number" name="fats" class="form-control" id="fats"
                                                       placeholder="Fats..."
                                                       value="{{ old('fats', $menu->fats ?? 0) }}" min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'fats'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="carbs">Carbs</label>
                                                <input type="number" name="carbs" class="form-control" id="carbs"
                                                       placeholder="Carbs..."
                                                       value="{{ old('carbs', $menu->carbs ?? 0) }}" min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'carbs'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="proteins">Proteins</label>
                                                <input type="number" name="proteins" class="form-control" id="proteins"
                                                       placeholder="Proteins..."
                                                       value="{{ old('proteins', $menu->proteins ?? 0) }}" min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'proteins'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="meals">Meals</label>
                                            <div class="form-group_inner">
                                                <select name="meal_ids[]" class="select2 form-control" id="meals"
                                                        data-placeholder="Meals..."
                                                        data-listener="{{ route('backend.menus.render-selected-meal-table-items') }}"
                                                        multiple required>
                                                    @foreach($mealMenusArray as $meal)
                                                        <option value="{{ $meal->id }}" selected>
                                                            {{ $meal->name }}
                                                        </option>
                                                    @endforeach
                                                    @foreach($meals as $meal)
                                                        <option value="{{ $meal->id }}"
                                                            {{ in_array($meal->id, old('meal_ids', [])) ? 'selected' : '' }}>
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
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'meal_id'])
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group table-responsive-lg">
                                                <table class="table table-striped table-sm table-bordered edit_menu_table"
                                                       id="meals-table">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Sides</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="col-md-12">
                                                    @include('backend.menus.partials.meals-table-items', ['meals' => old('meal_side_ids') ? $menu->meals->merge($meals->whereIn('id', array_keys(old('meal_side_ids')))) : $mealMenusArray])
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="textarea" name="description" id="description"
                                                          placeholder="Description...">{{ old('description', $menu->description) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="status"
                                                           id="status" {{ $menu->status ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status">
                                                        Status (Active menu)
                                                    </label>
                                                </div>
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

@push('js')
    <script>
        let updateMeals = '{{route('backend.menus.meals.get')}}';
    </script>
    <script src="{{ asset('assets/backend/js/menus.js') }}"></script>
@endpush
