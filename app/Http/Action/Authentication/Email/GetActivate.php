<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use App\Services\UserRegistrationService;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class GetActivate
 * @package App\Http\Action\Authentication\Email
 */
class GetActivate extends Controller
{
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
     * @param UserRegistrationService $service
     * @param string                  $activationCode
     * @return RedirectResponse
     * @throws \ErrorException
     */
    public function __invoke(UserRegistrationService $service, string $activationCode): RedirectResponse
    {
        list($name, $email, $password) = $service->decodeActivationCode($activationCode);
        
        $entity = $service->registerUserEmail($name, $email, $password);
    
        if (!$this->auth->loginUsingId($entity->getUser()->getUserId())) {
            throw new \ErrorException("Failed Auth Email");
        }
    
        // auth success
        return redirect(route('index'));
    }
    
}
