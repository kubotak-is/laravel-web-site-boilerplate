<?php

namespace App\Modules;

use Ytake\LaravelAspect\Modules\TransactionalModule as PackageTransactionalModule;

/**
 * Class TransactionalModule
 */
class TransactionalModule extends PackageTransactionalModule
{
    /** @var array */
    protected $classes = [
        \App\Services\UserRegistrationService::class,
        \App\Services\UserFacebookRegistrationService::class,
    ];
}
