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


use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;

require __DIR__.'/admin.php';

Route::localized(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    foreach (['blog', 'contact', 'product', 'question'] as $page) {
        Route::get("$page.html", function () use ($page) {
            return view("pages.$page");
        });
    }

    Route::get('objects/{path}/{alias}.html', [ApartmentController::class, 'show'])
        ->where('path', '.*')
        ->name('apartment.show');

    Route::get('objects/{path?}', [ApartmentController::class, 'index'])
        ->where('path', '.*')
        ->name('apartment.index');

    Route::get('blog/{category}/{alias}.html', [BlogController::class, 'show'])
        ->name('blog.show');

    Route::paginate('blog/{category?}', [BlogController::class, 'index'])
        ->name('blog.index');
});
