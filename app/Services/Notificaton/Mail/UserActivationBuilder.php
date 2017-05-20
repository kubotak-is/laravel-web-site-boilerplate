<?php
declare(strict_types=1);

namespace App\Services\Notification\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserActivationBuilder
 * @package App\Services\Notification\Mail
 */
class UserActivationBuilder extends Mailable
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
     * @var string
     */
    protected $activationUrl;
    
    /**
     * UserActivationBuilder constructor.
     * @param string $name
     * @param string $email
     * @param string $activationCode
     */
    public function __construct(string $name, string $email, string $activationCode)
    {
        $this->name          = $name;
        $this->email         = $email;
        $this->activationUrl = route('auth.get.activation', $activationCode);
    }
    
    /**
     * @return $this
     */
    public function build(): UserActivationBuilder
    {
        $name          = $this->name;
        $activationUrl = $this->activationUrl;
        $subject       = "[" . config('app.name') . "] Activation";
        
        return $this->to($this->email)
            ->subject($subject)
            ->view('email.user_activation')
            ->with(compact('name', 'activationUrl'));
    }
}
