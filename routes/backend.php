<?php

use App\Http\Controllers\Backend\AddonController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\PasswordManagementController;
use App\Http\Controllers\Backend\Auth\RegisterController;
use App\Http\Controllers\Backend\Blog\PostController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FilterTagController;
use App\Http\Controllers\Backend\IngredientController;
use App\Http\Controllers\Backend\InscriptionController;
use App\Http\Controllers\Backend\Loyalty\GiftController;
use App\Http\Controllers\Backend\Loyalty\ReferralController;
use App\Http\Controllers\Backend\Meal\MealController;
use App\Http\Controllers\Backend\Meal\SettingController as MealSettingController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SettingDeliveryController;
use App\Http\Controllers\Backend\SettingDeliveryTimeController;
use App\Http\Controllers\Backend\User\NewsletterController;
use App\Http\Controllers\Backend\User\OrderController;
use App\Http\Controllers\Backend\User\PaymentHistoryController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\Backend\SideController;
use App\Http\Controllers\Backend\MenuPricesController;
use App\Http\Controllers\Backend\WeeklyMenuController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route settings
Route::fallback(function () {
    abort(404);
});

// Auth
Route::middleware(['guest'])->as('auth.')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
    });
    Route::prefix('register')->group(function () {
        Route::get('/', [RegisterController::class, 'index'])->name('register');
    });
    Route::as('password.')->group(function () {
        Route::get('/forgot-password', [PasswordManagementController::class, 'forgotPasswordForm'])->name('request');
        Route::get('/password/reset', [PasswordManagementController::class, 'resetPasswordForm'])->name('reset');
    });
});

