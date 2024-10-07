<aside class="main-sidebar elevation-4">
    <a href="{{ route('backend.dashboard.index') }}" class="logo-admin">
        <img src="{{ asset('/assets/backend/img/home-header-logo.svg') }}" alt="Logo" class="brand-image"
             style="opacity: .8">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('backend.dashboard.index') }}"
                       class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.pages.index') }}"
                       class="nav-link {{ request()->is('admin/pages*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Pages
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/categories*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Categories
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.categories.index') }}"
                               class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Categories</p>
                            </a>
                        </li>
                        {{--<li class="nav-item">
                            <a href="{{ route('backend.categories.create') }}"
                               class="nav-link {{ request()->is('admin/categories/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Category</p>
                            </a>
                        </li>--}}
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/meals*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-pizza-slice"></i>
                        <p>
                            Meals
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.meals.index') }}"
                               class="nav-link {{ request()->is('admin/meals') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Meals</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.meals.create') }}"
                               class="nav-link {{ request()->is('admin/meals/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Meal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.meals.settings.index') }}"
                               class="nav-link {{ request()->is('admin/meals/settings') ? 'active' : '' }}">
                                <i class="fa fa-cogs nav-icon"></i>
                                <p>Meals Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/ingredients*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-pepper-hot"></i>
                        <p>
                            Ingredients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.ingredients.index') }}"
                               class="nav-link {{ request()->is('admin/ingredients') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Ingredients</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.ingredients.create') }}"
                               class="nav-link {{ request()->is('admin/ingredients/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Ingredient</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/menus*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>
                            Menu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.menus.index') }}"
                               class="nav-link {{ request()->is('admin/menus') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Menus</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.menus.create') }}"
                               class="nav-link {{ request()->is('admin/menus/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Menu</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/addons*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-puzzle-piece"></i>
                        <p>
                            Addons
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.addons.index') }}"
                               class="nav-link {{ request()->is('admin/addons') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Addons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.addons.create') }}"
                               class="nav-link {{ request()->is('admin/addons/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Addon</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/filter-tags*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="fas fa-filter"></i>
                        <p>
                            Filter Tags
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.filter-tags.index') }}"
                               class="nav-link {{ request()->is('admin/filter-tags') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Tags</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.filter-tags.create') }}"
                               class="nav-link {{ request()->is('admin/filter-tags/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Tag</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/loyalty/referrals*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-people-arrows"></i>
                        <p>
                            Referrals
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.referrals.index') }}"
                               class="nav-link {{ request()->is('admin/loyalty/referrals') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Referrals</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/loyalty/gifts*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>
                            Gift Cards
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.gifts.index') }}"
                               class="nav-link {{ request()->is('admin/loyalty/gifts') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Gifts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.gifts.create') }}"
                               class="nav-link {{ request()->is('admin/loyalty/gifts/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Gift</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/coupons*') ? 'menu-open' : '' }}">
                    <a href="{{ route('backend.coupons.index') }}"
                       class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Coupons
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.coupons.index') }}"
                               class="nav-link {{ request()->is('admin/coupons') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.coupons.create') }}"
                               class="nav-link {{ request()->is('admin/coupons/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Coupon</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.orders.index') }}"
                       class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.users.index') }}"
                               class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    All Users
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.users.create') }}"
                               class="nav-link {{ request()->is('admin/users/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Create User
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.users.payment-history.index') }}"
                               class="nav-link {{ request()->is('admin/users/payment-history*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                                <p>
                                    Payment History
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.users.newsletter.index') }}"
                               class="nav-link {{ request()->is('admin/users/newsletter*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rss"></i>
                                <p>
                                    Newsletter Subscribers
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/settings*') ? 'menu-open' : '' }}">
                    <a href=""
                       class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.settings.index') }}"
                               class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Settings
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                               class="nav-link {{ request()->is('admin/settings/side-panel') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Admin Menus
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.inscriptions.index') }}"
                               class="nav-link {{ request()->is('admin/inscriptions/index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Inscriptions
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
