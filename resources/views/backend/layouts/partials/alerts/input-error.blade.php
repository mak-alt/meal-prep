@empty($isAjax)
    @error($name)
    <p class="text-danger">{{ $message }}</p>
    @enderror
@else
    <p class="text-danger" data-field-name="{{ $name }}"></p>
@endif
