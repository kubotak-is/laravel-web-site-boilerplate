<?php

namespace App\Aspect\Modules;

use App\Aspect\PointCut\LoginCountPointCut;
use Ytake\LaravelAspect\Modules\AspectModule;

/**
 * Class LoginCountModule
 * @package App\Aspect\Modules
 */
class LoginCountModule extends AspectModule
{
    /** @var array */
    protected $classes = [
        \App\Http\Action\Authentication\Email\PostSignIn::class,
    ];
    
    /**
     * @return LoginCountPointCut
     */
    public function registerPointCut(): LoginCountPointCut
    {
        return new LoginCountPointCut;
    }
}
