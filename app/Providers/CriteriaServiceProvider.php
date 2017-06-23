<?php

namespace App\Providers;

use App\DataAccess\MySQL\{
    ImagesStorage, UsersFacebookStorage, UsersGithubStorage, UsersGoogleStorage, UsersImageStorage, UsersMailStorage, UsersStorage, UsersTwitterStorage
};
use App\Domain\Criteria\{
    ImagesCriteriaInterface, UsersCriteriaInterface, UsersFacebookCriteriaInterface, UsersGithubCriteriaInterface, UsersGoogleCriteriaInterface, UsersImageCriteriaInterface, UsersMailCriteriaInterface, UsersTwitterCriteriaInterface
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
            UsersGithubCriteriaInterface::class   => UsersGithubStorage::class,
            UsersImageCriteriaInterface::class    => UsersImageStorage::class,
            ImagesCriteriaInterface::class        => ImagesStorage::class,
        ];
    }
}
