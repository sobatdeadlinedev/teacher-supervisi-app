<?php

namespace App\Providers;

use App\Http\View\Composers\GlobalComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        // Register GlobalComposer untuk semua views
        View::composer('*', GlobalComposer::class);

        \Carbon\Carbon::setLocale('id');
    }
}
