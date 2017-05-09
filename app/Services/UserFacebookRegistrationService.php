<?php
declare(strict_types=1);

namespace App\Services;

use App\Domain\Entity\{
    User, UserEmail, UserFacebook
};
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\InOut\{FacebookAttribute};
use App\Domain\UseCase\Authentication\{
    FindUserEmail, FindUserFacebook, RegistrationToUser, RegistrationToUserFacebook, UpdateUserFacebook
};
use App\Domain\ValueObject\FacebookId;
use App\Domain\ValueObject\UserId;
use ValueObjects\Web\EmailAddress;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};
use App\Aspect\Annotation\UpdateLastLoginTime;

/**
 * Class UserFacebookRegistrationService
 * @package App\Services
 */
class UserFacebookRegistrationService implements ServiceInterface
{
    /** @var FindUserEmail */
    private $findUserEmail;
    
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var FindUserFacebook */
    private $findUserFacebook;
    
    /** @var FindUserFacebook */
    private $facebookRegistration;
    
    /** @var UpdateUserFacebook */
    private $updateUserFacebook;
    
    /**
     * UserFacebookRegistrationService constructor.
     * @param FindUserEmail              $findUserEmail
     * @param RegistrationToUser         $registrationToUser
     * @param FindUserFacebook           $findUserFacebook
     * @param RegistrationToUserFacebook $registrationToUserFacebook
     * @param UpdateUserFacebook         $updateUserFacebook
     */
    public function __construct(
        FindUserEmail              $findUserEmail,
        RegistrationToUser         $registrationToUser,
        FindUserFacebook           $findUserFacebook,
        RegistrationToUserFacebook $registrationToUserFacebook,
        UpdateUserFacebook         $updateUserFacebook
    )
    {
        $this->findUserEmail        = $findUserEmail;
        $this->userRegistration     = $registrationToUser;
        $this->findUserFacebook     = $findUserFacebook;
        $this->facebookRegistration = $registrationToUserFacebook;
        $this->updateUserFacebook   = $updateUserFacebook;
    }
    
    /**
     * @param UserFacebook $userFacebook
     * @return UserFacebook
     */
    private function createUser(UserFacebook $userFacebook): UserFacebook
    {
        if (!$this->facebookRegistration->run($userFacebook)) {
            throw new \RuntimeException("Failed UserFacebook Registration");
        }
        
        return $userFacebook;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param FacebookAttribute $attribute
     * @param string            $userName
     * @return UserFacebook
     */
    public function registerFacebook(FacebookAttribute $attribute): UserFacebook
    {
        $newUser = new User(new UserId);
        if (!$this->userRegistration->run($newUser)) {
            throw new \ErrorException("Failed User Registration");
        };
        $newFacebook = new UserFacebook($newUser, new FacebookId($attribute->id));
        $newFacebook->setToken($attribute->token);
        return $this->createUser($newFacebook);
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @UpdateLastLoginTime
     * @param FacebookAttribute $attribute
     * @return UserFacebook
     */
    public function authenticationFacebook(FacebookAttribute $attribute): UserFacebook
    {
        $newFacebook = new UserFacebook(
            new User(new UserId),
            new FacebookId($attribute->id)
        );
        try {
            $entity = $this->findUserFacebook->run($newFacebook);
            $entity->setToken($attribute->token);
            $this->updateUserFacebook->run($entity);
        } catch (NotFoundResourceException $e) {
            // Emailで検索
            $newEmail = new UserEmail(
                new User(new UserId),
                new EmailAddress($attribute->email)
            );
            $findUserEmail = $this->findUserEmail->run($newEmail);
            // メールアドレスユーザを既に持っているため、userIdを紐付けてFacebookユーザアカウントを作成
            $newFacebook = new UserFacebook($findUserEmail->getUser(), new FacebookId($attribute->id));
            $newFacebook->setToken($attribute->token);
            $entity = $this->createUser($newFacebook);
        }
        
        return $entity;
    }
}
