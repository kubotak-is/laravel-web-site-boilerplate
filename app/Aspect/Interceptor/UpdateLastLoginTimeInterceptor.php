<?php
declare(strict_types=1);

namespace App\Aspect\Interceptor;

use App\Domain\Entity\{
    UserEmail, UserFacebook, UserGithub, UserGoogle, UserTwitter
};
use Ray\Aop\MethodInvocation;
use Ray\Aop\MethodInterceptor;
use Ytake\LaravelAspect\Annotation\AnnotationReaderTrait;
use App\Domain\UseCase\Authentication\UpdateLastLoginTime;

/**
 * Class UpdateLastLoginTimeInterceptor
 * @package App\Aspect\Interceptor
 */
class UpdateLastLoginTimeInterceptor implements MethodInterceptor
{
    use AnnotationReaderTrait;
    
    /**
     * @param MethodInvocation $invocation
     * @return object
     */
    public function invoke(MethodInvocation $invocation)
    {
        /**
         * @var $result UserEmail|UserTwitter|UserFacebook|UserGoogle|UserGithub
         */
        $result = $invocation->proceed();
        
        $user = $result->getUser();
        $updateLastLoginTime = app()->make(UpdateLastLoginTime::class);
        if (!$updateLastLoginTime->run($user)) {
            throw new \ErrorException("Failed Update Last Login Time");
        }
        
        return $result;
    }
}
