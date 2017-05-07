<?php
declare(strict_types=1);

namespace App\Aspect\PointCut;

use Illuminate\Contracts\Container\Container;
use Ytake\LaravelAspect\PointCut\PointCutable;
use Ytake\LaravelAspect\PointCut\CommonPointCut;
use App\Aspect\Interceptor\UpdateLastLoginTimeInterceptor;

/**
 * Class UpdateLastLoginTimePointCut
 * @package App\Aspect\PointCut
 */
class UpdateLastLoginTimePointCut extends CommonPointCut implements PointCutable
{
    /** @var string */
    protected $annotation = \App\Aspect\Annotation\UpdateLastLoginTime::class;
    
    /**
     * @param Container $app
     *
     * @return \Ray\Aop\Pointcut
     */
    public function configure(Container $app)
    {
        $this->setInterceptor(new UpdateLastLoginTimeInterceptor);
        return $this->withAnnotatedAnyInterceptor();
    }
}