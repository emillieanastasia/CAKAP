<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public const HOME = '/dashboard-siswa';
    public const ADMIN_DASHBOARD ='/dashboard-admin';
    public const TENTOR_DASHBOARD ='/dashboard-tentor';
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('admin',\App\Http\Middleware\AdminMiddleware::class);
        Route::aliasMiddleware('tentor',\App\Http\Middleware\TentorMiddleware::class);
    }
}
