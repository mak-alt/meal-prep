<aside class="main-sidebar elevation-4">
    <a href="{{ route('backend.dashboard.index') }}" class="logo-admin">
        <img src="{{ asset('/assets/backend/img/home-header-logo.svg') }}" alt="Logo" class="brand-image"
             style="opacity: .8">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach($adminMenu as $menu)
                    <li class="nav-item {{count($menu->childCategories) > 0 ? 'has-treeview' : ''}} {{count($menu->childCategories) > 0 && request()->is($menu->where_is) ? 'menu-open' : '' }}">
                        <a href="{{Route::has($menu->url) ? route($menu->url) : '' }}"
                           class="nav-link {{ Route::has($menu->url) && request()->is($menu->where_is) ? 'active' : '' }}">
                            <i class="nav-icon {{$menu->icon}}"></i>
                            <p>
                                {{$menu->name}}
                            </p>
                            @if(count($menu->childCategories) > 0)
                                <i class="right fas fa-angle-left"></i>
                            @endif
                        </a>
                    @if(count($menu->childCategories) > 0)
                        @foreach($menu->childCategories as $child)
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route($child->url) }}"
                                       class="nav-link {{ request()->is($child->where_is) ? 'active' : '' }}">
                                        <i class="{{$child->icon}} nav-icon"></i>
                                        <p>{{$child->name}}</p>
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
