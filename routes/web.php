<?php

declare(strict_types=1);

use App\Livewire\Admin\Users\Create as AdminCreateUser;
use App\Livewire\Admin\Users\Edit as AdminEditUser;
use App\Livewire\Admin\Users\Index as AdminIndexUser;
use App\Livewire\Admin\Users\Show as AdminShowUser;
use App\Livewire\Public\Catalog\Index as PublicIndexCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicIndexCatalog::class)->name('home.index');

Route::group(['middleware' => 'role:super_admin|manager'], function () {
    // NOTE: Users Management.
    Route::get('admin/users', AdminIndexUser::class)->name('admin.users.index');
    Route::get('admin/users/create', AdminCreateUser::class)->name('admin.users.create');
    Route::get('admin/users/{user}', AdminShowUser::class)->name('admin.users.show');
    Route::get('admin/users/{user}/edit', AdminEditUser::class)->name('admin.users.edit');
});

// NOTE: Auth routes.
Route::view('/auth/register', 'auth.register')->name('auth.register');
