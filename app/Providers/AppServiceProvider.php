<?php

namespace App\Providers;

use App\Passport\ClientCacheRepository;
use App\Passport\TokenCacheRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\TokenRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!is_production_env()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->singleton(TokenRepository::class, function ($app) {
            /** @var App $app */
            return $app->make(TokenCacheRepository::class);
        });

        $this->app->singleton(ClientRepository::class, function ($app) {
            /** @var App $app */
            return $app->make(ClientCacheRepository::class);
        });

        $this->app->singleton('elasticsearch', function () {
            return \Elasticsearch\ClientBuilder::create()
                ->setHosts(['127.0.0.1:9200'])
                ->build();
        });
    }
}
