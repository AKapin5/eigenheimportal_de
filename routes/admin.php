<?php

use App\Http\Controllers\Admin\ApartmentCategoryController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('admin.urlPrefix'),
    'as' => 'admin.',
], function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create']);

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    Route::group(['prefix' => 'fm', 'middleware' => ['auth.admin']], function () {
        UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::group(['middleware' => ['auth.admin']], function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        /** Files */
        Route::post('/files/remove', [FileController::class, 'remove'])
            ->name('files.remove');
        Route::post('/files/sort', [FileController::class, 'sort'])
            ->name('files.sort');

        /** Users */
        Route::match(['GET', 'POST'], '/users/search',
            [UserController::class, 'search'])
            ->name('users.search');
        Route::resource('users', UserController::class);

        /** Pages */
        Route::match(['GET', 'POST'], '/pages/search',
            [PageController::class, 'search'])
            ->name('pages.search');
        Route::resource('pages', PageController::class);

        /** Menus */
        Route::match(['GET', 'POST'], '/menus/search',
            [MenuController::class, 'search'])
            ->name('menus.search');
        Route::resource('menus', MenuController::class);

        /** Apartment categories */
        Route::match(['GET', 'POST'], '/apartment-categories/search',
            [ApartmentCategoryController::class, 'search'])
            ->name('apartment-categories.search');
        Route::resource('apartment-categories', ApartmentCategoryController::class);

        /** Apartment items */
        Route::match(['GET', 'POST'], '/apartments/search',
            [ApartmentController::class, 'search'])
            ->name('apartments.search');
        Route::resource('apartments', ApartmentController::class);
    });
});
