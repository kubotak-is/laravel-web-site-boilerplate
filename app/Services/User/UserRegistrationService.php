<?php
declare(strict_types=1);

namespace App\Services\User;

use Psr\SimpleCache\CacheInterface;
use App\Domain\Entity\{
    User, UserEmail
};
use App\Domain\UseCase\Authentication\{
    RegistrationToUserEmail, RegistrationToUser, AuthenticationToUserEmail
};
use App\Domain\ValueObject\UserId;
use ValueObjects\Identity\UUID;
use ValueObjects\Web\EmailAddress;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};
use App\Aspect\Annotation\UpdateLastLoginTime;

/**
 * Class UserRegistrationService
 * @package App\Services
 */
class UserRegistrationService implements ServiceInterface
{
    /** @var CacheInterface */
    private $cache;
    
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var RegistrationToUserEmail */
    private $userEmailRegistration;
    
    /** @var AuthenticationToUserEmail */
    private $authenticationToUserEmail;
    
    /**
     * UserRegistrationService constructor.
     * @param RegistrationToUser        $registrationToUser
     * @param RegistrationToUserEmail   $registrationToEmailUser
     * @param AuthenticationToUserEmail $authenticationToEmailUser
     */
    public function __construct(
        CacheInterface            $cache,
        RegistrationToUser        $registrationToUser,
        RegistrationToUserEmail   $registrationToEmailUser,
        AuthenticationToUserEmail $authenticationToEmailUser
    )
    {
        $this->cache                     = $cache;
        $this->userRegistration          = $registrationToUser;
        $this->userEmailRegistration     = $registrationToEmailUser;
        $this->authenticationToUserEmail = $authenticationToEmailUser;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param string $name
     * @param string $email
     * @param string $password
     * @return UserEmail
     */
    public function registerUserEmail(string $name, string $email, string $password): UserEmail
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
     * @UpdateLastLoginTime()
     * @LogExceptions()
     * @param string $email
     * @param string $password
     * @return UserEmail
     */
    public function authenticationUserEmail(string $email, string $password): UserEmail
    {
        $newUser  = new User(new UserId);
        $newEmail = new UserEmail($newUser, new EmailAddress($email));
        $newEmail->setPassword($password);
        return $this->authenticationToUserEmail->run($newEmail);
    }
    
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return string
     */
    public function generateActivationCode(string $name, string $email, string $password): string
    {
        $activationCode = UUID::generateAsString();
        
        if ($this->cache->has($activationCode)) {
            throw new \RuntimeException("{$activationCode} Key has Already Cached");
        }
        
        // 24H
        $this->cache->put($activationCode, [
            $name,
            $email,
            $password,
        ], 86400);
        
        return $activationCode;
    }
    
    /**
     * @param string $activationCode
     * @return array[name, email, password]
     */
    public function decodeActivationCode(string $activationCode): array
    {
        if (!$this->cache->has($activationCode)) {
            throw new \RuntimeException("{$activationCode} is Not Cached");
        }
        
        $decoded = $this->cache->get($activationCode);
        $this->cache->forget($activationCode);
        return $decoded;
    }
}
