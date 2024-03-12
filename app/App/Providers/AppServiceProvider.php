<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerDomainServiceProviders();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register Domain Service Providers
     * @return void
     */
    private function registerDomainServiceProviders(): void
    {
        $domains = glob(base_path(). '/app/Domain/*', GLOB_ONLYDIR);
        foreach($domains as $domain){
            $provider = sprintf(
                'App\Domain\%s\%sServiceProvider',
                basename($domain),
                basename($domain)
            );

            if(class_exists($provider)){
                $this->app->register($provider);
            }
        }
    }

}
