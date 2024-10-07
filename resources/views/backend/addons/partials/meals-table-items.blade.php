@foreach($meals as $meal)
    <tr data-meal-id="{{ $meal->id }}">
        <td>{{ $meal->id }}</td>
        <td>{{ $meal->name }}</td>
        <td>
            <div class="form-group">
                <input type="number" class="form-control"
                       placeholder="Price..."
                       name="meal_prices[{{ $meal->id }}]"
                       value="{{ old("meal_prices.$meal->id", optional($meal->pivot)->price ?? $meal->price) }}"
                       min="1" required>
                @include('backend.layouts.partials.alerts.input-error', ['name' => "meal_prices.$meal->id"])
            </div>
        </td>
        <td>
            <div class="form-group">
                <input type="number" class="form-control"
                       placeholder="Points..."
                       name="meal_points[{{ $meal->id }}]"
                       value="{{ old("meal_points.$meal->id", optional($meal->pivot)->points ?? $meal->points) }}"
                       min="1" required>
                @include('backend.layouts.partials.alerts.input-error', ['name' => "meal_points.$meal->id"])
            </div>
        </td>
    </tr>
@endforeach
