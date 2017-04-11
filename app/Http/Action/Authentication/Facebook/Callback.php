<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Facebook;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;
use Laravel\Socialite\SocialiteManager;

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
     * Callback constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->socialite = (new SocialiteManager($app))->driver('facebook');
    }
    
    public function __invoke()
    {
        $user = $this->socialite->user();
        
        dd($user);
    }
}
