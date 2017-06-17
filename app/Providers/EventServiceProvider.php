<?php

namespace App\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var Dispatcher
     */
    private $event;
    
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];
    
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];
    
    /**
     * EventServiceProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->event = new Dispatcher($app);
        parent::__construct($app);
    }
    
    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->event->listen($event, $listener);
            }
        }
        
        foreach ($this->subscribe as $subscriber) {
            $this->event->subscribe($subscriber);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }
    
    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
