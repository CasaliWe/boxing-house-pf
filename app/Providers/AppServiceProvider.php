<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Carbon as IlluminateCarbon;
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
        // Define o locale do Carbon como pt_BR para que translatedFormat,
        // isoFormat e diffForHumans devolvam textos em português.
        Carbon::setLocale('pt_BR');
        IlluminateCarbon::setLocale('pt_BR');
    }
}
