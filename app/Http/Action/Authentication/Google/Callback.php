<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Google;

use App\Domain\Exception\NotFoundResourceException;
use App\Domain\InOut\GoogleAttribute;
use App\Services\UserGoogleRegistrationService;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;
use Laravel\Socialite\SocialiteManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Callback
 * @package App\Http\Action\Authentication\Github
 */
class Callback extends Controller
{
    /**
     * @var \Laravel\Socialite\Two\GoogleProvider
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
        $this->socialite = (new SocialiteManager($app))->driver('google');
        $this->auth      = $authManager->guard('web');
    }
    
    /**
     * @param UserGoogleRegistrationService $service
     * @return RedirectResponse
     */
    public function __invoke(UserGoogleRegistrationService $service): RedirectResponse
    {
        $user = $this->socialite->user();
        $googleAttr = new GoogleAttribute;
        $googleAttr->setInput($user);
        try {
            $entity = $service->authenticationGoogle($googleAttr);
        } catch (NotFoundResourceException $e) {
            $entity = $service->registerGoogle($googleAttr);
        }
    
        if (!$this->auth->loginUsingId($entity->getUser()->getUserId())) {
            throw new \ErrorException("Failed Authentication For Google");
        }
    
        return redirect(route('index'));
    }
}
