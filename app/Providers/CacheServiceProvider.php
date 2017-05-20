<?php

namespace App\Providers;

use App\DataAccess\Cache\Cache;
use App\DataAccess\Cache\CacheInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\MemcachedConnector;

/**
 * Class CacheServiceProvider
 * @package App\Providers
 */
class CacheServiceProvider extends \Illuminate\Cache\CacheServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cache', function ($app) {
            return new CacheManager($app);
        });
    
        $this->app->singleton('cache.store', function ($app) {
            return $app['cache']->driver();
        });
    
        $this->app->singleton('memcached.connector', function () {
            return new MemcachedConnector;
        });
        
        $this->app->singleton(CacheInterface::class , function($app) {
            return new Cache($app->make('cache'), 'cache', 60);
        });
    }
}
