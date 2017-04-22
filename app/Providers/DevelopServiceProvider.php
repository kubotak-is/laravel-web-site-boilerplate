<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class DevelopServiceProvider
 * @package App\Providers
 */
class DevelopServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $providers = [
        'Barryvdh\Debugbar\ServiceProvider'
    ];
    
    /**@var array $facadeAliases */
    protected $facadeAliases = [
        'Debugbar' => 'Barryvdh\Debugbar\Facade',
    ];
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug')) {
            $this->registerServiceProviders();
            $this->registerFacadeAliases();
        }
    }
    
    /**
     * register service providers
     */
    protected function registerServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
    
    /**
     * add class aliases
     */
    protected function registerFacadeAliases()
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->facadeAliases as $alias => $facade) {
            $loader->alias($alias, $facade);
        }
    }
}