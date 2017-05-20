<?php
declare(strict_types=1);

namespace App\Services\Notification\Mail;

use Illuminate\Mail\Mailer;

/**
 * Class UserActivationSuccess
 * @package App\Services\Notification\Mail
 */
class UserActivationSuccess
{
    /**
     * @var Mailer
     */
    private $mailer;
    
    /**
     * UserActivationSuccess constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    /**
     * @param string $name
     * @param string $email
     * @param string $activationCode
     */
    public function run(string $name, string $email)
    {
        $this->mailer->send(
            new UserActivationSuccessBuilder($name, $email)
        );
    }
}
