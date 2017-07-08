<?php

namespace App\Aspect\Modules;

use Ytake\LaravelAspect\Modules\TransactionalModule as PackageTransactionalModule;

/**
 * Class TransactionalModule
 */
class TransactionalModule extends PackageTransactionalModule
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
