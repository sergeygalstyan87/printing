<?php

use App\Http\Controllers\Admin\UploadedFileTypesController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Front\PageController::class, 'home'])->name('home');
Route::get('/about', [App\Http\Controllers\Front\PageController::class, 'about'])->name('about');
Route::get('/faq', [App\Http\Controllers\Front\PageController::class, 'faq'])->name('faq');
Route::get('/policy', [App\Http\Controllers\Front\PageController::class, 'policy'])->name('policy');
Route::get('/terms', [App\Http\Controllers\Front\PageController::class, 'terms'])->name('terms');
Route::get('/refunds', [App\Http\Controllers\Front\PageController::class, 'refunds'])->name('refunds');
Route::get('/contact', [App\Http\Controllers\Front\PageController::class, 'contact'])->name('contact');
Route::get('/shippo', [App\Http\Controllers\Front\PageController::class, 'shippo'])->name('shippo');
Route::get('/calculate', [App\Http\Controllers\Front\OrderController::class, 'calculatePrice'])->name('calculate');
Route::post('/subscribe', [App\Http\Controllers\Admin\SubscriptionController::class, 'storeFromFront'])->name('subscribe');
Route::get('/unsubscribe/{email}', [App\Http\Controllers\Admin\SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
Route::post('/trelloCallback', [App\Http\Controllers\Admin\TrelloController::class, 'trelloCallback'])->name('trelloCallback');
Route::match(['head'], '/trelloCallback', [App\Http\Controllers\Admin\TrelloController::class, 'handleHead']);

Route::get('/invoice/{id}', [App\Http\Controllers\Front\PageController::class, 'invoice'])->name('invoice');

// Auth
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('profile.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Search
Route::post('/search', [App\Http\Controllers\Front\PageController::class, 'search'])->name('search');
Route::post('/search', [App\Http\Controllers\Front\PageController::class, 'search'])->name('search');

Route::get('/category/{id}', [App\Http\Controllers\Front\CategoryController::class, 'index'])->name('category');
Route::get('/product/{slug}', [App\Http\Controllers\Front\ProductController::class, 'index'])->name('product');
Route::get('/product/download', [App\Http\Controllers\Front\ProductController::class, 'downloadTemplate'])->name('download_template');
//file upload
Route::post('/tmp-upload', [App\Http\Controllers\Front\UploadController::class, 'tmpUpload'])->name('tmp_upload');
Route::post('/tmp-preview', [App\Http\Controllers\Front\UploadController::class, 'tmpPreview'])->name('tmp-preview');
Route::delete('/tmp-delete', [App\Http\Controllers\Front\UploadController::class, 'tmpDelete'])->name('tmp_delete');

Route::post('question/store', [App\Http\Controllers\Front\QuestionController::class, 'store'])->name('question_store');
Route::post('/order/{invoice?}', [App\Http\Controllers\Front\OrderController::class, 'index'])->name('order');
Route::get('/pay-order/{invoice?}', [App\Http\Controllers\Front\OrderController::class, 'pay_order'])->name('pay-order');

Route::post('/upload-image', [App\Http\Controllers\Front\OrderController::class, 'upload'])->name('upload_images');
Route::delete('/delete-image/{fileId}', [App\Http\Controllers\Front\OrderController::class, 'deleteImages'])->name('delete_images');
Route::post('/create-order', [App\Http\Controllers\Front\OrderController::class, 'create_order'])->name('create_order');
Route::post('/create-custom-order', [App\Http\Controllers\Front\OrderController::class, 'create_custom_order'])->name('create_custom_order');
Route::post('/order-login', [App\Http\Controllers\Front\OrderController::class, 'login'])->name('order_login');
Route::post('/order-register', [App\Http\Controllers\Front\OrderController::class, 'register'])->name('order_register');
Route::post('/order-add-address', [App\Http\Controllers\Front\OrderController::class, 'add_address'])->name('add_address');
Route::post('/check-coupon', [App\Http\Controllers\Front\OrderController::class, 'coupon'])->name('coupon');
Route::post('/check-zip', [App\Http\Controllers\Front\OrderController::class, 'check_zip'])->name('check_zip');

// Payments
Route::get('process-transaction', [App\Http\Controllers\Front\PaymentController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [App\Http\Controllers\Front\PaymentController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [App\Http\Controllers\Front\PaymentController::class, 'cancelTransaction'])->name('cancelTransaction');
Route::get('cancel-order', [App\Http\Controllers\Front\PaymentController::class, 'cancel_page'])->name('cancel_order');
Route::get('error-order', [App\Http\Controllers\Front\PaymentController::class, 'error_page'])->name('error_order');
Route::get('success-order', [App\Http\Controllers\Front\PaymentController::class, 'success_order'])->name('success_order');

// Attribute helper text
Route::get('/help-text/{id}',  [App\Http\Controllers\Front\ProductController::class, 'getAttributeHelperText']);

//Get uploaded file type by selected type
Route::post('/get-uploaded-file-type',  [App\Http\Controllers\Front\ProductController::class, 'getUploadedFileTypesBySelectedType']);


//Stripe Terminal
Route::post('/stripe/webhook', [App\Http\Controllers\Front\StripeTerminalController::class, 'handleWebhook']);
Route::post('/check_order_status', [App\Http\Controllers\Front\OrderController::class, 'checkStatus'])->name('check_order_status');

//basket
Route::group(['prefix' => 'basket', 'as'=>'basket.', 'middleware' => ['modal.handler']], function () {
    Route::get('/index', [App\Http\Controllers\Front\BasketsController::class, 'index'])->name('index');
    Route::post('/addItem', [App\Http\Controllers\Front\BasketsController::class, 'addItem'])->name('addItem');
    Route::post('/editItem', [App\Http\Controllers\Front\BasketsController::class, 'editItem'])->name('editItem');
    Route::post('/updateItem/{project}', [App\Http\Controllers\Front\BasketsController::class, 'updateItem'])->name('updateItem');
    Route::get('/copyItem/{project}', [App\Http\Controllers\Front\BasketsController::class, 'copyItem'])->name('copyItem');
    Route::get('/removeItem/{project}', [App\Http\Controllers\Front\BasketsController::class, 'removeItem'])->name('removeItem');
    Route::post('/add-design', [App\Http\Controllers\Front\BasketsController::class, 'addDesign'])->name('addDesignApparel');
});

//Shipping
Route::group(['as'=>'order_shipping.', 'middleware' => ['auth', 'verified', 'modal.handler']], function () {
    Route::post('/shipping', [App\Http\Controllers\Front\ShippingController::class, 'shipping_index'])->name('shipping');
    Route::post('/shipping/calculation', [App\Http\Controllers\Front\ShippingController::class, 'shipping_calculation_form_view'])->name('shipping_calculation');
    Route::post('/payment', [App\Http\Controllers\Front\ShippingController::class, 'show_payment_form'])->name('show_payment_form');
});

// Profile
Route::group(['prefix' => 'profile', 'as'=>'profile.' ,'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [App\Http\Controllers\Front\ProfileController::class, 'index'])->name('index');
    Route::post('/update-profile', [App\Http\Controllers\Front\ProfileController::class, 'update_profile'])->name('update_profile');
    Route::post('/change-password', [App\Http\Controllers\Front\ProfileController::class, 'change_password'])->name('change_password');

    Route::get('/orders', [App\Http\Controllers\Front\ProfileController::class, 'orders'])->name('orders');
    Route::get('/requests', [App\Http\Controllers\Front\ProfileController::class, 'requests'])->name('requests');
    Route::get('/payments', [App\Http\Controllers\Front\ProfileController::class, 'payments'])->name('payments');
    Route::post('/card/delete', [App\Http\Controllers\Front\PaymentController::class, 'delete_card'])->name('delete_card');
    Route::post('/card/update-default-card', [App\Http\Controllers\Front\PaymentController::class, 'default_card'])->name('default_card');
    Route::post('/card/store', [App\Http\Controllers\Front\PaymentController::class, 'store_card'])->name('store_card');

    Route::get('/addresses', [App\Http\Controllers\Front\ProfileController::class, 'addresses'])->name('addresses');
    Route::get('/addresses/add', [App\Http\Controllers\Front\ProfileController::class, 'add_address'])->name('add_address');
    Route::post('/addresses/create', [App\Http\Controllers\Front\ProfileController::class, 'create_address'])->name('create_address');
    Route::get('/addresses/edit/{id}', [App\Http\Controllers\Front\ProfileController::class, 'edit_address'])->name('edit_address');
    Route::post('/addresses/update/{id}', [App\Http\Controllers\Front\ProfileController::class, 'update_address'])->name('update_address');
    Route::get('/addresses/delete/{id}', [App\Http\Controllers\Front\ProfileController::class, 'delete_address'])->name('delete_address');
    Route::get('/addresses/default/{id}', [App\Http\Controllers\Front\ProfileController::class, 'set_default_address'])->name('set_default_address');
});


/**
 * Admin
 */
Auth::routes();
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('modal.handler');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->middleware('modal.handler');

Route::get('/dashboard-login', [App\Http\Controllers\Admin\DashboardController::class, 'login']);
Route::post('/dashboard-login', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard_login'])->name('dashboard_login');

Route::group([
    'as' => 'dashboard.',
    'prefix' => 'dashboard',
    'namespace' => 'Admin',
    'middleware' => ['admin']
], function () {

    Route::get('/', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('index');
//    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');

    // Categories
    Route::group([
        'as' => 'users.',
        'prefix' => 'users'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\UserController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('delete');
    });

    // Categories
    Route::group([
        'as' => 'categories.',
        'prefix' => 'categories'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
        Route::get('/subcategories', [App\Http\Controllers\Admin\CategoryController::class, 'subcategories'])->name('subcategories');
        Route::get('/add', [App\Http\Controllers\Admin\CategoryController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('delete');
    });
    Route::group([
        'as' => 'reports.',
        'prefix' => 'reports'
    ], function () {
        Route::get('/monthly', [App\Http\Controllers\Admin\ReportsController::class, 'monthly'])->name('monthly');
        Route::get('/monthly-tax', [App\Http\Controllers\Admin\ReportsController::class, 'monthlyTax'])->name('monthly_tax');
        Route::get('/top-products', [App\Http\Controllers\Admin\ReportsController::class, 'topProducts'])->name('top-products');
        Route::get('/top-categories', [App\Http\Controllers\Admin\ReportsController::class, 'topCategories'])->name('top-categories');

    });
    // Quantities
    Route::group([
        'as' => 'quantities.',
        'prefix' => 'quantities'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\QuantityController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\QuantityController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\QuantityController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\QuantityController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\QuantityController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\QuantityController::class, 'delete'])->name('delete');
    });

    // Attributes
    Route::group([
        'as' => 'attributes.',
        'prefix' => 'attributes'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\AttributeController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\AttributeController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\AttributeController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'delete'])->name('delete');
    });

    // Types
    Route::group([
        'as' => 'types.',
        'prefix' => 'types'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\TypeController::class, 'index'])->name('index');
        Route::get('/single/{id}', [App\Http\Controllers\Admin\TypeController::class, 'single'])->name('single');
        Route::get('/add', [App\Http\Controllers\Admin\TypeController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\TypeController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\TypeController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\TypeController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\TypeController::class, 'delete'])->name('delete');

        //product image
        Route::post('/product-images-by-type/{id}', [App\Http\Controllers\Admin\TypeController::class, 'storeProductImagesByType'])->name('storeProductImagesByType');
    });

    // Sizes
    Route::group([
        'as' => 'sizes.',
        'prefix' => 'sizes'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\SizeController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\SizeController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\SizeController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\SizeController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\SizeController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\SizeController::class, 'delete'])->name('delete');
    });

    // Grommets
    Route::group([
        'as' => 'grommets.',
        'prefix' => 'grommets'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\GrommetController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\GrommetController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\GrommetController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\GrommetController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\GrommetController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\GrommetController::class, 'delete'])->name('delete');
    });

    // Coupons
    Route::group([
        'as' => 'coupons.',
        'prefix' => 'coupons'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\CouponController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\CouponController::class, 'delete'])->name('delete');
    });

    // Products
    Route::group([
        'as' => 'products.',
        'prefix' => 'products'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
        Route::get('/single/{id}', [App\Http\Controllers\Admin\ProductController::class, 'single'])->name('single');
        Route::get('/add', [App\Http\Controllers\Admin\ProductController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('delete');
        Route::post('/upload', [App\Http\Controllers\Admin\ProductController::class, 'image_upload'])->name('upload');
        Route::post('/change-order', [App\Http\Controllers\Admin\ProductController::class, 'change_order'])->name('change_order');
        Route::get('/attrs/{id}', [App\Http\Controllers\Admin\ProductController::class, 'attrs'])->name('attrs');
        Route::post('/editAttrs/{id}', [App\Http\Controllers\Admin\ProductController::class, 'editAttrs'])->name('editAttrs');
        Route::post('/mark-attribute-opened/{id}', [App\Http\Controllers\Admin\ProductController::class, 'setAttributeAsOpened'])->name('setAttributeAsOpened');
        Route::get('/rel-attrs/{id}', [App\Http\Controllers\Admin\ProductController::class, 'relAttrs'])->name('rel_attrs');
        Route::post('/edit-shipping-sizes/{id}', [App\Http\Controllers\Admin\ProductController::class, 'editShippingSizes'])->name('edit_shipping_sizes');
        Route::post('/delete-shipping-sizes', [App\Http\Controllers\Admin\ProductController::class, 'deleteShippingSizes'])->name('delete_shipping_sizes');
        Route::post('/delete-image', [App\Http\Controllers\Admin\ProductController::class, 'image_delete'])->name('delete_image');
        // production time
        Route::get('/production-time', [App\Http\Controllers\Admin\ProductController::class, 'productionTimeIndex'])->name('production_time');
        Route::get('/get-production-time', [App\Http\Controllers\Admin\ProductController::class, 'getProductionTime'])->name('get_production_time');
        Route::post('/production-time-store', [App\Http\Controllers\Admin\ProductController::class, 'productionTimeStore'])->name('production_time_store');
        // templates
        Route::get('/product-templates', [App\Http\Controllers\Admin\ProductController::class, 'productTemplates'])->name('templates');
        Route::get('/get-product-templates', [App\Http\Controllers\Admin\ProductController::class, 'getProductTemplates'])->name('get_templates');
        Route::post('/product-templates-store', [App\Http\Controllers\Admin\ProductController::class, 'ProductTemplatesStore'])->name('templates_store');


    });

    // Orders
    Route::group([
        'as' => 'orders.',
        'prefix' => 'orders'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\OrderController::class, 'add'])->name('add');
        Route::get('/custom_order', [App\Http\Controllers\Admin\OrderController::class, 'custom_order'])->name('custom_order');
        Route::get('/edit-request/{id}', [App\Http\Controllers\Admin\OrderController::class, 'edit_request'])->name('edit-request');

       Route::post('/update_price/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update_price'])->name('update_price');
        Route::get('/decline/{id}', [App\Http\Controllers\Admin\OrderController::class, 'decline'])->name('decline');
        Route::post('/decline-order', [App\Http\Controllers\Admin\OrderController::class, 'decline_order'])->name('decline-order');
        Route::post('/decline-and-refund-order', [App\Http\Controllers\Admin\OrderController::class, 'decline_and_refund_order'])->name('decline-refund-order');

        Route::get('/edit/{id}', [App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('store');
        Route::get('/make-order', [App\Http\Controllers\Admin\OrderController::class, 'createOrder'])->name('create_order');
        Route::post('/make-order', [App\Http\Controllers\Admin\OrderController::class, 'makeOrder'])->name('make_order');
        Route::get('/attribute-types', [App\Http\Controllers\Admin\OrderController::class, 'getTypes'])->name('types');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\OrderController::class, 'delete'])->name('delete');
        Route::post('/delete-images', [App\Http\Controllers\Admin\OrderController::class, 'delete_images'])->name('delete_images');
        Route::get('/invoice/{id}', [App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('invoice');
        Route::get('/generate-invoice/{id}', [App\Http\Controllers\Admin\OrderController::class, 'generate_invoice'])->name('generate_invoice');

        Route::get('/download/{filename}', [App\Http\Controllers\Admin\OrderController::class, 'downloadFile'])->name('download');

        Route::post('/upload-proof/{id}', [App\Http\Controllers\Admin\OrderController::class, 'uploadProof'])->name('upload_proof');
        Route::delete('/delete-proof/{id}', [App\Http\Controllers\Admin\OrderController::class, 'deleteProof'])->name('delete_proof');
        Route::post('/send-proof/{id}', [App\Http\Controllers\Admin\OrderController::class, 'sendProof'])->name('send_proof_email');

        Route::get('/new', [App\Http\Controllers\Admin\OrderController::class, 'getNewOrders'])->name('get_new_orders');

        Route::post('/cancel-terminal-payment', [\App\Http\Controllers\Front\StripeTerminalController::class, 'cancelPaymentIntent'])->name('cancel_terminal_payment');
    });

    // Settings
    Route::group([
        'as' => 'settings.',
        'prefix' => 'settings'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\SettingController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\SettingController::class, 'delete'])->name('delete');
    });

    // Header alerts
    Route::group([
        'as' => 'alerts.',
        'prefix' => 'alerts'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\AlertsController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\AlertsController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\AlertsController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\AlertsController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\AlertsController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\AlertsController::class, 'delete'])->name('delete');
    });

    // Homepage
    Route::group([
        'as' => 'sliders.',
        'prefix' => 'sliders'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\SliderController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\SliderController::class, 'delete'])->name('delete');
    });

    Route::group([
        'as' => 'services.',
        'prefix' => 'services'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\ServiceController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('store');
        Route::post('/import', [App\Http\Controllers\Admin\ServiceController::class, 'import'])->name('import');

        Route::post('/update/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'delete'])->name('delete');
    });

    Route::group([
        'as' => 'banners.',
        'prefix' => 'banners'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\BannerController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\BannerController::class, 'delete'])->name('delete');
        Route::post('/image_delete', [App\Http\Controllers\Admin\BannerController::class, 'image_delete'])->name('image_delete');
    });

    Route::group([
        'as' => 'reviews.',
        'prefix' => 'reviews'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\ReviewController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\ReviewController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'delete'])->name('delete');
    });

    Route::group([
        'as' => 'subscriptions.',
        'prefix' => 'subscriptions'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\SubscriptionController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'edit'])->name('edit');
        Route::post('/store', [App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'delete'])->name('delete');
    });

    Route::group([
        'as' => 'questions.',
        'prefix' => 'questions'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\QuestionController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\QuestionController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\QuestionController::class, 'edit'])->name('edit');
        Route::get('/answer/{id}', [App\Http\Controllers\Admin\QuestionController::class, 'answer'])->name('answer');
        Route::post('/answer/{id}', [App\Http\Controllers\Admin\QuestionController::class, 'sendAnswer'])->name('sendAnswer');
        Route::post('/store', [App\Http\Controllers\Admin\QuestionController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\QuestionController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\QuestionController::class, 'delete'])->name('delete');
    });

    Route::group([
        'as' => 'partners.',
        'prefix' => 'partners'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\PartnersController::class, 'index'])->name('index');
        Route::post('/upload', [App\Http\Controllers\Admin\PartnersController::class, 'image_upload'])->name('upload');
        Route::post('/delete', [App\Http\Controllers\Admin\PartnersController::class, 'image_delete'])->name('delete');
    });

    Route::group([
        'as' => 'uploadedFileTypes.',
        'prefix' => 'uploadedFileTypes'
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\UploadedFileTypesController::class, 'index'])->name('index');
        Route::get('/add', [App\Http\Controllers\Admin\UploadedFileTypesController::class, 'add'])->name('add');
        Route::post('/store', [App\Http\Controllers\Admin\UploadedFileTypesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\UploadedFileTypesController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\UploadedFileTypesController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [App\Http\Controllers\Admin\UploadedFileTypesController::class, 'delete'])->name('delete');
    });

    Route::post('/send-email/', [App\Http\Controllers\Admin\SubscriptionController::class, 'sendEmail'])->name('send_email');

});

Route::get('order-email', function () {
    return view('emails.order');
});


Route::get('optimize', function () {

    Artisan::call('optimize:clear');

    dd("Cache is cleared");

});
