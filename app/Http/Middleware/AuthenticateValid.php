<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;

/**
 * Class AuthenticateValid
 * @package App\Http\Middleware
 */
class AuthenticateValid
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $auth;
    
    /**
     * Authentication constructor.
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->auth = $authManager->guard('web');
    }
    
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->auth->check()) {
            // not login
            return redirect(route('auth.get.sign_in'));
        }

        $session = $request->session();
        $session->put(['user_id' => $this->auth->id()]);
        
        return $next($request);
    }
}
