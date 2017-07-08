<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Github;

use App\Domain\Exception\NotFoundResourceException;
use App\Domain\InOut\GithubAttribute;
use App\Services\User\UserGithubRegistrationService;
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
     * @var \Laravel\Socialite\Two\GithubProvider
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
        $this->socialite = (new SocialiteManager($app))->driver('github');
        $this->auth      = $authManager->guard('web');
    }
    
    /**
     * @param UserGithubRegistrationService $service
     * @return RedirectResponse
     */
    public function __invoke(UserGithubRegistrationService $service): RedirectResponse
    {
        $user = $this->socialite->user();
        $githubAttr = new GithubAttribute;
        $githubAttr->setInput($user);
        try {
            $entity = $service->authenticationGithub($githubAttr);
        } catch (NotFoundResourceException $e) {
            $entity = $service->registerGithub($githubAttr);
        }
    
        if (!$this->auth->loginUsingId($entity->getUser()->getUserId())) {
            throw new \ErrorException("Failed Authentication For Github");
        }
    
        return redirect(route('index'));
    }
}
