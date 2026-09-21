<?php

namespace App\Providers;

use App\Models\Rekam;
use App\Observers\ItemObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        date_default_timezone_set('Asia/Jakarta');
        if (class_exists(\Carbon\Carbon::class)) {
            \Carbon\Carbon::setLocale('id');
        }

        // Force HTTPS in production, Azure App Service, or behind reverse proxy
        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
