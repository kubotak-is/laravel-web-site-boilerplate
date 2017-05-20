<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use App\Services\UserRegistrationService;
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\Exception\Authentication\ValidPasswordException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Request\Authentication\Email\PostSignInRequest;
use App\Aspect\Annotation\LoginCount;

/**
 * Class PostSignIn
 * @package App\Http\Action\Authentication\Email
 */
class PostSignIn extends Controller
{
    const REDIRECT_ROUTE = 'auth.get.sign_in';
    
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $auth;
    
    /**
     * PostSignIn constructor.
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->auth = $authManager->guard('web');
    }
    
    /**
     * @LoginCount(
     *     key="email",
     *     requestKey="email"
     * )
     * @param PostSignInRequest       $request
     * @param UserRegistrationService $service
     * @return RedirectResponse
     * @throws \Exception
     */
    public function __invoke(PostSignInRequest $request, UserRegistrationService $service): RedirectResponse
    {
        $email    = $request->get('email');
        $password = $request->get('password');
        
        try {
            $entity = $service->authenticationUserEmail($email, $password);
    
            if ($this->auth->loginUsingId($entity->getUser()->getUserId())) {
                // auth success
                return redirect(route('index'));
            }
            
            return redirect(route(self::REDIRECT_ROUTE));
        } catch (\Exception $e) {
            if (
                $e instanceof NotFoundResourceException
                || $e instanceof ValidPasswordException
            ) {
                return redirect(route(self::REDIRECT_ROUTE))
                    ->withErrors(['sign_in' => 'mail address or password is un valid']);
            }
            throw $e;
        }
    }
    
    
}