<?php
declare(strict_types=1);

namespace App\Aspect\Interceptor;

use App\Aspect\Annotation\LoginCount;
use Illuminate\Http\Request;
use Ray\Aop\MethodInvocation;
use Ray\Aop\MethodInterceptor;
use Ytake\LaravelAspect\Annotation\AnnotationReaderTrait;
use App\Foundation\LoginChecker;

/**
 * Class LoginCountInterceptor
 * @package App\Aspect\Interceptor
 */
class LoginCountInterceptor implements MethodInterceptor
{
    use AnnotationReaderTrait;
    
    /**
     * @param MethodInvocation $invocation
     * @return object
     */
    public function invoke(MethodInvocation $invocation)
    {
        /** @var LoginChecker $checker */
        $checker    = app()->make(LoginChecker::class);
        $iterator   = $invocation->getArguments()->getIterator();
        /** @var LoginCount $annotation */
        $annotation = $invocation->getMethod()->getAnnotation($this->annotation);
        
        foreach ($iterator as $storage) {
            if ($storage instanceof Request) {
                /** @var Request $storage */
                $key = $storage->ip();
                if (!empty($annotation->key)) {
                    $key .= ":" . $storage->get($annotation->key);
                }
                if (!empty($annotation->requestKey)) {
                    $key .= ":" . $storage->get($annotation->requestKey);
                }
            }
        }
        
        if (empty($key)) {
            throw new \ErrorException("undefined ip address for request");
        }
        
        if (!$checker->check($key, $annotation->maxRetry)) {
            return redirect(route($annotation->errorRedirectAt))
                ->withErrors([
                    $annotation->errorMessageKey => "If you fail to sign in {$annotation->maxRetry} times, you will be locked for {$annotation->minutes} minutes."
                ]);
        };
        
        $checker->put($key, $annotation->minutes);
        return $invocation->proceed();
    }
}
