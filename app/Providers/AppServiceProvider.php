<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use pxlrbt\FilamentExcel\Exports\Formatters\EnumFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //formatter enum export excel
        // App::bind(EnumFormatter::class, function () {
        //     return new EnumFormatter(';');
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
