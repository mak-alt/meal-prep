@foreach($sides as $side)
    <tr data-side-id="{{ $side->id }}">
        <td>{{ $side->id }}</td>
        <td>{{ $side->name }}</td>
        <td>
            <div class="form-group">
                <input type="number" class="form-control"
                       placeholder="Price..."
                       name="side_prices[{{ $side->id }}]"
                       value="{{ old("side_prices.$side->id", optional($side->pivot)->price ?? $side->price) }}"
                       min="0" required>
                @include('backend.layouts.partials.alerts.input-error', ['name' => "side_prices.$side->id"])
            </div>
        </td>
        <td>
            <div class="form-group">
                <input type="number" class="form-control"
                       placeholder="Points..."
                       name="side_points[{{ $side->id }}]"
                       value="{{ old("side_points.$side->id", optional($side->pivot)->points ?? $side->points) }}"
                       min="0" required>
                @include('backend.layouts.partials.alerts.input-error', ['name' => "side_points.$side->id"])
            </div>
        </td>
    </tr>
@endforeach
