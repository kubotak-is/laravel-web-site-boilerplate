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
        \App\Services\UserRegistrationService::class,
        \App\Services\UserFacebookRegistrationService::class,
        \App\Services\UserTwitterRegistrationService::class,
        \App\Services\UserGoogleRegistrationService::class,
        \App\Services\UserGithubRegistrationService::class,
    ];
    
    /**
     * @return UpdateLastLoginTimePointCut
     */
    public function registerPointCut(): UpdateLastLoginTimePointCut
    {
        return new UpdateLastLoginTimePointCut;
    }
}
