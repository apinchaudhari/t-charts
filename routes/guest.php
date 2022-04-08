<?php

use Illuminate\Support\Facades\Route;

/**
 * 'guest' middleware applied to all routes
 *
 * @see \App\Providers\Route::mapGuestRoutes
 * @see \modules\PaypalStandard\Routes\guest.php for module example
 */

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'Auth\Login@create')->name('login');
    Route::post('login', 'Auth\Login@store');

    Route::get('forgot', 'Auth\Forgot@create')->name('forgot');
    Route::post('forgot', 'Auth\Forgot@store');

    //Route::get('reset', 'Auth\Reset@create');
    Route::get('reset/{token}', 'Auth\Reset@create')->name('reset');
    Route::post('reset', 'Auth\Reset@store')->name('reset.store');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('superadmin/auth', function () {
    return redirect()->route('superlogin');
});

Route::group(['prefix' => 'superadmin/auth'], function () {
    Route::get('login', 'Superadmin\Auth\Login@create')->name('superlogin');
    Route::post('login', 'Superadmin\Auth\Login@store');

    Route::get('forgot', 'Superadmin\Auth\Forgot@create')->name('superforgot');
    Route::post('forgot', 'Superadmin\Auth\Forgot@store');

    //Route::get('reset', 'Auth\Reset@create');
    Route::get('reset/{token}', 'Superadmin\Auth\Reset@create')->name('superreset');
    Route::post('reset', 'Superadmin\Auth\Reset@store')->name('reset.store');
});
