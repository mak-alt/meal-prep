@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.categories.edit', $category) }}

        <section class="content">
            <div class="row mb30">
                <div class="col-12">
                    <form action="{{ route('backend.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                @include('backend.layouts.partials.alerts.flash-messages')
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="key">Key</label>
                                            <input type="text" name="key" class="form-control" id="key"
                                                   placeholder="Key..." value="{{ old('key', $category->key) }}"
                                                   disabled>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'key'])
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                   placeholder="Name..." value="{{ old('name', $category->name) }}"
                                                   required>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control" id="description"
                                                      placeholder="Description...">{{ old('description', $category->description) }}</textarea>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'description'])
                                        </div>
                                        <div class="form-group">
                                            <label for="thumb">Thumb</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/x-png,image/gif,image/jpeg"
                                                           class="custom-file-input" id="thumb" name="thumb[]" multiple>
                                                    <label class="custom-file-label thumb-label" for="thumb" id="thumbLabel">{{$label}}</label>
                                                </div>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'thumb'])
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
    <script src="{{asset('assets/backend/js/categories.js')}}"></script>
@endpush
