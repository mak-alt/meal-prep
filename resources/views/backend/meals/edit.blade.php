@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.meals.edit', $meal) }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.meals.update', $meal->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    @include('backend.layouts.partials.alerts.flash-messages')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="{{ old('name', $meal->name) }}" placeholder="Name..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="order_id">Order ID</label>
                                                <input type="number" class="form-control" id="order_id" name="order_id"
                                                       value="{{ old('order_id', $meal->order_id) }}" placeholder="Order ID..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'order_id'])
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="price">Additional price</label>
                                                <input type="number" class="form-control" id="price" name="price"
                                                       value="{{ old('price', $meal->price) }}" placeholder="Price..."
                                                       data-action="calculate-points"
                                                       data-listener="{{ route('backend.meals.calculate-points') }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'price'])
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="points">Points</label>
                                                <input type="number" class="form-control points__calculatable"
                                                       id="points" name="points"
                                                       value="{{ old('points', $meal->points) }}"
                                                       placeholder="Points..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'points'])
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="side_count">Side Count</label>
                                                <input type="number" class="form-control"
                                                       id="side_count" name="side_count" min="0"
                                                       value="{{ old('side_count', $meal->side_count) }}" placeholder="Side count..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'side_count'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="thumb">Thumb</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" accept="image/x-png,image/gif,image/jpeg" id="thumb" name="thumb">
                                                    </div>
                                                </div>
                                                <div class="input_product_img_wrpr">
                                                    <img src="{{ asset($meal->thumb) }}" class="img img-thumbnail"
                                                         alt="Meal photo">
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'thumb'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="calories">Calories</label>
                                                <input type="number" name="calories" class="form-control" id="calories"
                                                       min="0" placeholder="Calories..."
                                                       value="{{ old('calories', $meal->calories) }}" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'calories'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="fats">Fats</label>
                                                <input type="number" class="form-control" id="fats" name="fats"
                                                       placeholder="Fats..." value="{{ old('fats', $meal->fats) }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'fats'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="carbs">Carbs</label>
                                                <input type="number" name="carbs" class="form-control" id="carbs"
                                                       placeholder="Carbs..." value="{{ old('carbs', $meal->carbs) }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'carbs'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="proteins">Proteins</label>
                                                <input type="number" name="proteins" class="form-control" id="proteins"
                                                       placeholder="Proteins..."
                                                       value="{{ old('proteins', $meal->proteins) }}" min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'proteins'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="ingredients">Ingredients</label>
                                            <div class="form-group_inner">
                                                <select name="ingredient_ids[]" class="select2 form-control"
                                                        id="ingredients" data-placeholder="Ingredients..." multiple
                                                        required>
                                                    @foreach($ingredients as $ingredient)
                                                        <option
                                                            value="{{ $ingredient->id }}" {{ in_array($ingredient->id, old('ingredient_ids', $meal->ingredients->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                            {{ $ingredient->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <a href="{{ route('backend.ingredients.create') }}"
                                                   class="btn btn-block btn-primary">
                                                    Add
                                                </a>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'ingredient_ids'])
                                        </div>
                                        <div class="col-lg-12" style="margin-top: 15px">
                                            <div class="form-group">
                                                <label for="sides">
                                                    Side meals
                                                    <span id="allSides" class="btn btn-block btn-primary" style="display: inline;"> Select All </span>
                                                </label>
                                                <div class="form-group_inner">
                                                    <select name="side_ids[]" class="select2 form-control"
                                                            id="sides" data-placeholder="Side meals..."
                                                            data-listener="{{ route('backend.meals.render-selected-sides-table-items') }}"
                                                            data-meal-id="{{ $meal->id }}"
                                                            multiple>
                                                        @foreach($sides as $side)
                                                            <option
                                                                value="{{ $side->id }}" {{ in_array($side->id, old('side_ids', $meal->sides->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                                {{ $side->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <a href="{{ route('backend.sides.create') }}"
                                                       class="btn btn-block btn-primary">
                                                        Add
                                                    </a>
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'side_ids'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group table-responsive-lg">
                                                <table class="table table-striped table-sm table-bordered"
                                                       id="sides-table">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                        <th>Points</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @include('backend.meals.partials.sides-table-items', ['sides' => $mealSides])
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="textarea" name="description" id="description"
                                                          placeholder="Description...">{{ old('description', $meal->description) }}</textarea>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'description'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="tags">Filter tags</label>
                                                <div class="form-group_inner">
                                                    <select name="tags[]" class="select2 form-control"
                                                            id="tags" data-placeholder="tags..."
                                                            multiple>
                                                        @foreach($tags as $tag)
                                                            <option
                                                                value="{{ $tag }}" {{ in_array($tag, old('tags', $meal->tags)) ? 'selected' : '' }}>
                                                                {{ $tag }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <a href="{{ route('backend.filter-tags.create') }}"
                                                       class="btn btn-block btn-primary">
                                                        Add
                                                    </a>
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'tags'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="status"
                                                           id="status" {{$meal->status ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="status">
                                                        Status
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
        let updateSides = '{{route('backend.sides-cat.get')}}';
        let removeSides = '{{route('backend.sides-cat.remove')}}';

    </script>
    <script src="{{ asset('assets/backend/js/meals.js') }}"></script>
@endpush