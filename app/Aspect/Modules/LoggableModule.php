<?php

namespace App\Aspect\Modules;

use App\DataAccess\MySQL\{
    ImagesStorage, UsersFacebookStorage, UsersGoogleStorage, UsersImageStorage, UsersStorage, UsersMailStorage, UsersTwitterStorage
};
use Ytake\LaravelAspect\Modules\LoggableModule as PackageLoggableModule;

/**
 * Class LoggableModule
 */
class LoggableModule extends PackageLoggableModule
{
    /** @var array */
    protected $classes = [
        UsersStorage::class,
        UsersMailStorage::class,
        UsersFacebookStorage::class,
        UsersTwitterStorage::class,
        UsersGoogleStorage::class,
        UsersImageStorage::class,
        ImagesStorage::class,
    ];
}
