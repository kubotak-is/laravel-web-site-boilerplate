<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Twitter;

use App\Domain\Exception\NotFoundResourceException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;
use App\Domain\InOut\TwitterAttribute;
use Laravel\Socialite\SocialiteManager;
use App\Services\UserTwitterRegistrationService;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Callback
 * @package App\Http\Action\Authentication\Twitter
 */
class Callback extends Controller
{
    /**
     * @var \Laravel\Socialite\One\TwitterProvider
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
        $this->socialite = (new SocialiteManager($app))->driver('twitter');
        $this->auth      = $authManager->guard('web');
    }
    
    /**
     * @param UserTwitterRegistrationService $service
     * @return RedirectResponse
     */
    public function __invoke(UserTwitterRegistrationService $service): RedirectResponse
    {
        $user = $this->socialite->user();
        $twitterAttr = new TwitterAttribute();
        $twitterAttr->setInput($user);
        try {
            $entity = $service->authenticationTwitter($twitterAttr);
        } catch (NotFoundResourceException $e) {
            $entity = $service->registerTwitter($twitterAttr);
        }
        
        if (!$this->auth->loginUsingId($entity->getUser()->getUserId())) {
            throw new \ErrorException("Failed Authentication For Twitter");
        }
    
        return redirect(route('index'));
    }
}
