<?php
declare(strict_types=1);

namespace App\Services\Notification\Mail;

use Illuminate\Mail\Mailer;

/**
 * Class UserActivation
 * @package App\Services\Notification\Mail
 */
class UserActivation
{
    /**
     * @var Mailer
     */
    private $mailer;
    
    /**
     * UserActivation constructor.
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
    public function run(string $name, string $email, string $activationCode)
    {
        $this->mailer->send(
            new UserActivationBuilder($name, $email, $activationCode)
        );
    }
}
