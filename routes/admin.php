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
        Route::delete('pages/{page}/destroy', App\Http\Livewire\Admin\Page\Delete::class)->name('pages.destroy');

        /** Users */
        Route::get('users', App\Http\Livewire\Admin\User\Index::class)->name('users.index');
        Route::get('users/create', App\Http\Livewire\Admin\User\Form::class)->name('users.create');
        Route::get('users/{user}/edit', App\Http\Livewire\Admin\User\Form::class)->name('users.edit');
        Route::delete('users/{user}/destroy', App\Http\Livewire\Admin\User\Delete::class)->name('users.destroy');

        /** Apartment categories */
        Route::get('apartment-categories', App\Http\Livewire\Admin\ApartmentCategory\Index::class)->name('apartment-categories.index');
        Route::get('apartment-categories/create', App\Http\Livewire\Admin\ApartmentCategory\Form::class)->name('apartment-categories.create');
        Route::get('apartment-categories/{apartmentCategory}/edit', App\Http\Livewire\Admin\ApartmentCategory\Form::class)->name('apartment-categories.edit');
        Route::delete('apartment-categories/{apartmentCategory}/destroy', App\Http\Livewire\Admin\ApartmentCategory\Delete::class)->name('apartment-categories.destroy');

        /** Apartments */
        Route::get('apartments', App\Http\Livewire\Admin\Apartment\Index::class)->name('apartments.index');
        Route::get('apartments/create', App\Http\Livewire\Admin\Apartment\Form::class)->name('apartments.create');
        Route::get('apartments/{apartment}/edit', App\Http\Livewire\Admin\Apartment\Form::class)->name('apartments.edit');
        Route::delete('apartments/{apartment}/destroy', App\Http\Livewire\Admin\Apartment\Delete::class)->name('apartments.destroy');

        /** Blog categories */
        Route::get('blog-categories', App\Http\Livewire\Admin\BlogCategory\Index::class)->name('blog-categories.index');
        Route::get('blog-categories/create', App\Http\Livewire\Admin\BlogCategory\Form::class)->name('blog-categories.create');
        Route::get('blog-categories/{blogCategory}/edit', App\Http\Livewire\Admin\BlogCategory\Form::class)->name('blog-categories.edit');
        Route::delete('blog-categories/{blogCategory}/destroy', App\Http\Livewire\Admin\BlogCategory\Delete::class)->name('blog-categories.destroy');

        /** Apartments */
        Route::get('blogs', App\Http\Livewire\Admin\Blog\Index::class)->name('blogs.index');
        Route::get('blogs/create', App\Http\Livewire\Admin\Blog\Form::class)->name('blogs.create');
        Route::get('blogs/{blog}/edit', App\Http\Livewire\Admin\Blog\Form::class)->name('blogs.edit');
        Route::delete('blogs/{blog}/destroy', App\Http\Livewire\Admin\Blog\Delete::class)->name('blogs.destroy');

        /** Menus */
        Route::get('menus', App\Http\Livewire\Admin\Menu\Index::class)->name('menus.index');
        Route::get('menus/create', App\Http\Livewire\Admin\Menu\Form::class)->name('menus.create');
        Route::get('menus/{menu}/edit', App\Http\Livewire\Admin\Menu\Form::class)->name('menus.edit');
        Route::delete('menus/{menu}/destroy', App\Http\Livewire\Admin\Menu\Delete::class)->name('menus.destroy');

        /** Feedback */
        Route::get('feedback', App\Http\Livewire\Admin\Feedback\Index::class)->name('feedback.index');
        Route::delete('feedback/{feedback}/destroy', App\Http\Livewire\Admin\Feedback\Delete::class)->name('feedback.destroy');
    });
});
