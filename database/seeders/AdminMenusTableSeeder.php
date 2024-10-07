<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminMenu::truncate();
        AdminMenu::updateOrCreate([//PARENT
            'id'=>1,
            'name'=>'Dashboard',
            'url'=>'backend.dashboard.index',
            'parent_id'=>null,
            'where_is'=>'admin/dashboard*',
            'icon'=>'fas fa-tachometer-alt',
        ]);
        AdminMenu::updateOrCreate([//PARENT
            'id'=>2,
            'name'=>'Pages',
            'url'=>'backend.pages.index',
            'parent_id'=>null,
            'where_is'=>'admin/pages*',
            'icon'=>'fas fa-book',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>3,
            'name'=>'Menu Categories',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/categories*',
            'icon'=>'fas fa-list-alt',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>17,
            'name'=>'All Categories',
            'url'=>'backend.categories.index',
            'parent_id'=>3,
            'where_is'=>'admin/categories',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>18,
            'name'=>'Create Category',
            'url'=>'backend.categories.create',
            'parent_id'=>3,
            'where_is'=>'admin/categories/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>4,
            'name'=>'Menu',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/menus*',
            'icon'=>'fas fa-utensils',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>19,
            'name'=>'All Menus',
            'url'=>'backend.menus.index',
            'parent_id'=>4,
            'where_is'=>'admin/menus',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>20,
            'name'=>'Create Menu',
            'url'=>'backend.menus.create',
            'parent_id'=>4,
            'where_is'=>'admin/menus/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT
            'id'=>5,
            'name'=>'Meal Plan Prices',
            'url'=>'backend.menus.price.index',
            'parent_id'=>null,
            'where_is'=>'admin/menus/prices*',
            'icon'=>'fas fa-money-check-alt',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>6,
            'name'=>'Meals',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/meals*',
            'icon'=>'fas fa-pizza-slice',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>21,
            'name'=>'All Meals',
            'url'=>'backend.meals.index',
            'parent_id'=>6,
            'where_is'=>'admin/meals',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>22,
            'name'=>'Create Meals',
            'url'=>'backend.meals.create',
            'parent_id'=>6,
            'where_is'=>'admin/meals/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>23,
            'name'=>'Meals Settings',
            'url'=>'backend.meals.settings.index',
            'parent_id'=>6,
            'where_is'=>'admin/meals/settings',
            'icon'=>'fas fa-cogs',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>7,
            'name'=>'Side Meals',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/sides*',
            'icon'=>'fas fa-pizza-slice',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>24,
            'name'=>'All Meals',
            'url'=>'backend.sides.index',
            'parent_id'=>7,
            'where_is'=>'admin/sides',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>25,
            'name'=>'Create Side',
            'url'=>'backend.sides.create',
            'parent_id'=>7,
            'where_is'=>'admin/sides/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>8,
            'name'=>'Ingredients',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/ingredients*',
            'icon'=>'fas fa-pepper-hot',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>26,
            'name'=>'All Ingredients',
            'url'=>'backend.ingredients.index',
            'parent_id'=>8,
            'where_is'=>'admin/ingredients',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>27,
            'name'=>'Create Ingredient',
            'url'=>'backend.ingredients.create',
            'parent_id'=>8,
            'where_is'=>'admin/ingredients/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>9,
            'name'=>'Addons',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/addons*',
            'icon'=>'fas fa-puzzle-piece',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>28,
            'name'=>'Addon Categories',
            'url'=>'backend.addons.index',
            'parent_id'=>9,
            'where_is'=>'admin/addons',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>29,
            'name'=>'Create Addon Categories',
            'url'=>'backend.addons.create',
            'parent_id'=>9,
            'where_is'=>'admin/addons/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>45,
            'name'=>'All Addon Meals',
            'url'=>'backend.addons.meals',
            'parent_id'=>9,
            'where_is'=>'admin/addons/meals',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>46,
            'name'=>'Create Addon Meals',
            'url'=>'backend.addons.meals.create',
            'parent_id'=>9,
            'where_is'=>'admin/addons/meals/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>10,
            'name'=>'Filter Tags',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/filter-tags*',
            'icon'=>'fas fa-filter',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>30,
            'name'=>'All Tags',
            'url'=>'backend.filter-tags.index',
            'parent_id'=>10,
            'where_is'=>'admin/filter-tags',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>31,
            'name'=>'Create Tag',
            'url'=>'backend.filter-tags.create',
            'parent_id'=>10,
            'where_is'=>'admin/filter-tags/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>11,
            'name'=>'Referrals',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/loyalty/referrals*',
            'icon'=>'fas fa-people-arrows',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>32,
            'name'=>'All Referrals',
            'url'=>'backend.referrals.index',
            'parent_id'=>11,
            'where_is'=>'admin/loyalty/referrals',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>12,
            'name'=>'Gift Cards',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/loyalty/gifts*',
            'icon'=>'fas fa-gift',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>33,
            'name'=>'All Gifts',
            'url'=>'backend.gifts.index',
            'parent_id'=>12,
            'where_is'=>'admin/loyalty/gifts',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>34,
            'name'=>'Create Gift',
            'url'=>'backend.gifts.create',
            'parent_id'=>12,
            'where_is'=>'admin/loyalty/gifts/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>13,
            'name'=>'Coupons',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/coupons*',
            'icon'=>'fas fa-ticket-alt',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>35,
            'name'=>'All Coupons',
            'url'=>'backend.coupons.index',
            'parent_id'=>13,
            'where_is'=>'admin/coupons',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>36,
            'name'=>'Create Coupon',
            'url'=>'backend.coupons.create',
            'parent_id'=>13,
            'where_is'=>'admin/coupons/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>14,
            'name'=>'Orders',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/orders*',
            'icon'=>'fas fa-file-invoice-dollar',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>49,
            'name'=>'All Orders',
            'url'=>'backend.orders.index',
            'parent_id'=>14,
            'where_is'=>'admin/orders',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>50,
            'name'=>'Print Options',
            'url'=>'backend.orders.print-options',
            'parent_id'=>14,
            'where_is'=>'admin/orders/prints',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>15,
            'name'=>'Users',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/users*',
            'icon'=>'fas fa-user-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>37,
            'name'=>'All Users',
            'url'=>'backend.users.index',
            'parent_id'=>15,
            'where_is'=>'admin/users',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>38,
            'name'=>'User Points',
            'url'=>'backend.users.points',
            'parent_id'=>15,
            'where_is'=>'admin/users/points',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>39,
            'name'=>'Create User',
            'url'=>'backend.users.create',
            'parent_id'=>15,
            'where_is'=>'admin/users/create',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>40,
            'name'=>'Payment History',
            'url'=>'backend.users.payment-history.index',
            'parent_id'=>15,
            'where_is'=>'admin/users/payment-history*',
            'icon'=>'fas fa-money-bill-wave-alt',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>51,
            'name'=>'Newsletter Subscribers',
            'url'=>'backend.users.newsletter.index',
            'parent_id'=>15,
            'where_is'=>'admin/users/newsletter*',
            'icon'=>'fas fa-rss',
        ]);
        AdminMenu::updateOrCreate([//PARENT DROP
            'id'=>16,
            'name'=>'Settings',
            'url'=>null,
            'parent_id'=>null,
            'where_is'=>'admin/settings*',
            'icon'=>'fas fa-cogs',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>41,
            'name'=>'All Settings',
            'url'=>'backend.settings.index',
            'parent_id'=>16,
            'where_is'=>'admin/settings',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>42,
            'name'=>'Admin Menus',
            'url'=>'backend.settings.sidebar',
            'parent_id'=>16,
            'where_is'=>'admin/settings/side-panel',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>43,
            'name'=>'Inscriptions',
            'url'=>'backend.inscriptions.index',
            'parent_id'=>16,
            'where_is'=>'admin/inscriptions/index',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>44,
            'name'=>'Delivery',
            'url'=>'backend.settings.delivery.index',
            'parent_id'=>16,
            'where_is'=>'admin/settings/delivery',
            'icon'=>'far fa-circle',
        ]);
        AdminMenu::updateOrCreate([
            'id'=>47,
            'name'=>'Delivery Time',
            'url'=>'backend.settings.delivery-time.index',
            'parent_id'=>16,
            'where_is'=>'admin/settings/delivery-time',
            'icon'=>'far fa-circle',
        ]);
    }
}
