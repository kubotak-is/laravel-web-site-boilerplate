<?php
declare(strict_types=1);

namespace App\Services;

use App\Domain\Entity\{User, UserEmail};
use App\Domain\UseCase\Authentication\{RegistrationToEmailUser, RegistrationToUser};
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
     * UserRegistrationService constructor.
     * @param RegistrationToUser      $registrationToUser
     * @param RegistrationToEmailUser $registrationToEmailUser
     */
    public function __construct(
        RegistrationToUser      $registrationToUser,
        RegistrationToEmailUser $registrationToEmailUser
    )
    {
        $this->userRegistration      = $registrationToUser;
        $this->userEmailRegistration = $registrationToEmailUser;
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
}
