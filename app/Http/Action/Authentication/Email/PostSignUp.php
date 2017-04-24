<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use App\Services\UserRegistrationService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Request\Authentication\Email\PostSignUpRequest;

/**
 * Class PostSignUp
 * @package App\Http\Action\Authentication\Email
 */
class PostSignUp extends Controller
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
     * @param PostSignUpRequest       $request
     * @param UserRegistrationService $service
     * @return RedirectResponse
     */
    public function __invoke(PostSignUpRequest $request, UserRegistrationService $service): RedirectResponse
    {
        $name     = $request->get('name');
        $email    = $request->get('email');
        $password = bcrypt($request->get('password'));

        $entity = $service->registerEmailUser($name, $email, $password);
        
        if ($this->auth->loginUsingId($entity->getUser()->getUserId())) {
            // auth success
            return redirect(route('index'));
        }
        return redirect(route('auth.get.sign_up'));
    }
    
    
}