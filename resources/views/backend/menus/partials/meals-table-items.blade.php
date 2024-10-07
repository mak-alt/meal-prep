@isset($mealSides)
    @foreach($meals as $meal)
        @if(isset($meal->selected_sides) && is_array($meal->selected_sides) && !empty($meal->selected_sides))
            <tr data-meal-id="{{ $meal->id }}" data-calories="{{$meal->calories}}" data-fats="{{$meal->fats}}" data-proteins="{{$meal->proteins}}" data-carbs="{{$meal->carbs}}">
                <td class="col-1">{{ $meal->id }}</td>
                <td class="col-3">{{ $meal->name }}</td>
                <td class="col-8">
                    <div class="form-group">
                        <select name="meal_side_ids[{{ $meal->id }}][{{$loop->index}}][]" class="select2 form-control select-sides"
                                data-placeholder="Meal sides..."
                                multiple>
                            @foreach($sides ?? [] as $side)
                                <option data-calories="{{$side->calories}}" data-fats="{{$side->fats}}" data-proteins="{{$side->proteins}}" data-carbs="{{$side->carbs}}"
                                        value="{{ $side->id }}" {{ in_array($side->id, old("meal_side_ids.$meal->id.$loop->index", [])) || (!empty($menu) && !old("meal_side_ids.$meal->id.$loop->index") && in_array($side->id, $meal->selected_sides)) ? 'selected' : '' }}>
                                    {{ $side->name }}
                                </option>
                            @endforeach
                        </select>
                        @include('backend.layouts.partials.alerts.input-error', ['name' => "meal_side_ids.$meal->id.$loop->index"])
                    </div>
                </td>
            </tr>
        @else
            <tr data-meal-id="{{ $meal->id }}" data-calories="{{$meal->calories}}" data-fats="{{$meal->fats}}" data-proteins="{{$meal->proteins}}" data-carbs="{{$meal->carbs}}">
                <td class="col-1">{{ $meal->id }}</td>
                <td class="col-3">{{ $meal->name }}</td>
                <td class="col-8">
                    <div class="form-group">
                        <select name="meal_side_ids[{{ $meal->id }}][1][]" class="select2 form-control select-sides"
                                data-placeholder="Meal sides..."
                                multiple>
                            @foreach($sides ?? [] as $side)
                                <option data-calories="{{$side->calories}}" data-fats="{{$side->fats}}" data-proteins="{{$side->proteins}}" data-carbs="{{$side->carbs}}"
                                        value="{{ $side->id }}" {{ in_array($side->id, old("meal_side_ids.$meal->id.$loop->index", [])) ? 'selected' : '' }}>
                                    {{ $side->name }}
                                </option>
                            @endforeach
                        </select>
                        @include('backend.layouts.partials.alerts.input-error', ['name' => "meal_side_ids.$meal->id.$loop->index"])
                    </div>
                </td>
            </tr>
        @endisset
    @endforeach
@else
    @foreach($meals as $meal)
        <tr data-meal-id="{{ $meal->id }}" data-calories="{{$meal->calories}}" data-fats="{{$meal->fats}}" data-proteins="{{$meal->proteins}}" data-carbs="{{$meal->carbs}}">
            <td class="col-1">{{ $meal->id }}</td>
            <td class="col-3">{{ $meal->name }}</td>
            <td class="col-8">
                <div class="form-group">
                    <select name="meal_side_ids[{{ $meal->id }}][{{$times}}][]" class="select2 form-control select-sides"
                            data-placeholder="Meal sides..."
                            multiple>
                        @foreach($sides ?? [] as $side)
                            <option data-calories="{{$side->calories}}" data-fats="{{$side->fats}}" data-proteins="{{$side->proteins}}" data-carbs="{{$side->carbs}}"
                                    value="{{ $side->id }}" {{ in_array($side->id, old("meal_side_ids.$meal->id.$times", [])) || (!empty($menu) && !old("meal_side_ids.$meal->id.$times") && in_array($side->id, $meal->menuSides()->where('menu_id', $menu->id)->get()->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $side->name }}
                            </option>
                        @endforeach
                    </select>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "meal_side_ids.$meal->id.$times"])
                </div>
            </td>
        </tr>
    @endforeach
@endisset
