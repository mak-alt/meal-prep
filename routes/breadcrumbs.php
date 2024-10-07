<?php

use App\Models\Addon;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Gift;
use App\Models\Ingredient;
use App\Models\Inscription;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Page;
use App\Models\Recipe;
use App\Models\PaymentHistory;
use App\Models\Tag;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;

// Dashboard
Breadcrumbs::for('backend.dashboard', function ($trail) {
    $trail->push('Dashboard', route('backend.dashboard.index'));
});

// Settings
Breadcrumbs::for('backend.settings.index', function ($trail) {
    $trail->push('All Settings', route('backend.settings.index'));
});

// Sidebar Settings
Breadcrumbs::for('backend.settings.sidebar', function ($trail) {
    $trail->push('Sidebar Settings', route('backend.settings.sidebar'));
});

// Delivery Settings
Breadcrumbs::for('backend.settings.delivery', function ($trail) {
    $trail->push('Delivery Settings', route('backend.settings.delivery.index'));
});

// Delivery Time Settings
Breadcrumbs::for('backend.settings.delivery-time', function ($trail) {
    $trail->push('Delivery Time Settings', route('backend.settings.delivery-time.index'));
});

// Orders
Breadcrumbs::for('backend.orders.index', function ($trail) {
    $trail->push('All Orders', route('backend.orders.index'));
});
//Orders - Print Options
Breadcrumbs::for('backend.orders.print-options', function ($trail) {
    $trail->push('Print Options', route('backend.orders.print-options'));
});
// Show order
Breadcrumbs::for('backend.orders.show', function ($trail, Order $order) {
    $trail->parent('backend.orders.index');
    $trail->push("View Order #$order->id", route('backend.orders.show', $order));
});

// Users
Breadcrumbs::for('backend.users.index', function ($trail) {
    $trail->push('All Users', route('backend.users.index'));
});
Breadcrumbs::for('backend.users.points', function ($trail) {
    $trail->parent('backend.users.index');
    $trail->push("User Points", route('backend.users.points'));
});
// Edit user
Breadcrumbs::for('backend.users.edit', function ($trail, User $user) {
    $trail->parent('backend.users.index');
    $trail->push("Edit User #$user->id", route('backend.users.edit', $user));
});
// Create user
Breadcrumbs::for('backend.users.create', function ($trail) {
    $trail->parent('backend.users.index');
    $trail->push('Create New User', route('backend.users.create'));
});

// Payment history
Breadcrumbs::for('backend.users.payment-history.index', function ($trail) {
    $trail->push('All Payments', route('backend.users.payment-history.index'));
});
// Show payment
Breadcrumbs::for('backend.users.payment-history.show', function ($trail, PaymentHistory $payment) {
    $trail->parent('backend.users.payment-history.index');
    $trail->push("View Payment #$payment->id", route('backend.users.payment-history.show', $payment));
});

// Newsletter subscribers
Breadcrumbs::for('backend.users.newsletter.index', function ($trail) {
    $trail->push('All Newsletter Subscribers', route('backend.users.newsletter.index'));
});

// Pages
Breadcrumbs::for('backend.pages.index', function ($trail) {
    $trail->push('All Pages', route('backend.pages.index'));
});
// Edit page
Breadcrumbs::for('backend.pages.edit', function ($trail, Page $page) {
    $trail->parent('backend.pages.index');
    $trail->push("Edit Page #$page->id", route('backend.pages.edit', $page));
});

// Inscriptions
Breadcrumbs::for('backend.inscriptions.index', function ($trail) {
    $trail->push('All Inscriptions', route('backend.inscriptions.index'));
});
// Edit Inscription
Breadcrumbs::for('backend.inscriptions.edit', function ($trail, Inscription $inscription) {
    $trail->parent('backend.inscriptions.index');
    $trail->push("Edit Inscription #$inscription->id", route('backend.inscriptions.edit', $inscription));
});

// Categories
Breadcrumbs::for('backend.categories.index', function ($trail) {
    $trail->push('All Categories', route('backend.categories.index'));
});
// Edit category
Breadcrumbs::for('backend.categories.edit', function ($trail, Category $category) {
    $trail->parent('backend.categories.index');
    $trail->push("Edit Category #$category->id", route('backend.categories.edit', $category));
});
// Create category
Breadcrumbs::for('backend.categories.create', function ($trail) {
    $trail->parent('backend.categories.index');
    $trail->push('Create New Category', route('backend.categories.create'));
});

// Meals
Breadcrumbs::for('backend.meals.index', function ($trail) {
    $trail->push('All Meals', route('backend.meals.index'));
});
// Edit meal
Breadcrumbs::for('backend.meals.edit', function ($trail, Meal $meal) {
    $trail->parent('backend.meals.index');
    $trail->push("Edit Meal #$meal->id", route('backend.meals.edit', $meal));
});
// Create meal
Breadcrumbs::for('backend.meals.create', function ($trail) {
    $trail->parent('backend.meals.index');
    $trail->push('Create New Meal', route('backend.meals.create'));
});
// Meal settings
Breadcrumbs::for('backend.meals.settings.index', function ($trail) {
    $trail->parent('backend.meals.index');
    $trail->push('All Meal Settings', route('backend.meals.settings.index'));
});

//Side Meals
Breadcrumbs::for('backend.sides.index', function ($trail) {
    $trail->push('All Side Meals', route('backend.sides.index'));
});
// Edit side meal
Breadcrumbs::for('backend.sides.edit', function ($trail, Meal $meal) {
    $trail->parent('backend.sides.index');
    $trail->push("Edit Side Meal #$meal->id", route('backend.sides.edit', $meal));
});
// Create side meal
Breadcrumbs::for('backend.sides.create', function ($trail) {
    $trail->parent('backend.sides.index');
    $trail->push('Create New Side Meal', route('backend.sides.create'));
});

