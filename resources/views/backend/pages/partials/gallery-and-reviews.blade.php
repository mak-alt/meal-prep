<div class="col-lg-12">
    <h4>Gallery</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <input type="text" class="form-control w-100" name="data[gallery][title]"
                   id="gallery" placeholder="Title..."
                   value="{{ old('data.gallery.title', $page->data['gallery']['title'] ?? '') }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.gallery.title'])
            <div class="mt-3">
                <input type="file" class="filepond" name="file" data-upload-path="pages/gallery" multiple>
                @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'data.gallery.items'])
                <div class="row">
                    @foreach(collect($page->data['gallery']['items'] ?? [])->pluck('image') as $galleryImage)
                        <div class="col-lg-3 col-md-4 mb-1 image__wrapper">
                            <img src="{{ asset($galleryImage) }}" class="img-thumbnail" alt="Gallery item photo">
                            <a href="" class="btn btn-sm btn-danger delete-file-inbox-icon"
                               data-path="{{ $galleryImage }}"
                               data-listener="{{ route('backend.pages.delete-file', $page->id) }}"
                               data-key="gallery"
                               data-action="delete-image">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <h4 class="mt-5">Reviews</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <input type="text" class="form-control w-100" name="data[reviews][title]"
                   id="gallery" placeholder="Title..."
                   value="{{ old('data.reviews.title', $page->data['reviews']['title'] ?? '') }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.reviews.title'])
            <div class="mt-3">
                <input type="file" class="filepond" name="file" data-upload-path="pages/reviews" multiple>
                @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'data.reviews.items'])
                <div class="row">
                    @foreach(collect($page->data['reviews']['items'] ?? [])->pluck('image') as $reviewImage)
                        <div class="col-lg-3 col-md-4 mb-1">
                            <img src="{{ asset($reviewImage) }}" class="img-thumbnail" alt="Review photo">
                            <a href="" class="btn btn-sm btn-danger delete-file-inbox-icon"
                               data-path="{{ $reviewImage }}"
                               data-listener="{{ route('backend.pages.delete-file', $page->id) }}"
                               data-key="reviews"
                               data-action="delete-image">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/frontend/js/gallery-and-reviews.js') }}"></script>
@endpush