// Main routes
$adminRole = User::ROLES['admin'];
Route::middleware(['auth', "user-active-and-has-role:$adminRole"])->group(function () {
    // Dashboard
    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    // Pages
    Route::prefix('pages')->as('pages.')->group(function () {
        Route::delete('/{page}/file', [PageController::class, 'deleteFile'])->name('delete-file');
        Route::resource('', PageController::class)
            ->parameter('', 'page')
            ->except(['show', 'create', 'store']);
    });

    // Weekly menu
    Route::prefix('weekly-menu')->as('weekly-menu.')->group(function (){
        Route::resource('', WeeklyMenuController::class)
        ->parameter('', 'weeklyMenu')
        ->except(['show', 'index']);
    });

    // Inscriptions
    Route::prefix('inscriptions')->as('inscriptions.')->group(function () {
        Route::resource('', InscriptionController::class)
            ->parameter('', 'inscription')
            ->except(['show', 'create', 'store']);
    });


    // Orders
    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/toggle-status/{order}', [OrderController::class, 'toggleStatus'])->name('status.toggle');
        Route::get('/{order}/receipt', [OrderController::class, 'showReceipt'])->name('show-receipt');
        Route::get('/export', [OrderController::class, 'exportToExcel'])->name('export');
        Route::get('/export-pdf', [OrderController::class, 'exportToPdf'])->name('export.pdf');
        Route::get('/print/{order}', [OrderController::class, 'printSingleOrder'])->name('print.pdf');
        Route::get('/print-options', [OrderController::class, 'printOptionsPage'])->name('print-options');
        Route::resource('', OrderController::class)
            ->parameter('', 'order')
            ->only(['index', 'show', 'destroy']);
    });

    // Settings
    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
        Route::get('/side-panel',[SettingController::class, 'sidePanelIndex'])->name('sidebar');
        Route::put('/side-panel',[SettingController::class, 'sidePanelUpdate'])->name('sidebar.update');

        // Delivery
        Route::prefix('delivery')->as('delivery.')->group(function () {
            Route::get('/', [SettingDeliveryController::class, 'index'])->name('index');
            Route::put('/', [SettingDeliveryController::class, 'update'])->name('update');
        });

        // Delivery Time
        Route::prefix('delivery-time')->as('delivery-time.')->group(function () {
            Route::get('/', [SettingDeliveryTimeController::class, 'index'])->name('index');
            Route::put('/', [SettingDeliveryTimeController::class, 'update'])->name('update');
        });
    });

    // Users
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/points', [UserController::class, 'userPoints'])->name('points');
        Route::resource('', UserController::class)
            ->parameter('', 'user')
            ->except('show');
        Route::delete('/payments/{payment_profile}', [UserController::class, 'destroyPaymentMethod'])
            ->name('destroy-payment-method');
        Route::patch('/{user}/update-status/{status}', [UserController::class, 'updateStatus'])
            ->where('status', sprintf('^(%s)$', implode('|', User::STATUSES)))
            ->name('update-status');

        // Payment history
        Route::prefix('payment-history')->as('payment-history.')->group(function () {
            Route::resource('', PaymentHistoryController::class)
                ->parameter('', 'payment-history')
                ->only(['index', 'show']);
        });

        // Newsletter subscribers
        Route::prefix('newsletter')->as('newsletter.')->group(function () {
            Route::resource('', NewsletterController::class)
                ->parameter('', 'newsletter_subscriber')
                ->only(['index', 'destroy']);
        });
    });

    // Loyalty
    Route::prefix('loyalty')->group(function () {
        // Gifts
        Route::prefix('gifts')->as('gifts.')->group(function () {
            Route::resource('', GiftController::class)
                ->parameter('', 'gift')
                ->except('show');
        });

        // Referrals
        Route::prefix('referrals')->as('referrals.')->group(function () {
            Route::resource('', ReferralController::class)
                ->parameter('', 'referral')
                ->only(['index', 'destroy']);
        });
    });

    // Coupons
    Route::prefix('coupons')->as('coupons.')->group(function () {
        Route::resource('', CouponController::class)
            ->parameter('', 'coupon')
            ->except('show');
    });

    // Categories
    Route::prefix('categories')->as('categories.')->group(function () {
        Route::resource('', CategoryController::class)
            ->parameter('', 'category')
            ->except(['show']);
    });

    // Ingredients
    Route::prefix('ingredients')->as('ingredients.')->group(function () {
        Route::resource('', IngredientController::class)
            ->parameter('', 'ingredient')
            ->except('show');
    });

    // Meals
    Route::prefix('meals')->as('meals.')->group(function () {
        Route::delete('/multiple', [MealController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::resource('', MealController::class)
            ->parameter('', 'meal')
            ->except('show');
        Route::get('/calculate-points', [MealController::class, 'calculatePoints'])->name('calculate-points');
        Route::get('/render-selected-sides-table-items', [MealController::class, 'renderSelectedSidesTableItems'])
            ->name('render-selected-sides-table-items');
        // Settings
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/', [MealSettingController::class, 'index'])->name('index');
            Route::put('/update', [MealSettingController::class, 'update'])->name('update');
            Route::get('/render-portion-size-table-item', [MealSettingController::class, 'renderPortionSizeTableItem'])
                ->name('render-portion-size-table-item');
        });
        Route::post('toggle-status/{meal}', [MealController::class, 'toggleStatus'])->name('toggle-status');
    });
    Route::get('/get-sides-categories', [MealController::class, 'getSidesByCategory'])->name('sides-cat.get');
    Route::get('/get-category-remove', [MealController::class, 'getCategoryToRemove'])->name('sides-cat.remove');

    //Sides
    Route::prefix('sides')->as('sides.')->group(function () {
        Route::delete('/multiple', [SideController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::resource('', SideController::class)
            ->parameter('', 'side')
            ->except('show');
    });

    // Menus
    Route::prefix('menus')->as('menus.')->group(function () {
        Route::resource('', MenuController::class)
            ->parameter('', 'menu')
            ->except(['show']);
        Route::get('/get-entry-by-category', [MenuController::class, 'getMealsByCategory'])->name('meals.get');
        Route::get('/calculate-points', [MenuController::class, 'calculatePoints'])->name('calculate-points');
        Route::get('/render-selected-meal-table-items', [MenuController::class, 'renderSelectedMealTableItems'])
            ->name('render-selected-meal-table-items');
        Route::get('/prices', [MenuPricesController::class, 'index'])->name('price.index');
        Route::post('/prices', [MenuPricesController::class, 'update'])->name('price.update');
    });

    // Addons
    Route::prefix('addons')->as('addons.')->group(function () {
        Route::resource('', AddonController::class)
            ->parameter('', 'addon')
            ->except(['show']);
        Route::get('/render-selected-meals-table-items', [AddonController::class, 'renderSelectedMealsTableItems'])
            ->name('render-selected-meals-table-items');
        Route::get('/meals', [AddonController::class, 'mealsIndex'])->name('meals');
        Route::get('/meals/create', [AddonController::class, 'mealsCreateIndex'])->name('meals.create');
        Route::post('/meals/create', [AddonController::class, 'mealsCreate'])->name('meals.store');
        Route::get('/meals/{addon}', [AddonController::class, 'mealsEdit'])->name('meals.edit');
        Route::put('/meals/{addon}', [AddonController::class, 'mealsUpdate'])->name('meals.update');
        Route::delete('/meals/{addon}', [AddonController::class, 'mealsDelete'])->name('meals.delete');
    });

    // Addons
    Route::prefix('filter-tags')->as('filter-tags.')->group(function () {
        Route::resource('', FilterTagController::class)
            ->parameter('', 'tag')
            ->except(['show']);
    });

// Blog
    Route::prefix('blog')->as('blog.')->group(function () {
        // Posts
        Route::prefix('posts')->as('posts.')->group(function () {
            Route::resource('', PostController::class)
                ->parameter('', 'post')
                ->except('show');
        });
    });
});
