@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.pages.edit', $page) }}

        <section class="content">
            <div class="container-fluid">
                @include('backend.layouts.partials.alerts.flash-messages')
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.pages.update', $page->id) }}" method="POST"
                                  enctype="multipart/form-data" id="update-page-form">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Main information</h2>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Name..."
                                                       value="{{ old('name', $page->name) }}"
                                                       {{ $page->is_static ? 'disabled' : '' }} required>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                            @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'name'])
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="slug">URL</label>
                                                <input type="text" class="form-control" id="slug" name="slug"
                                                       placeholder="URL..."
                                                       value="{{ old('slug', $page->slug) }}"
                                                       {{ $page->is_static ? 'disabled' : '' }} required>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'slug'])
                                            @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'slug'])
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control" id="status"
                                                        {{ $page->is_static ? 'disabled' : '' }} required>
                                                    @foreach(\App\Models\Page::STATUSES as $pageStatus)
                                                        <option
                                                            value="{{ $pageStatus }}" {{ old('status', $page->status === $pageStatus ? 'selected' : '') }}>
                                                            {{ ucfirst($pageStatus) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'status'])
                                            @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'status'])
                                        </div>
                                        @if(trim($page->slug, '/') !== 'weekly-menu')
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title"
                                                           placeholder="Title..."
                                                           value="{{ old('title', $page->title) }}" required>
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'title'])
                                                @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'title'])
                                                <div class="form-group">
                                                    <label for="seoTitle">SEO title</label>
                                                    <input type="text" class="form-control" id="seoTitle" name="seo_title"
                                                           placeholder="SEO title..."
                                                           value="{{ old('seo_title', $page->seo_title) }}">
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
                                                              style="width: 100%; height: 125px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; color: #495057; padding: 10px;">{{ old('seo_description', $page->seo_description) }}</textarea>
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'seo_description'])
                                                @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'seo_description'])
                                            </div>
                                        @endif
                                        @if($page->is_static)
                                            <div class="col-md-12 mt-4">
                                                <h2>Page specific data</h2>
                                            </div>

                                            @switch(trim($page->slug, '/'))
                                                @case('partners-and-references')
                                                @include('backend.pages.partials.partners-and-references', ['page' => $page])
                                                @break

                                                @case('gallery-and-reviews')
                                                @include('backend.pages.partials.gallery-and-reviews', ['page' => $page])
                                                @break

                                                @case('delivery-and-pickup')
                                                @include('backend.pages.partials.delivery-and-pickup', ['page' => $page])
                                                @break

                                                @case('weekly-menu')
                                                @include('backend.pages.partials.weekly-menu', ['page' => $page])
                                                @break
                                            @endswitch
                                        @else
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="content">Content</label>
                                                    <textarea class="textarea" id="content" name="content"
                                                              placeholder="Content...">{{ old('content', $page->content) }}</textarea>
                                                </div>
                                            </div>
                                        @endif
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
        </section>
    </div>
@endsection
