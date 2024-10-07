<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Frontend\AddonController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DeliveryController;
use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\Frontend\Loyalty\GiftController;
use App\Http\Controllers\Frontend\Loyalty\ReferralController;
use App\Http\Controllers\Frontend\Loyalty\RewardController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\OrderAndMenuController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ShoppingCartController;
use App\Http\Controllers\Frontend\SiteController;

use App\Http\Controllers\StripePaymentController;

use App\Models\Order;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing page
Route::as('landing.')->middleware('name-check')->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('index');
    Route::get('/menu-prices', [LandingController::class, 'getMenuPrice'])->name('prices');


    Route::get('/stripe-payment-process/{id}', [LandingController::class, 'stripe_payment_process'])->name('stripe_payment_process');

});

// Main routes
$customerRole = User::ROLES['user'];
// Order and menu
Route::prefix('order-and-menu')->as('order-and-menu.')->middleware('name-check')->group(function () {

    

    // Select meals
    Route::prefix('select-meals')->group(function () {
        Route::get('/review-order', [OrderAndMenuController::class, 'reviewOrderSelection'])
            ->name('review-order-selection');
        Route::get('/{meal_number}', [OrderAndMenuController::class, 'selectMeals'])->name('select-meals');
        Route::post('/update-amount-of-meals', [OrderAndMenuController::class, 'updateAmountOfMeals'])
            ->name('update-amount-of-meals');
        Route::get('/{meal_number}/sort', [OrderAndMenuController::class, 'sortSides'])->name('sides-sort');

        // Meal creation
        Route::prefix('meal-creation')->as('meal-creation.')->group(function () {
            Route::post('/start-over', [OrderAndMenuController::class, 'startOverMealCreation'])->name('start-over');
            Route::post('/duplicate', [OrderAndMenuController::class, 'duplicateMeals'])->name('duplicate-meals');
            Route::post('/select-portion-size', [OrderAndMenuController::class, 'selectPortionSize'])
                ->name('select-portion-size');
            Route::get('/refresh-portion-sizes-values', [OrderAndMenuController::class, 'refreshPortionSizesValues'])
                ->name('refresh-portion-sizes-values');
            Route::post('/select-portion-size-menu/{category}', [OrderAndMenuController::class, 'selectPortionSizeForMenu'])
                ->name('select-portion-size-menu');
            Route::prefix('{meal_number}')->group(function () {
                Route::post('/discard', [OrderAndMenuController::class, 'discardMealCreation'])->name('discard');
                Route::post('/validate-step', [OrderAndMenuController::class, 'validateMealCreationStep'])
                    ->name('validate-step');
                Route::get('/render-duplicate-meals-popup', [OrderAndMenuController::class, 'renderDuplicateMealsPopup'])
                    ->name('render-duplicate-meals-popup');
            });
        });
    });

    Route::get('/{category:name}', [OrderAndMenuController::class, 'index'])->name('index');
    Route::post('/remember-preferred-menu-type-selection', [OrderAndMenuController::class, 'rememberPreferredMenuTypeSelection'])
        ->name('remember-preferred-menu-type-selection');
    Route::post('/remember-free-meals-selection', [OrderAndMenuController::class, 'rememberFreeMealsSelection'])
        ->name('remember-free-meals-selection');
    Route::get('/duplicate/{menu}', [OrderAndMenuController::class, 'duplicateMenu'])->name('menu.duplicate');

    // Meals
    Route::prefix('{meal}')->group(function () {
        Route::get('/render-meal-details-popup', [OrderAndMenuController::class, 'renderMealDetailsPopup'])
            ->name('render-meal-details-popup');
        Route::get('/render-side-details-popup', [OrderAndMenuController::class, 'renderSideDetailsPopup'])
            ->name('render-side-details-popup');
        Route::post('/toggle-entry-meal-selection', [OrderAndMenuController::class, 'toggleEntryMealSelection'])
            ->name('toggle-entry-meal-selection');
        Route::post('/toggle-side-meal-selection', [OrderAndMenuController::class, 'toggleSideMealSelection'])
            ->name('toggle-side-meal-selection');
    });

    // Addons
    Route::prefix('addons')->as('addons.')->group(function () {
        Route::resource('', AddonController::class)->parameter('', 'addon')->only('show');
        Route::post('/{addon}/toggle-meal-selection', [AddonController::class, 'toggleMealSelection'])
            ->name('toggle-meal-selection');
        Route::post('/{addon}/toggle-add-to-cart', [AddonController::class, 'toggleAddToCart'])->name('toggle-add-to-cart');
        Route::get('/{addon}/remove/{uuid}', [AddonController::class, 'removeAddonFromCart'])->name('remove');
    });
});

// Shopping cart
Route::prefix('shopping-cart')->as('shopping-cart.')->middleware('name-check')->group(function () {

    

    Route::get('/', [ShoppingCartController::class, 'index'])->name('index');
    Route::post('/', [ShoppingCartController::class, 'store'])->name('store');
    Route::prefix('{uuid}')->group(function () {
        Route::post('/duplicate', [ShoppingCartController::class, 'duplicate'])->name('duplicate');
        Route::post('/complete-menu', [ShoppingCartController::class, 'completeMenu'])->name('complete-menu');
        Route::delete('/', [ShoppingCartController::class, 'destroy'])->name('destroy');
    });
    Route::post('/undo-deleting', [ShoppingCartController::class, 'undoDestroy'])->name('undo-destroy');
});

