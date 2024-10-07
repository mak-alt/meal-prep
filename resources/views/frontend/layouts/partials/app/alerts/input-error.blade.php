@php($hasClearIcon = !isset($hasClearIcon) ? true : $hasClearIcon)

@empty($isAjax)
    @error($name)
    <p class="error-text error-input-text active" style="{{ isset($positionAbsolute) && !$positionAbsolute ? 'position: unset;' : '' }}">
        {{ $message }}
    </p>
    @enderror
@else
    <p class="error-text error-input-text" data-field-name="{{ $name }}"
       style="{{ isset($positionAbsolute) && !$positionAbsolute ? 'position: unset;' : '' }}"></p>
@endif
