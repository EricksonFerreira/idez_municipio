<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MunicipioProviderInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $provider = env('MUNICIPIOS_PROVIDER', 'BRASILAPI');

        $class = match (strtoupper($provider)) {
            'IBGE' => \App\Services\Providers\IbgeProvider::class,
            'BRASILAPI' => \App\Services\Providers\BrasilApiProvider::class,
            default => \App\Services\Providers\BrasilApiProvider::class
        };
        $this->app->bind(MunicipioProviderInterface::class, $class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
