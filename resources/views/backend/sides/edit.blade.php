@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.sides.edit', $side) }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.sides.update', $side->id) }}" method="POST"
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
                                                       value="{{ old('name', $side->name) }}" placeholder="Name..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="order_id">Order ID</label>
                                                <input type="number" class="form-control" id="order_id" name="order_id"
                                                       value="{{ old('order_id', $side->order_id) }}" placeholder="Order ID..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'order_id'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="number" class="form-control" id="price" name="price"
                                                       value="{{ old('price', $side->price) }}" placeholder="Price..."
                                                       data-action="calculate-points"
                                                       data-listener="{{ route('backend.meals.calculate-points') }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'price'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="points">Points</label>
                                                <input type="number" class="form-control points__calculatable"
                                                       id="points" name="points"
                                                       value="{{ old('points', $side->points) }}"
                                                       placeholder="Points..."
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'points'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="thumb">Thumb</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" accept="image/x-png,image/gif,image/jpeg"
                                                               class="custom-file-input" id="thumb" name="thumb">{{-- --}}
                                                        <label class="custom-file-label thumb-label" for="thumb" id="thumbLabel"></label>
                                                    </div>
                                                </div>
                                                <div class="input_product_img_wrpr">
                                                    <img src="{{ asset($side->thumb) }}" class="img img-thumbnail"
                                                         alt="Meal photo">
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'thumb'])
                                            </div>
                                        </div>
                                        {{--<div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="categories">Categories</label>
                                                <select class="select2" autocomplete="off" name="category_ids[]"
                                                        id="categories" data-placeholder="Categories..."
                                                        style="width: 100%;" multiple required>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', $side->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'category_ids'])
                                            </div>
                                        </div>--}}
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="calories">Calories</label>
                                                <input type="number" name="calories" class="form-control" id="calories"
                                                       min="0" placeholder="Calories..."
                                                       value="{{ old('calories', $side->calories) }}"
                                                       required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'calories'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="fats">Fats</label>
                                                <input type="number" class="form-control" id="fats" name="fats"
                                                       placeholder="Fats..." value="{{ old('fats', $side->fats) }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'fats'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="carbs">Carbs</label>
                                                <input type="number" name="carbs" class="form-control" id="carbs"
                                                       placeholder="Carbs..." value="{{ old('carbs', $side->carbs) }}"
                                                       min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'carbs'])
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="proteins">Proteins</label>
                                                <input type="number" name="proteins" class="form-control" id="proteins"
                                                       placeholder="Proteins..."
                                                       value="{{ old('proteins', $side->proteins) }}" min="0" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'proteins'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="ingredients">Ingredients</label>
                                            <div class="form-group_inner">
                                                <select name="ingredient_ids[]" class="select2 form-control"
                                                        id="ingredients" data-placeholder="Ingredients..." multiple
                                                        required>
                                                    @foreach($ingredients as $ingredient)
                                                        <option
                                                            value="{{ $ingredient->id }}" {{ in_array($ingredient->id, old('ingredient_ids', $side->ingredients->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="textarea" name="description" id="description"
                                                          placeholder="Description...">{{ old('description', $side->description) }}</textarea>
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
                                                                value="{{ $tag }}" {{ in_array($tag, old('tags', $side->tags)) ? 'selected' : '' }}>
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
                                                           id="status" {{$side->status ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="status">
                                                        Status
                                                    </label>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/meals.js') }}"></script>
@endpush
