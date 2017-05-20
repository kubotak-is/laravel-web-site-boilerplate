<?php
declare(strict_types=1);

namespace App\Aspect\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 * Class LoginCount
 * @package App\Aspect\Annotation
 */
class LoginCount extends Annotation
{
    /**
     * @var string
     */
    public $key = '';
    
    /**
     * @var string
     */
    public $requestKey = '';
    
    /**
     * @var int
     */
    public $minutes = 30;
    
    /**
     * @var int
     */
    public $maxRetry = 3;
    
    /**
     * @var string
     */
    public $errorRedirectAt = 'auth.get.sign_in';
    
    /**
     * @var string
     */
    public $errorMessageKey = 'sign_in';
}
