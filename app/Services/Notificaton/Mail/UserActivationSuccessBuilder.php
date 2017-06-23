<?php
declare(strict_types=1);

namespace App\Services\Notification\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserActivationSuccessBuilder
 * @package App\Services\Notification\Mail
 */
class UserActivationSuccessBuilder extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * UserActivationBuilder constructor.
     * @param string $name
     * @param string $email
     * @param string $activationCode
     */
    public function __construct(string $name, string $email)
    {
        $this->name  = $name;
        $this->email = $email;
    }
    
    /**
     * @return $this
     */
    public function build(): UserActivationSuccessBuilder
    {
        $name    = $this->name;
        $subject = "[" . config('app.name') . "] Activation Success";
        
        return $this->to($this->email)
            ->subject($subject)
            ->view('email.user_activation_success')
            ->with(compact('name'));
    }
}
