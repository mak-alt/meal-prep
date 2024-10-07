@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.inscriptions.edit', $inscription) }}

        <section class="content">
            <div class="container-fluid">
                @include('backend.layouts.partials.alerts.flash-messages')
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.inscriptions.update', $inscription->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Main information</h2>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="key">Key</label>
                                                <input type="text" class="form-control" id="key" name="key"
                                                       value="{{ $inscription->key }}"
                                                       disabled>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'key'])
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="page">URL</label>
                                                <input type="text" class="form-control" id="page" name="page"
                                                       value="{{ $inscription->page }}"
                                                       disabled>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'page'])
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="data">Text</label>
                                                <input type="text" class="form-control" id="data" name="data"
                                                       value="{{ $inscription->data }}"
                                                       required>
                                            </div>
                                            @include('backend.layouts.partials.alerts.input-error', ['name' => 'status'])
                                        </div>
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