// Checkout
Route::prefix('checkout')
    ->as('checkout.')
    ->middleware(['auth', "user-active-and-has-role:$customerRole", 'name-check'])
    ->group(function () {
        



        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::get('/timeframes', [CheckoutController::class, 'getTimeframesForWeekDay'])->name('timeframes');
        Route::post('/proceed-to-checkout', [CheckoutController::class, 'proceedToCheckout'])->name('proceed-to-checkout');
        // Coupon
        Route::prefix('coupon')->as('coupon.')->group(function () {
            Route::post('/apply', [CheckoutController::class, 'applyCoupon'])->name('apply');
            Route::post('/remove', [CheckoutController::class, 'removeCoupon'])->name('remove');
        });
        Route::get('calculate-total-price', [CheckoutController::class, 'calculateTotalPrice'])->name('calculate-total-price');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        // PayPal
        Route::prefix('paypal')->as('paypal.')->group(function () {
            Route::get('/store-order-after-payment', [CheckoutController::class, 'storeOrderAfterPayPalPayment'])
                ->name('store-order-after-payment');
        });
    });

// Orders
Route::prefix('orders')
    ->as('orders.')
    ->middleware(['auth', "user-active-and-has-role:$customerRole", 'name-check'])
    ->group(function () {
        Route::get('/{order_status}', [OrderController::class, 'index'])
            ->where('order_status', sprintf('^(%s)$', implode('|', Order::STATUSES)))
            ->name('index');
        Route::resource('', OrderController::class)->parameter('', 'order')->only('show');
        // Order
        Route::prefix('{order}')->group(function () {
            Route::get('/download-receipt', [OrderController::class, 'downloadReceipt'])->name('download-receipt');
            Route::post('/repeat', [OrderController::class, 'repeat'])->name('repeat');
        });
    });

// Profile
Route::prefix('profile')
    ->as('profile.')
    ->middleware(['auth', "user-active-and-has-role:$customerRole"])
    ->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/get-default-delivery-address', [ProfileController::class, 'getDefaultDeliveryAddress'])
            ->name('get-default-delivery-address');
        Route::as('update.')->group(function () {
            Route::put('/personal-details', [ProfileController::class, 'updatePersonalDetails'])
                ->name('personal-details');
            Route::patch('/email', [ProfileController::class, 'updateEmail'])
                ->name('email')
                ->middleware('throttle:10,30');
            Route::patch('/password', [ProfileController::class, 'updatePassword'])
                ->name('password')
                ->middleware('throttle:10,30');
            Route::put('/delivery-address', [ProfileController::class, 'updateDeliveryAddress'])
                ->name('delivery-address');
            Route::put('/billing-address', [ProfileController::class, 'updateBillingAddress'])
                ->name('billing-address');
        });
        Route::prefix('payments')->group(function () {
            Route::post('/', [ProfileController::class, 'storePaymentMethod'])->name('store-payment-method');
            Route::delete('/{payment_profile}', [ProfileController::class, 'destroyPaymentMethod'])
                ->name('destroy-payment-method');
        });
    });

// Delivery
Route::prefix('delivery')->as('delivery.')->group(function () {
    Route::get('/calculate-delivery-fees', [DeliveryController::class, 'calculateDeliveryFees'])
        ->name('calculate-delivery-fees');
});

// Loyalty
Route::prefix('loyalty')->group(function () use ($customerRole) {
    // Rewards
    Route::prefix('rewards')->as('rewards.')
        ->middleware(['auth', "user-active-and-has-role:$customerRole"])
        ->group(function () {
        Route::get('/', [RewardController::class, 'index'])->name('index');
    });

    // Referrals
    Route::prefix('referrals')->as('referrals.')
        ->middleware(['auth', "user-active-and-has-role:$customerRole"])
        ->group(function () {
        Route::get('/', [ReferralController::class, 'index'])->name('index');
        Route::get('/join/{referral_code_hash}', [ReferralController::class, 'join'])->name('join');
        Route::patch('/update-code', [ReferralController::class, 'updateCode'])->name('update-code');
        Route::post('/{delivery_channel}/send', [ReferralController::class, 'send'])
            ->name('send')
            ->where('delivery_channel', sprintf('^(%s)$', implode('|', Referral::DELIVERY_CHANNELS)));
    });

    // Gifts
    Route::prefix('gifts')->as('gifts.')->group(function () {
        Route::get('/', [GiftController::class, 'index'])->name('index');
        Route::post('/send/{delivery_channel?}', [GiftController::class, 'send'])->name('send');
        Route::post('/remember-gift-options', [GiftController::class, 'rememberGiftOptions'])
            ->name('remember-gift-options');
        Route::post('/remember-gift-contacts-info', [GiftController::class, 'rememberGiftContactsInfo'])
            ->name('remember-gift-contacts-info');
        Route::post('/redeem', [GiftController::class, 'redeem'])->name('redeem');

        // PayPal
        Route::prefix('paypal')->as('paypal.')->group(function () {
            Route::get('/send-after-payment/{delivery_channel?}', [GiftController::class, 'sendAfterPayPalPayment'])
                ->name('send-after-payment');
        });
    });
});

// Subscribe to newsletter
Route::prefix('newsletter')->as('newsletter.')->group(function () {
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
});

// Files handling
Route::prefix('files')->as('files.')->group(function () {
    Route::post('/', [FileUploadController::class, 'store'])->name('store');
    Route::delete('/', [FileUploadController::class, 'destroy'])->name('destroy');
});

// Root route for site pages
Route::get('/{slug?}', [SiteController::class, 'router'])->where('slug', '(.*)');



