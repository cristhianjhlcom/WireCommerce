<?php

declare(strict_types=1);

use App\Livewire\Admin\Users\Index as AdminIndexUser;
use App\Livewire\Public\Catalog\Index as PublicIndexCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicIndexCatalog::class)->name('home.index');

// TODO: Add admin auth middleware.
Route::get('admin/users', AdminIndexUser::class)->name('admin.users.index');
