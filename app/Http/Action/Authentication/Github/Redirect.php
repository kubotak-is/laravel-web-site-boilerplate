<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Github;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;
use Laravel\Socialite\SocialiteManager;

/**
 * Class Redirect
 * @package App\Http\Action\Authentication\Github
 */
class Redirect extends Controller
{
    /**
     * @var \Laravel\Socialite\Two\GithubProvider
     */
    private $socialite;
    
    /**
     * Redirect constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->socialite = (new SocialiteManager($app))->driver('github');
    }
    
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $this->socialite->redirect();
    }
}
