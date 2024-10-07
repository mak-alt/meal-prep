@extends('backend.layouts.app')

@section('content')

    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.settings.sidebar') }}

        <section class="content">
            <div class="row">
                <div class="col-12">
                @include('backend.layouts.partials.alerts.flash-messages')

                    <form action="{{ route('backend.settings.sidebar.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                @foreach($adminMenus as $menu)
                                    <div class="col-12">
                                        <div class="mb-5">
                                            <div class="form-group">
                                                <label for="{{str_replace(' ','-',strtolower($menu->name))}}">{{$menu->name}}</label>
                                                <input type="text" class="form-control" id="{{str_replace(' ','-',strtolower($menu->name))}}" name="{{$menu->id}}"
                                                       placeholder="Title..."
                                                       value="{{  $menu->name ?? '' }}" required>
                                            </div>
                                        </div>
                                        @if(count($menu->childCategories) > 0)
                                            <div class="row">
                                                @foreach($menu->childCategories as $child)
                                                    <div class="form-group col-md-4">
                                                        <label for="{{str_replace(' ','-',strtolower($child->name))}}">{{$child->name}}</label>
                                                        <input type="text" class="form-control" id="{{str_replace(' ','-',strtolower($child->name))}}" name="{{$child->id}}"
                                                               placeholder="Title..."
                                                               value="{{  $child->name ?? '' }}" required>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
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
