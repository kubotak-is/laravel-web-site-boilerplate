<?php

namespace App\Providers;

use App\DataAccess\MySQL\UsersFacebookStorage;
use App\DataAccess\MySQL\UsersGoogleStorage;
use App\DataAccess\MySQL\UsersMailStorage;
use App\DataAccess\MySQL\UsersStorage;
use App\DataAccess\MySQL\UsersTwitterStorage;
use App\Domain\Criteria\{
    UsersCriteriaInterface, UsersFacebookCriteriaInterface, UsersGoogleCriteriaInterface, UsersMailCriteriaInterface, UsersTwitterCriteriaInterface
};
use Illuminate\Support\ServiceProvider;

/**
 * Class CriteriaServiceProvider
 * @package App\Providers
 */
class CriteriaServiceProvider extends ServiceProvider
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
        foreach ($this->bindMap() as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }
    
    /**
     * @return array
     */
    private function bindMap(): array
    {
        return [
            UsersCriteriaInterface::class         => UsersStorage::class,
            UsersMailCriteriaInterface::class     => UsersMailStorage::class,
            UsersFacebookCriteriaInterface::class => UsersFacebookStorage::class,
            UsersTwitterCriteriaInterface::class  => UsersTwitterStorage::class,
            UsersGoogleCriteriaInterface::class   => UsersGoogleStorage::class,
        ];
    }
}
