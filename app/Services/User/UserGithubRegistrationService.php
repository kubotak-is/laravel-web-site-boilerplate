<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Domain\Entity\{
    User, UserEmail, UserGithub
};
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\InOut\{
    GithubAttribute
};
use App\Domain\UseCase\Authentication\{
    FindUserEmail, FindUserGithub, RegistrationToUser, RegistrationToUserGithub, UpdateUserGithub
};
use App\Domain\UseCase\Image\{
    CreateUserImage, SaveImage
};
use App\Foundation\ImageManager;
use App\Domain\ValueObject\GithubId;
use App\Domain\ValueObject\UserId;
use ValueObjects\Web\EmailAddress;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};
use App\Aspect\Annotation\UpdateLastLoginTime;

/**
 * Class UserGithubRegistrationService
 * @package App\Services\User
 */
class UserGithubRegistrationService implements ServiceInterface
{
    /** @var FindUserEmail */
    private $findUserEmail;
    
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var FindUserGithub */
    private $findUserGithub;
    
    /** @var RegistrationToUser */
    private $githubRegistration;
    
    /** @var UpdateUserGithub */
    private $updateUserGithub;
    
    /** @var ImageManager */
    private $image;
    
    /** @var SaveImage */
    private $saveImage;
    
    /** @var CreateUserImage */
    private $createUserImage;
    
    /**
     * UserGithubRegistrationService constructor.
     * @param FindUserEmail            $findUserEmail
     * @param RegistrationToUser       $registrationToUser
     * @param FindUserGithub           $findUserGithub
     * @param RegistrationToUserGithub $registrationToUserGithub
     * @param UpdateUserGithub         $updateUserGithub
     * @param ImageManager             $imageManager
     * @param SaveImage                $saveImage
     * @param CreateUserImage          $createUserImage
     */
    public function __construct(
        FindUserEmail            $findUserEmail,
        RegistrationToUser       $registrationToUser,
        FindUserGithub           $findUserGithub,
        RegistrationToUserGithub $registrationToUserGithub,
        UpdateUserGithub         $updateUserGithub,
        ImageManager             $imageManager,
        SaveImage                $saveImage,
        CreateUserImage          $createUserImage
    )
    {
        $this->findUserEmail      = $findUserEmail;
        $this->userRegistration   = $registrationToUser;
        $this->findUserGithub     = $findUserGithub;
        $this->githubRegistration = $registrationToUserGithub;
        $this->updateUserGithub   = $updateUserGithub;
        $this->image              = $imageManager;
        $this->saveImage          = $saveImage;
        $this->createUserImage    = $createUserImage;
    }
    
    /**
     * @param UserGithub $userGithub
     * @return UserGithub
     */
    private function createUser(UserGithub $userGithub): UserGithub
    {
        if (!$this->githubRegistration->run($userGithub)) {
            throw new \RuntimeException("Failed UserGithub Registration");
        }
        
        return $userGithub;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param GithubAttribute $attribute
     * @return UserGithub
     * @throws \ErrorException
     */
    public function registerGithub(GithubAttribute $attribute): UserGithub
    {
        $newUser = new User(new UserId);
        if (!$this->userRegistration->run($newUser)) {
            throw new \ErrorException("Failed User Registration");
        };
        $newGithub = new UserGithub($newUser, new GithubId($attribute->id));
        $newGithub->setToken($attribute->token);
        $newGithub->setNickname($attribute->nickname);
    
        // save image
        $this->image->setSavePath($newUser->getUserId());
        $imageEntity = $this->image->create($attribute->avatar);
        $imageEntity = $this->saveImage->run($imageEntity);
        $this->createUserImage->run($newUser, $imageEntity);
        
        return $this->createUser($newGithub);
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @UpdateLastLoginTime
     * @param GithubAttribute $attribute
     * @return UserGithub
     */
    public function authenticationGithub(GithubAttribute $attribute): UserGithub
    {
        $newGithub = new UserGithub(
            new User(new UserId),
            new GithubId($attribute->id)
        );
        try {
            $entity = $this->findUserGithub->run($newGithub);
            $entity->setToken($attribute->token);
            $entity->setNickname($attribute->nickname);
            $this->updateUserGithub->run($entity);
        } catch (NotFoundResourceException $e) {
            // Emailで検索
            $newEmail = new UserEmail(
                new User(new UserId),
                new EmailAddress($attribute->email)
            );
            $findUserEmail = $this->findUserEmail->run($newEmail);
            // メールアドレスユーザを既に持っているため、userIdを紐付けてGithubユーザアカウントを作成
            $newGithub = new UserGithub($findUserEmail->getUser(), new GithubId($attribute->id));
            $newGithub->setToken($attribute->token);
            $newGithub->setNickname($attribute->nickname);
            $entity = $this->createUser($newGithub);
        }
        
        return $entity;
    }
}
