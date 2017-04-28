<?php
declare(strict_types=1);

namespace App\Services;

use App\Domain\Entity\{User, UserEmail};
use App\Domain\UseCase\Authentication\{RegistrationToEmailUser, RegistrationToUser, AuthenticationToEmailUser};
use App\Domain\ValueObject\UserId;
use ValueObjects\Web\EmailAddress;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};

/**
 * Class UserRegistrationService
 * @package App\Services
 */
class UserRegistrationService
{
    /**
     * @var RegistrationToUser
     */
    private $userRegistration;
    
    /**
     * @var RegistrationToEmailUser
     */
    private $userEmailRegistration;
    
    /**
     * @var AuthenticationToEmailUser
     */
    private $authenticationToEmailUser;
    
    /**
     * UserRegistrationService constructor.
     * @param RegistrationToUser        $registrationToUser
     * @param RegistrationToEmailUser   $registrationToEmailUser
     * @param AuthenticationToEmailUser $authenticationToEmailUser
     */
    public function __construct(
        RegistrationToUser        $registrationToUser,
        RegistrationToEmailUser   $registrationToEmailUser,
        AuthenticationToEmailUser $authenticationToEmailUser
    )
    {
        $this->userRegistration          = $registrationToUser;
        $this->userEmailRegistration     = $registrationToEmailUser;
        $this->authenticationToEmailUser = $authenticationToEmailUser;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param string $name
     * @param string $email
     * @param string $password
     * @return UserEmail
     */
    public function registerEmailUser(string $name, string $email, string $password): UserEmail
    {
        $newUser = new User(new UserId);
        $newUser->setName($name);
        if (!$this->userRegistration->run($newUser)) {
            throw new \RuntimeException("Failed User Registration");
        }
        
        $newEmail = new UserEmail($newUser, new EmailAddress($email));
        $newEmail->setPassword($password);
        if (!$this->userEmailRegistration->run($newEmail)) {
            throw new \RuntimeException("Failed Email Registration");
        }
        
        return $newEmail;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param string $email
     * @param string $password
     * @return UserEmai
     */
    public function registerValidEmailUser(string $email, string $password): UserEmail
    {
        $newUser  = new User(new UserId);
        $newEmail = new UserEmail($newUser, new EmailAddress($email));
        $newEmail->setPassword($password);
        return $this->authenticationToEmailUser->run($newEmail);
    }
}
