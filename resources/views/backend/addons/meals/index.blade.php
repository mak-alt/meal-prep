@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.addons.meals.index') }}

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive-lg">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="form-group action-group">
                                        <select class="select form-control" id="table-multiple-actions">
                                            <option selected disabled>Actions</option>
                                            <option data-action="delete-multiple"
                                                    data-listener="{{ route('backend.meals.destroy-multiple') }}">
                                                Delete
                                            </option>
                                        </select>
                                        <button type="button" class="btn btn-inline-block btn-primary"
                                                data-action="execute-action-for-selected-records">
                                            Apply
                                        </button>
                                    </div>
                                    @include('backend.layouts.partials.alerts.input-error', ['isAjax' => true, 'name' => 'meal_ids'])
                                </div>
                                <div>
                                    <select class="select form-control" id="orderBy" name="order_by">
                                        <option value="" selected disabled>Order By</option>
                                        <option value="order_id" {{request()->sort === 'order_id' ? 'selected' : ''}}>ID</option>
                                        <option value="name" {{request()->sort === 'name' ? 'selected' : ''}}>Name</option>
                                        <option value="created_at" {{request()->sort === 'created_at' ? 'selected' : ''}}>Creation date</option>
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped" id="meals-table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="check_all">
                                            <label for="check_all">
                                            </label>
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Thumb</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($meals as $meal)
                                    <tr>
                                        <th>
                                            <div class="icheck-primary d-inline module__check">
                                                <input type="checkbox" id="checkboxPrimary{{ $loop->iteration }}"
                                                       value="{{ $meal->id }}">
                                                <label for="checkboxPrimary{{ $loop->iteration }}"></label>
                                            </div>
                                        </th>
                                        <td>{{ $meal->order_id }}</td>
                                        <td>
                                            <div class="conversion_table_img">
                                                <img
                                                    src="{{ asset($meal->thumb) }}"
                                                    alt="Meal photo">
                                            </div>
                                        </td>
                                        <td>{{ $meal->name }}</td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.addons.meals.edit', $meal->id) }}"
                                                   class="btn btn-block btn-primary">
                                                    Edit
                                                </a>
                                                <a href="{{ route('backend.addons.meals.delete', $meal->id) }}"
                                                   class="btn btn-block btn-danger" data-action="delete-record">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $meals->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/meals.js') }}"></script>
@endpush
