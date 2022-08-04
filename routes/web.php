<?php


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

require __DIR__.'/admin.php';

Route::localized(function () {
    Route::get('/', [App\Http\Controllers\PageController::class, 'home'])->name('home');
    Route::get('kontakt', [App\Http\Controllers\PageController::class, 'contact'])->name('contact');

    Route::get('objekte/{path}/{alias}.html', [App\Http\Controllers\ApartmentController::class, 'show'])
        ->where('path', '.*')
        ->name('apartment.show');

    Route::get('objekte/{path?}', [App\Http\Controllers\ApartmentController::class, 'index'])
        ->where('path', '.*')
        ->name('apartment.index');

    Route::get('blog/{category}/{alias}.html', [App\Http\Controllers\BlogController::class, 'show'])
        ->name('blog.show');

    Route::get('referenzen', [App\Http\Controllers\ApartmentController::class, 'references'])
        ->name('apartment.apartments.references');

    Route::paginate('blog/{category?}', [App\Http\Controllers\BlogController::class, 'index'])
        ->name('blog.index');
});
