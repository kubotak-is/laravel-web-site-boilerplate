<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Action\{
    Index,
    Authentication\Github,
    Authentication\Google,
    Authentication\Facebook,
    Authentication\Twitter
};

/**
 * Class RouteServiceProvider
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /** @var Router $router */
        $router = $this->app['router'];
        
        $router->group(['middleware' => 'web'], function (Router $router) {
            $router->get('/', [
                'as'   => 'index',
                'uses' => Index::class,
            ]);
    
            /**
             * Auth Github
             */
            $router->get('/github', [
                'as'   => 'auth.github',
                'uses' => Github\Redirect::class,
            ]);
            
            $router->get('/github/callback', [
                'as'   => 'auth.github.callback',
                'uses' => Github\Callback::class,
            ]);
            
            /**
             * Auth Google
             */
            $router->get('/google', [
                'as'   => 'auth.google',
                'uses' => Google\Redirect::class,
            ]);
            
            $router->get('/google/callback', [
                'as'   => 'auth.google.callback',
                'uses' => Google\Callback::class,
            ]);
            
            /**
             * Auth Facebook(only on https)
             */
            $router->get('/facebook', [
                'as'   => 'auth.facebook',
                'uses' => Facebook\Redirect::class,
            ]);
            
            $router->get('/facebook/callback', [
                'as'   => 'auth.facebook.callback',
                'uses' => Facebook\Callback::class,
            ]);
            
            /**
             * Auth Twitter
             */
            $router->get('/twitter', [
                'as'   => 'auth.twitter',
                'uses' => Twitter\Redirect::class,
            ]);
            
            $router->get('/twitter/callback', [
                'as'   => 'auth.twitter.callback',
                'uses' => Twitter\Callback::class,
            ]);
        });
    }
}
