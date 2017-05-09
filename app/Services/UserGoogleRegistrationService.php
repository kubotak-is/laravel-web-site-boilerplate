<?php
declare(strict_types=1);

namespace App\Services;

use App\Domain\Entity\{
    User, UserEmail, UserGoogle
};
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\InOut\{GoogleAttribute};
use App\Domain\UseCase\Authentication\{
    FindUserEmail, FindUserGoogle, RegistrationToUser, RegistrationToUserGoogle, UpdateUserGoogle
};
use App\Domain\ValueObject\GoogleId;
use App\Domain\ValueObject\UserId;
use ValueObjects\Web\EmailAddress;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};
use App\Aspect\Annotation\UpdateLastLoginTime;

/**
 * Class UserGoogleRegistrationService
 * @package App\Services
 */
class UserGoogleRegistrationService implements ServiceInterface
{
    /** @var FindUserEmail */
    private $findUserEmail;
    
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var FindUserGoogle */
    private $findUserGoogle;
    
    /** @var RegistrationToUserGoogle */
    private $googleRegistration;
    
    /** @var UpdateUserGoogle */
    private $updateUserGoogle;
    
    /**
     * UserGoogleRegistrationService constructor.
     * @param FindUserEmail            $findUserEmail
     * @param RegistrationToUser       $registrationToUser
     * @param FindUserGoogle           $findUserGoogle
     * @param RegistrationToUserGoogle $registrationToUserGoogle
     * @param UpdateUserGoogle         $updateUserGoogle
     */
    public function __construct(
        FindUserEmail            $findUserEmail,
        RegistrationToUser       $registrationToUser,
        FindUserGoogle           $findUserGoogle,
        RegistrationToUserGoogle $registrationToUserGoogle,
        UpdateUserGoogle         $updateUserGoogle
    )
    {
        $this->findUserEmail      = $findUserEmail;
        $this->userRegistration   = $registrationToUser;
        $this->findUserGoogle     = $findUserGoogle;
        $this->googleRegistration = $registrationToUserGoogle;
        $this->updateUserGoogle   = $updateUserGoogle;
    }
    
    /**
     * @param UserGoogle $userGoogle
     * @return UserGoogle
     */
    private function createUser(UserGoogle $userGoogle): UserGoogle
    {
        if (!$this->googleRegistration->run($userGoogle)) {
            throw new \RuntimeException("Failed UserGoogle Registration");
        }
        
        return $userGoogle;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param GoogleAttribute $attribute
     * @return UserGoogle
     * @throws \ErrorException
     */
    public function registerGoogle(GoogleAttribute $attribute): UserGoogle
    {
        $newUser = new User(new UserId);
        if (!$this->userRegistration->run($newUser)) {
            throw new \ErrorException("Failed User Registration");
        };
        $newGoogle = new UserGoogle($newUser, new GoogleId($attribute->id));
        $newGoogle->setToken($attribute->token);
        return $this->createUser($newGoogle);
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @UpdateLastLoginTime()
     * @param GoogleAttribute $attribute
     * @return UserGoogle
     */
    public function authenticationGoogle(GoogleAttribute $attribute): UserGoogle
    {
        $newGoogle = new UserGoogle(
            new User(new UserId),
            new GoogleId($attribute->id)
        );
        try {
            $entity = $this->findUserGoogle->run($newGoogle);
            $entity->setToken($attribute->token);
            $this->updateUserGoogle->run($entity);
        } catch (NotFoundResourceException $e) {
            // Emailで検索
            $newEmail = new UserEmail(
                new User(new UserId),
                new EmailAddress($attribute->email)
            );
            $findUserEmail = $this->findUserEmail->run($newEmail);
            // メールアドレスユーザを既に持っているため、userIdを紐付けてGoogleユーザアカウントを作成
            $newGoogle = new UserGoogle($findUserEmail->getUser(), new GoogleId($attribute->id));
            $newGoogle->setToken($attribute->token);
            $entity = $this->createUser($newGoogle);
        }
        
        return $entity;
    }
}
