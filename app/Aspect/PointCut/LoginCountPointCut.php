<?php
declare(strict_types=1);

namespace App\Aspect\PointCut;

use Illuminate\Contracts\Container\Container;
use Ytake\LaravelAspect\PointCut\PointCutable;
use Ytake\LaravelAspect\PointCut\CommonPointCut;
use App\Aspect\Interceptor\LoginCountInterceptor;

/**
 * Class LoginCountPointCut
 * @package App\Aspect\PointCut
 */
class LoginCountPointCut extends CommonPointCut implements PointCutable
{
    /** @var string */
    protected $annotation = \App\Aspect\Annotation\LoginCount::class;
    
    /**
     * @param Container $app
     *
     * @return \Ray\Aop\Pointcut
     */
    public function configure(Container $app)
    {
        $this->setInterceptor(new LoginCountInterceptor);
        return $this->withAnnotatedAnyInterceptor();
    }
}
