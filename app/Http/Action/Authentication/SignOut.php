<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Illuminate\Session\SessionManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SignOut
 * @package App\Http\Action\Authentication
 */
class SignOut extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $auth;
    
    /**
     * @var \Illuminate\Contracts\Session\Session
     */
    private $session;
    
    /**
     * PostSignUp constructor.
     * @param AuthManager    $authManager
     * @param SessionManager $sessionManager
     */
    public function __construct(AuthManager $authManager, SessionManager $sessionManager)
    {
        $this->auth    = $authManager->guard('web');
        $this->session = $sessionManager->driver(config('session.driver'));
    }
    
    /**
     * @return RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $this->session->flush();
        $this->auth->logout();
        return redirect(route('index'));
    }
}
