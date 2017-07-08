<?php

namespace App\Aspect\Modules;

use App\Aspect\PointCut\UpdateLastLoginTimePointCut;
use Ytake\LaravelAspect\Modules\AspectModule;

/**
 * Class UpdateLastLoginTimeModule
 * @package App\Aspect\Modules
 */
class UpdateLastLoginTimeModule extends AspectModule
{
    /** @var array */
    protected $classes = [
        \App\Services\User\UserRegistrationService::class,
        \App\Services\User\UserFacebookRegistrationService::class,
        \App\Services\User\UserTwitterRegistrationService::class,
        \App\Services\User\UserGoogleRegistrationService::class,
        \App\Services\User\UserGithubRegistrationService::class,
    ];
    
    /**
     * @return UpdateLastLoginTimePointCut
     */
    public function registerPointCut(): UpdateLastLoginTimePointCut
    {
        return new UpdateLastLoginTimePointCut;
    }
}
