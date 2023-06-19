<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
    // Hal ini berguna jika Anda menggunakan database MySQL versi lama yang tidak mendukung panjang string lebih dari 255 karakter. Laravel akan mengatur panjang default string menjadi 191 karakter.
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
