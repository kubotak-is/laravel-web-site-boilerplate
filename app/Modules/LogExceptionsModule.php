<?php

namespace App\Modules;

use Ytake\LaravelAspect\Modules\LogExceptionsModule as PackageLogExceptionsModule;

/**
 * Class LogExceptionsModule
 */
class LogExceptionsModule extends PackageLogExceptionsModule
{
    /** @var array */
    protected $classes = [
        \App\Services\UserRegistrationService::class,
        \App\Services\UserFacebookRegistrationService::class,
        \App\Services\UserTwitterRegistrationService::class,
        \App\Services\UserGoogleRegistrationService::class,
    ];
}
