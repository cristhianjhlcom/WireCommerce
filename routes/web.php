<?php

declare(strict_types=1);

use App\Livewire\Admin\Users\Index as AdminIndexUser;
use App\Livewire\Public\Catalog\Index as PublicIndexCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicIndexCatalog::class)->name('home.index');

// TODO: Add admin auth middleware.
Route::group(['middleware' => 'role:super_admin|admin'], function () {
    Route::get('admin/users', AdminIndexUser::class)->name('admin.users.index');
});

// NOTE: Auth routes.
Route::view('/auth/register', 'auth.register')->name('auth.register');