// Ingredients
Breadcrumbs::for('backend.ingredients.index', function ($trail) {
    $trail->push('All Ingredients', route('backend.ingredients.index'));
});
// Edit ingredient
Breadcrumbs::for('backend.ingredients.edit', function ($trail, Ingredient $ingredient) {
    $trail->parent('backend.ingredients.index');
    $trail->push("Edit Ingredient #$ingredient->id", route('backend.ingredients.edit', $ingredient));
});
// Create ingredient
Breadcrumbs::for('backend.ingredients.create', function ($trail) {
    $trail->parent('backend.ingredients.index');
    $trail->push('Create New Ingredient', route('backend.ingredients.create'));
});

// Menus
Breadcrumbs::for('backend.menus.index', function ($trail) {
    $trail->push('All Menus', route('backend.menus.index'));
});
// Edit menu
Breadcrumbs::for('backend.menus.edit', function ($trail, Menu $menu) {
    $trail->parent('backend.menus.index');
    $trail->push("Edit Menu #$menu->id", route('backend.menus.edit', $menu));
});
// Create menu
Breadcrumbs::for('backend.menus.create', function ($trail) {
    $trail->parent('backend.menus.index');
    $trail->push('Create New Menu', route('backend.menus.create'));
});
//Menu prices
Breadcrumbs::for('backend.menus.prices', function ($trail) {
    $trail->parent('backend.menus.index');
    $trail->push('Meal Plan Prices', route('backend.menus.price.index'));
});

// Addons
Breadcrumbs::for('backend.addons.index', function ($trail) {
    $trail->push('Addon Categories', route('backend.addons.index'));
});
// Addons meals
Breadcrumbs::for('backend.addons.meals.index', function ($trail) {
    $trail->push('All Addons Meals', route('backend.addons.meals'));
});
// Addons create
Breadcrumbs::for('backend.addons.meals.create', function ($trail) {
    $trail->parent('backend.addons.meals.index');
    $trail->push('Create Addon Meals', route('backend.addons.meals.create'));
});
// Addons create
Breadcrumbs::for('backend.addons.meals.edit', function ($trail , Meal $addon) {
    $trail->parent('backend.addons.meals.index');
    $trail->push("Edit Addon Meal #$addon->id", route('backend.addons.meals.edit', $addon));
});
// Edit addon
Breadcrumbs::for('backend.addons.edit', function ($trail, Addon $addon) {
    $trail->parent('backend.addons.index');
    $trail->push("Edit Addon Category #$addon->id", route('backend.addons.edit', $addon));
});
// Create addon
Breadcrumbs::for('backend.addons.create', function ($trail) {
    $trail->parent('backend.addons.index');
    $trail->push('Create Addon Categories', route('backend.addons.create'));
});

// Gifts
Breadcrumbs::for('backend.gifts.index', function ($trail) {
    $trail->push('All Gifts', route('backend.gifts.index'));
});
// Edit gift
Breadcrumbs::for('backend.gifts.edit', function ($trail, Gift $gift) {
    $trail->parent('backend.gifts.index');
    $trail->push("Edit Gift #$gift->id", route('backend.gifts.edit', $gift));
});
// Create gift
Breadcrumbs::for('backend.gifts.create', function ($trail) {
    $trail->parent('backend.gifts.index');
    $trail->push('Create New Gift', route('backend.gifts.create'));
});

// Referrals
Breadcrumbs::for('backend.referrals.index', function ($trail) {
    $trail->push('All Referrals', route('backend.referrals.index'));
});

// Filter Tags
Breadcrumbs::for('backend.filter-tags.index', function ($trail) {
    $trail->push('All Tags', route('backend.filter-tags.index'));
});
// Edit Tag
Breadcrumbs::for('backend.filter-tags.edit', function ($trail, Tag $tag) {
    $trail->parent('backend.filter-tags.index');
    $trail->push("Edit Tag #$tag->id", route('backend.filter-tags.edit', $tag));
});
// Create Tag
Breadcrumbs::for('backend.filter-tags.create', function ($trail) {
    $trail->parent('backend.filter-tags.index');
    $trail->push('Create New Tag', route('backend.filter-tags.create'));
});

// Recipes
Breadcrumbs::for('backend.recipes.index', function ($trail) {
    $trail->push('All Recipes', route('backend.recipes.index'));
});
// Edit Recipe
Breadcrumbs::for('backend.recipes.edit', function ($trail, Recipe $recipe) {
    $trail->parent('backend.recipes.index');
    $trail->push("Edit Recipe #$recipe->id", route('backend.recipes.edit', $recipe));
});
// Create Recipe
Breadcrumbs::for('backend.recipes.create', function ($trail) {
    $trail->parent('backend.recipes.index');
    $trail->push('Create New Recipe', route('backend.recipes.create'));
});

// Coupons
Breadcrumbs::for('backend.coupons.index', function ($trail) {
    $trail->push('All Coupons', route('backend.coupons.index'));
});
// Edit Coupon
Breadcrumbs::for('backend.coupons.edit', function ($trail, Coupon $coupon) {
    $trail->parent('backend.coupons.index');
    $trail->push("Edit Coupon #$coupon->id", route('backend.coupons.edit', $coupon));
});
// Create Coupon
Breadcrumbs::for('backend.coupons.create', function ($trail) {
    $trail->parent('backend.coupons.index');
    $trail->push('Create New Coupon', route('backend.coupons.create'));
});
