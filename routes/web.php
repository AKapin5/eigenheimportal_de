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


use App\Http\Controllers\HomeController;

require __DIR__.'/admin.php';

Route::localized(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    foreach (['blog', 'condominium', 'contact', 'credentials', 'product', 'question'] as $page) {
        Route::get("$page.html", function () use ($page) {
            return view("pages.$page");
        });
    }
});
