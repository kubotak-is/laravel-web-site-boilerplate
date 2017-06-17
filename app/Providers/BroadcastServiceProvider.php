<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Broadcasting\BroadcastManager;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * @var BroadcastManager
     */
    protected $broadcast;
    
    /**
     * BroadcastServiceProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->broadcast = new BroadcastManager($app);
        parent::__construct($app);
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->broadcast->routes();

//        require base_path('routes/channels.php');
    }
}
