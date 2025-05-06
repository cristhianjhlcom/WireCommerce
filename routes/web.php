<?php

declare(strict_types=1);

use App\Livewire\Admin\Categories\CategoryCreateManagement;
use App\Livewire\Admin\Categories\CategoryEditManagement;
use App\Livewire\Admin\Categories\CategoryIndexManagement;
use App\Livewire\Admin\Colors\ColorCreateManagement;
use App\Livewire\Admin\Colors\ColorEditManagement;
use App\Livewire\Admin\Colors\ColorIndexManagement;
use App\Livewire\Admin\Sizes\SizeCreateManagement;
use App\Livewire\Admin\Sizes\SizeEditManagement;
use App\Livewire\Admin\Sizes\SizeIndexManagement;
use App\Livewire\Admin\Tags\TagCreateManagement;
use App\Livewire\Admin\Tags\TagEditManagement;
use App\Livewire\Admin\Tags\TagIndexManagement;
use App\Livewire\Admin\Users\UserCreateManagement;
use App\Livewire\Admin\Users\UserEditManagement;
use App\Livewire\Admin\Users\UserIndexManagement;
use App\Livewire\Public\Catalog\Index as PublicIndexCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicIndexCatalog::class)->name('home.index');

Route::group(['middleware' => 'role:super_admin|manager'], function () {
    // NOTE: Users Management.
    Route::get('admin/users', UserIndexManagement::class)->name('admin.users.index');
    Route::get('admin/users/create', UserCreateManagement::class)->name('admin.users.create');
    Route::get('admin/users/{user}/edit', UserEditManagement::class)->name('admin.users.edit');
    // NOTE: Categories Management.
    Route::get('admin/categories', CategoryIndexManagement::class)->name('admin.categories.index');
    Route::get('admin/categories/create', CategoryCreateManagement::class)->name('admin.categories.create');
    Route::get('admin/categories/{category}/edit', CategoryEditManagement::class)->name('admin.categories.edit');
    // NOTE: Tags Management.
    Route::get('admin/tags', TagIndexManagement::class)->name('admin.tags.index');
    Route::get('admin/tags/create', TagCreateManagement::class)->name('admin.tags.create');
    Route::get('admin/tags/{tag}/edit', TagEditManagement::class)->name('admin.tags.edit');
    // NOTE: Colors Management.
    Route::get('admin/colors', ColorIndexManagement::class)->name('admin.colors.index');
    Route::get('admin/colors/create', ColorCreateManagement::class)->name('admin.colors.create');
    Route::get('admin/colors/{color}/edit', ColorEditManagement::class)->name('admin.colors.edit');
    // NOTE: Sizes Management.
    Route::get('admin/sizes', SizeIndexManagement::class)->name('admin.sizes.index');
    Route::get('admin/sizes/create', SizeCreateManagement::class)->name('admin.sizes.create');
    Route::get('admin/sizes/{size}/edit', SizeEditManagement::class)->name('admin.sizes.edit');
});

/*
// NOTE: Auth routes (For now auth is handle by Fortify)
Route::view('/auth/register', 'auth.register')->name('auth.register');
Route::view('/auth/login', 'auth.login')->name('auth.login');
*/
