<?php
declare(strict_types=1);

namespace App\Http\Action\Authentication\Email;

use Illuminate\View\View;
use Illuminate\Routing\Controller;
use App\Services\User\UserRegistrationService;
use App\Services\Notification\Mail\UserActivation;
use App\Http\Request\Authentication\Email\PostSignUpRequest;

/**
 * Class PostSignUp
 * @package App\Http\Action\Authentication\Email
 */
class PostSignUp extends Controller
{
    /**
     * @var UserActivation
     */
    private $mailer;
    
    /**
     * PostSignUp constructor.
     * @param UserActivation $userActivation
     */
    public function __construct(UserActivation $userActivation)
    {
        $this->mailer = $userActivation;
    }
    
    /**
     * @param PostSignUpRequest $request
     * @return View
     */
    public function __invoke(PostSignUpRequest $request, UserRegistrationService $service): View
    {
        $name     = (string) $request->get('name');
        $email    = (string) $request->get('email');
        $password = (string) password_hash($request->get('password'), PASSWORD_BCRYPT, []);
        
        $activationCode = $service->generateActivationCode($name, $email, $password);
        $this->mailer->run($name, $email, $activationCode);
        
        return view('authentication.send_activate')->with(compact('email'));
    }
}
