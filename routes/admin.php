<?php

Route::group([
    'prefix' => config('admin.urlPrefix'),
    'as' => 'admin.',
], function () {
    /** Auth */
    Route::get('login', App\Http\Livewire\Admin\Auth\Login::class)->name('login');
    Route::post('logout', App\Http\Livewire\Admin\Auth\Logout::class)->name('logout');

    /** UniSharp file manager */
    Route::group(['prefix' => 'fm', 'middleware' => ['auth.admin']], function () {
        UniSharp\LaravelFilemanager\Lfm::routes();
    });

    /** Files */
    Route::post('/files/remove', [App\Http\Controllers\Admin\FileController::class, 'remove'])
        ->name('files.remove');
    Route::post('/files/sort', [App\Http\Controllers\Admin\FileController::class, 'sort'])
        ->name('files.sort');

    Route::group(['middleware' => ['auth.admin']], function () {
        Route::get('/', App\Http\Livewire\Admin\Dashboard::class)->name('dashboard');

        /** Pages */
        Route::get('pages', App\Http\Livewire\Admin\Page\Index::class)->name('pages.index');
        Route::get('pages/create', App\Http\Livewire\Admin\Page\Form::class)->name('pages.create');
        Route::get('pages/{page}/edit', App\Http\Livewire\Admin\Page\Form::class)->name('pages.edit');

        /** Users */
        Route::get('users', App\Http\Livewire\Admin\User\Index::class)->name('users.index');
        Route::get('users/create', App\Http\Livewire\Admin\User\Form::class)->name('users.create');
        Route::get('users/{user}/edit', App\Http\Livewire\Admin\User\Form::class)->name('users.edit');

        /** Apartment categories */
        Route::get('apartment-categories', App\Http\Livewire\Admin\ApartmentCategory\Index::class)->name('apartment-categories.index');
        Route::get('apartment-categories/create', App\Http\Livewire\Admin\ApartmentCategory\Form::class)->name('apartment-categories.create');
        Route::get('apartment-categories/{apartmentCategory}/edit', App\Http\Livewire\Admin\ApartmentCategory\Form::class)->name('apartment-categories.edit');

        /** Apartments */
        Route::get('apartments', App\Http\Livewire\Admin\Apartment\Index::class)->name('apartments.index');
        Route::get('apartments/create', App\Http\Livewire\Admin\Apartment\Form::class)->name('apartments.create');
        Route::get('apartments/{apartment}/edit', App\Http\Livewire\Admin\Apartment\Form::class)->name('apartments.edit');

        /** Blog categories */
        Route::get('blog-categories', App\Http\Livewire\Admin\BlogCategory\Index::class)->name('blog-categories.index');
        Route::get('blog-categories/create', App\Http\Livewire\Admin\BlogCategory\Form::class)->name('blog-categories.create');
        Route::get('blog-categories/{blogCategory}/edit', App\Http\Livewire\Admin\BlogCategory\Form::class)->name('blog-categories.edit');

        /** Apartments */
        Route::get('blogs', App\Http\Livewire\Admin\Blog\Index::class)->name('blogs.index');
        Route::get('blogs/create', App\Http\Livewire\Admin\Blog\Form::class)->name('blogs.create');
        Route::get('blogs/{blog}/edit', App\Http\Livewire\Admin\Blog\Form::class)->name('blogs.edit');

        /** Menus */
        Route::get('menus', App\Http\Livewire\Admin\Menu\Index::class)->name('menus.index');
        Route::get('menus/create', App\Http\Livewire\Admin\Menu\Form::class)->name('menus.create');
        Route::get('menus/{menu}/edit', App\Http\Livewire\Admin\Menu\Form::class)->name('menus.edit');

        /** Feedback */
        Route::get('feedback', App\Http\Livewire\Admin\Feedback\Index::class)->name('feedback.index');
    });
});
