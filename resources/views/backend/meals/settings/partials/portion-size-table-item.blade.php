<tr data-index="{{ $index }}">
    <td>
        <div class="form-group">
            <input type="number"
                   name="portion_sizes[{{ $index }}][size]"
                   class="form-control" min="1" placeholder="Size..."
                   value="{{ old("portion_sizes.$index.size", $portionSize['size'] ?? '') }}" required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => "portion_sizes.$index.size"])
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="number"
                   name="portion_sizes[{{ $index }}][percentage]"
                   class="form-control" min="0" placeholder="%..."
                   value="{{ old("portion_sizes.$index.percentage", $portionSize['percentage'] ?? '') }}"
                   {{ !empty($disablePercentageEdition) || $index === 0 ? 'readonly' : '' }} required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => "portion_sizes.$index.percentage"])
        </div>
    </td>
    <td>
        @if(!empty($withDeleteButton) && $index !== 0)
            <div class="table_actions_btns">
                <button class="btn btn-danger"
                        data-action="delete-portion-size">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        @endif
    </td>
</tr>
