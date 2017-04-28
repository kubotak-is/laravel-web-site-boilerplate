<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use App\Services\UserRegistrationService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Request\Authentication\Email\PostSignInRequest;

/**
 * Class PostSignIn
 * @package App\Http\Action\Authentication\Email
 */
class PostSignIn extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $auth;
    
    /**
     * PostSignUp constructor.
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->auth = $authManager->guard('web');
    }
    
    /**
     * @param PostSignInRequest       $request
     * @param UserRegistrationService $service
     * @return RedirectResponse
     */
    public function __invoke(PostSignInRequest $request, UserRegistrationService $service): RedirectResponse
    {
        $email    = $request->get('email');
        $password = $request->get('password');
        
        $entity = $service->registerValidEmailUser($email, $password);
        
        if ($this->auth->loginUsingId($entity->getUser()->getUserId())) {
            // auth success
            return redirect(route('index'));
        }
        return redirect(route('auth.get.sign_up'));
    }
    
    
}