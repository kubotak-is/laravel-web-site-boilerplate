<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use App\Services\User\UserRegistrationService;
use App\Services\Notification\Mail\UserActivationSuccess;
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
     * @var UserActivationSuccess
     */
    private $mailer;
    
    /**
     * GetActivate constructor.
     * @param AuthManager           $authManager
     * @param UserActivationSuccess $activationSuccess
     */
    public function __construct(AuthManager $authManager, UserActivationSuccess $activationSuccess)
    {
        $this->auth   = $authManager->guard('web');
        $this->mailer = $activationSuccess;
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
        
        $this->mailer->run($name, $email);
    
        // auth success
        return redirect(route('index'));
    }
    
}
