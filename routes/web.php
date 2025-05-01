<?php

declare(strict_types=1);

use App\Livewire\Admin\Users\Index as AdminIndexUser;
use App\Livewire\Public\Catalog\Index as PublicIndexCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicIndexCatalog::class)->name('home.index');

// TODO: Add admin auth middleware.
Route::group(['middleware' => 'role:super_admin|admin'], function () {
    Route::get('admin/users', AdminIndexUser::class)->name('admin.users.index');
    Route::get('admin/users/create', function () {
        return 'admin.users.create';
    })->name('admin.users.create');
    Route::get('admin/users/{user}', function () {
        return 'admin.users.show';
    })->name('admin.users.show');
    Route::get('admin/users/{user}/edit', function () {
        return 'admin.users.edit';
    })->name('admin.users.edit');
});

// NOTE: Auth routes.
Route::view('/auth/register', 'auth.register')->name('auth.register');
