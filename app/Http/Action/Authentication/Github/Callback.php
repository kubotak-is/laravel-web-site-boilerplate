<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Github;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;
use Laravel\Socialite\SocialiteManager;

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
     * Callback constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->socialite = (new SocialiteManager($app))->driver('github');
    }
    
    public function __invoke()
    {
        $user = $this->socialite->user();
        
        dd($user);
    }
}
