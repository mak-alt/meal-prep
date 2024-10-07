@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{--{{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.pages.edit', $page) }}--}}

        <section class="content">
            <div class="container-fluid">
                @include('backend.layouts.partials.alerts.flash-messages')
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.weekly-menu.store') }}" method="POST"
                                  enctype="multipart/form-data" id="update-page-form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Main information</h2>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Title..."
                                                       required>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                            @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'name'])
                                            <div class="form-group">
                                                <label for="seoTitle">SEO title</label>
                                                <input type="text" class="form-control" id="seoTitle" name="seo_title"
                                                       placeholder="SEO title...">
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'seo_title'])
                                            @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'seo_title'])
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="seoDescription">SEO description</label>
                                                <textarea name="seo_description" class="form-control"
                                                          placeholder="SEO description..."
                                                          id="seoDescription"
                                                          style="width: 100%; height: 125px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; color: #495057; padding: 10px;"></textarea>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'seo_description'])
                                            @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'seo_description'])
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="menus">Meals</label>
                                                <select class="select2" autocomplete="off" name="data[meals][]"
                                                        id="meals" data-placeholder="Meals..."
                                                        style="width: 100%;" multiple>
                                                    @foreach($all_meals ?? [] as $meal)
                                                        <option value="{{ $meal->id }}">
                                                            {{ $meal->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.meals'])
                                            </div>
                                            <div class="form-group">
                                                <label for="sides">Sides</label>
                                                <select class="select2" autocomplete="off" name="data[sides][]"
                                                        id="sides" data-placeholder="Sides..."
                                                        style="width: 100%;" multiple>
                                                    @foreach($all_sides ?? [] as $side)
                                                        <option value="{{ $side->id }}">
                                                            {{ $side->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.sides'])
                                            </div>
                                            <div class="form-group">
                                                <label for="other">Add-Ons/Breakfast/Snacks</label>
                                                <select class="select2" autocomplete="off" name="data[other][]"
                                                        id="other" data-placeholder="Other..."
                                                        style="width: 100%;" multiple>
                                                    @foreach($other ?? [] as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.other'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="status"
                                                           id="status">
                                                    <label class="custom-control-label" for="status">
                                                        Status (Active menu)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{route('backend.pages.edit', 4)}}" class="btn btn-gray">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
