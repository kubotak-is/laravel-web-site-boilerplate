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
        // example
        // \App\Services\AcmeService::class
    ];
}
