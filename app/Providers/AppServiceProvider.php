<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(app()->isProduction());
        DB::prohibitDestructiveCommands(app()->isProduction());

        $requiredTables = ['users', 'categories'];

        if ($this->tablesExist($requiredTables)) {
            View::share([
                'usersCount' => User::count(),
                'categoriesCount' => Category::count(),
            ]);
        }
    }

    protected function tablesExist(array $tables): bool
    {
        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                return false;
            }
        }

        return true;
    }
}
