<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Facebook;

use App\Domain\Exception\NotFoundResourceException;
use App\Domain\InOut\FacebookAttribute;
use App\Services\User\UserFacebookRegistrationService;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;
use Laravel\Socialite\SocialiteManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Callback
 * @package App\Http\Action\Authentication\Facebook
 */
class Callback extends Controller
{
    /**
     * @var \Laravel\Socialite\Two\FacebookProvider
     */
    private $socialite;
    
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $auth;
    
    /**
     * Callback constructor.
     * @param Application $app
     * @param AuthManager $authManager
     */
    public function __construct(Application $app, AuthManager $authManager)
    {
        $this->socialite = (new SocialiteManager($app))->driver('facebook');
        $this->auth      = $authManager->guard('web');
    }
    
    /**
     * @param UserFacebookRegistrationService $service
     * @return RedirectResponse
     */
    public function __invoke(UserFacebookRegistrationService $service): RedirectResponse
    {
        $user = $this->socialite->user();
        $facebookAttr = new FacebookAttribute;
        $facebookAttr->setInput($user);
        try {
            $entity = $service->authenticationFacebook($facebookAttr);
        } catch (NotFoundResourceException $e) {
            $entity = $service->registerFacebook($facebookAttr);
        }
    
        if (!$this->auth->loginUsingId($entity->getUser()->getUserId())) {
            throw new \ErrorException("Failed Authentication For Facebook");
        }
    
        return redirect(route('index'));
    }
}
