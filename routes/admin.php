<?php

use Illuminate\Support\Facades\{
    Route,
    Artisan
};
use App\Http\Controllers\Admin\{
    AdminController,
    CurrencyController,
    MenuController,
    MenuFieldController,
    PaymentMethodController,
    PaymentModeController,
    PaymentTypeController,
    PermissionController,
    RoleController,
    SettingController,
    UserController
};
use App\Http\Controllers\DeveloperController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//developer
Route::controller(DeveloperController::class)->group(function () {
    Route::get('/getCountries', 'getCountries');
    Route::get('/getStates', 'getStates');
    Route::get('/getCities', 'getCities');
});

//developer

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/cache', function() {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    $cache = 'Route cache cleared <br /> View cache cleared <br /> Cache cleared <br /> Config cleared <br /> Config cache cleared';
    return $cache;
});

Route::controller(AdminController::class)->group(function () {
    Route::get('admin/login', 'loginForm')->name('admin.login');
    Route::post('admin/login', 'login')->name('admin.login');
    Route::get('/get-states', 'getStates')->name('get-states');
    Route::get('/get-cities', 'getCities')->name('get-cities');
    //API DOCS
    Route::get('/api_docs', 'apiDocs')->name('api_docs.index');
});

Route::middleware('auth')->group(function () {
Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/logout', 'logOut')->name('user.logout');
    });
    
    Route::controller(CurrencyController::class)->group(function () {
        Route::get('currencies/trashed', 'trashed')->name('currencies.trashed');
        Route::get('currencies/restore/{id}', 'restore')->name('currencies.restore');
    });
    
    Route::controller(PaymentMethodController::class)->group(function () {
        Route::get('payment_methods/trashed', 'trashed')->name('payment_methods.trashed');
        Route::get('payment_methods/restore/{id}', 'restore')->name('payment_methods.restore');
    });
    
    Route::controller(PaymentModeController::class)->group(function () {
        Route::get('payment_modes/trashed', 'trashed')->name('payment_modes.trashed');
        Route::get('payment_modes/restore/{id}', 'restore')->name('payment_modes.restore');
    });
    Route::controller(PaymentTypeController::class)->group(function () {
        Route::get('payment_types/trashed', 'trashed')->name('payment_types.trashed');
        Route::get('payment_types/restore/{id}', 'restore')->name('payment_types.restore');
    });
    
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('trashed', 'trashed')->name('users.trashed');
        Route::get('restore/{id}', 'restore')->name('users.restore');
    });  

    //Resource Routes.
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('menu_fields', MenuFieldController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('payment_methods', PaymentMethodController::class);
    Route::resource('payment_modes', PaymentModeController::class);
    Route::resource('payment_types', PaymentTypeController::class);
    Route::resource('users', UserController::class);
});