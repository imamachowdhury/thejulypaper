<?php

namespace App\Providers;

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
        if (!function_exists('toBangla')) {
            function toBangla($number) {
                if ($number === null) return '';
                $search = ['0','1','2','3','4','5','6','7','8','9'];
                $replace = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                return str_replace($search, $replace, $number);
            }
        }
    }
}
