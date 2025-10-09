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
        // Register view composer untuk sidebar
        View::composer('guru.layouts.app', GlobalComposer::class);
        View::composer('kepala-sekolah.layouts.app', GlobalComposer::class);
    }
}
