<?php

namespace App\Aspect\Modules;

use Ytake\LaravelAspect\Modules\LogExceptionsModule as PackageLogExceptionsModule;

/**
 * Class LogExceptionsModule
 */
class LogExceptionsModule extends PackageLogExceptionsModule
{
    /** @var array */
    protected $classes = [
        \App\Services\User\UserRegistrationService::class,
        \App\Services\User\UserFacebookRegistrationService::class,
        \App\Services\User\UserTwitterRegistrationService::class,
        \App\Services\User\UserGoogleRegistrationService::class,
        \App\Services\User\UserGithubRegistrationService::class,
    ];
}
