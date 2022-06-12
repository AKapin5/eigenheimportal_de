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

use App\Http\Controllers\DefaultController;

require __DIR__.'/admin.php';

Route::localized(function () {
    require __DIR__ . '/auth.php';

    Route::paginate('/', [DefaultController::class, 'home'])
        ->name('home');
});

