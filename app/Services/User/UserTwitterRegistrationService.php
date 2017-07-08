<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Domain\Entity\{
    User, UserTwitter
};
use App\Domain\InOut\{TwitterAttribute};
use App\Domain\UseCase\Authentication\{
    FindUserTwitter, RegistrationToUser, RegistrationToUserTwitter, UpdateUserTwitter
};
use App\Domain\UseCase\Image\{
    CreateUserImage, SaveImage
};
use App\Foundation\ImageManager;
use App\Domain\ValueObject\TwitterId;
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};
use App\Aspect\Annotation\UpdateLastLoginTime;

/**
 * Class UserTwitterRegistrationService
 * @package App\Services\User
 */
class UserTwitterRegistrationService implements ServiceInterface
{
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var FindUserTwitter */
    private $findUserTwitter;
    
    /** @var RegistrationToUserTwitter */
    private $twitterRegistration;
    
    /** @var UpdateUserTwitter */
    private $updateUserTwitter;
    
    /** @var ImageManager */
    private $image;
    
    /** @var SaveImage */
    private $saveImage;
    
    /** @var CreateUserImage */
    private $createUserImage;
    
    /**
     * UserTwitterRegistrationService constructor.
     * @param RegistrationToUser        $registrationToUser
     * @param FindUserTwitter           $findUserTwitter
     * @param RegistrationToUserTwitter $registrationToUserTwitter
     * @param UpdateUserTwitter         $updateUserTwitter
     * @param ImageManager              $imageManager
     * @param SaveImage                 $saveImage
     * @param CreateUserImage           $createUserImage
     */
    public function __construct(
        RegistrationToUser        $registrationToUser,
        FindUserTwitter           $findUserTwitter,
        RegistrationToUserTwitter $registrationToUserTwitter,
        UpdateUserTwitter         $updateUserTwitter,
        ImageManager              $imageManager,
        SaveImage                 $saveImage,
        CreateUserImage           $createUserImage
    )
    {
        $this->userRegistration    = $registrationToUser;
        $this->findUserTwitter     = $findUserTwitter;
        $this->twitterRegistration = $registrationToUserTwitter;
        $this->updateUserTwitter   = $updateUserTwitter;
        $this->image               = $imageManager;
        $this->saveImage           = $saveImage;
        $this->createUserImage     = $createUserImage;
    }
    
    /**
     * @param UserTwitter $userTwitter
     * @return UserTwitter
     */
    private function createUser(UserTwitter $userTwitter): UserTwitter
    {
        if (!$this->twitterRegistration->run($userTwitter)) {
            throw new \RuntimeException("Failed UserFacebook Registration");
        }
        
        return $userTwitter;
    }
    
    /**
     * @Transactional("mysql")
     * @LogExceptions()
     * @param TwitterAttribute $attribute
     * @return UserTwitter
     * @throws \ErrorException
     */
    public function registerTwitter(TwitterAttribute $attribute): UserTwitter
    {
        $newUser = new User(new UserId);
        if (!$this->userRegistration->run($newUser)) {
            throw new \ErrorException("Failed User Registration");
        };
        $newTwitter = new UserTwitter($newUser, new TwitterId($attribute->id));
        $newTwitter->setNickname($attribute->name);
        $newTwitter->setToken($attribute->token);
        $newTwitter->setTokenSecret($attribute->tokenSecret);
    
        // save image
        $this->image->setSavePath($newUser->getUserId());
        $imageEntity = $this->image->create($attribute->avatar);
        $imageEntity = $this->saveImage->run($imageEntity);
        $this->createUserImage->run($newUser, $imageEntity);
        
        return $this->createUser($newTwitter);
    }
    
    /**
     * @UpdateLastLoginTime()
     * @LogExceptions()
     * @param TwitterAttribute $attribute
     * @return UserTwitter
     */
    public function authenticationTwitter(TwitterAttribute $attribute): UserTwitter
    {
        $newTwitter = new UserTwitter(
            new User(new UserId),
            new TwitterId($attribute->id)
        );
        $entity = $this->findUserTwitter->run($newTwitter);
        $entity->setToken($attribute->token);
        $entity->setTokenSecret($attribute->tokenSecret);
        $this->updateUserTwitter->run($entity);
        return $entity;
    }
}
