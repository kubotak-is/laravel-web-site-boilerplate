<?php
declare(strict_types=1);

namespace App\Services;

use App\Domain\Entity\{
    User, UserEmail
};
use App\Domain\UseCase\Authentication\{
    RegistrationToUserEmail, RegistrationToUser, AuthenticationToEmailUser
};
use App\Domain\ValueObject\UserId;
use ValueObjects\Web\EmailAddress;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};

/**
 * Class UserRegistrationService
 * @package App\Services
 */
class UserRegistrationService implements ServiceInterface
{
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var RegistrationToUserEmail */
    private $userEmailRegistration;
    
    /** @var AuthenticationToEmailUser */
    private $authenticationToEmailUser;
    
    /**
     * UserRegistrationService constructor.
     * @param RegistrationToUser        $registrationToUser
     * @param RegistrationToUserEmail   $registrationToEmailUser
     * @param AuthenticationToEmailUser $authenticationToEmailUser
     */
    public function __construct(
        RegistrationToUser        $registrationToUser,
        RegistrationToUserEmail   $registrationToEmailUser,
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
     * @LogExceptions()
     * @param string $email
     * @param string $password
     * @return UserEmail
     */
    public function authenticationEmailUser(string $email, string $password): UserEmail
    {
        $newUser  = new User(new UserId);
        $newEmail = new UserEmail($newUser, new EmailAddress($email));
        $newEmail->setPassword($password);
        return $this->authenticationToEmailUser->run($newEmail);
    }
}
