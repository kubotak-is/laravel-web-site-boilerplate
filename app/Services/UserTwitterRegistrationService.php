<?php
declare(strict_types=1);

namespace App\Services;

use App\Domain\Entity\{
    User, UserTwitter
};
use App\Domain\InOut\{TwitterAttribute};
use App\Domain\UseCase\Authentication\{
    FindUserTwitter, RegistrationToUser, RegistrationToUserTwitter
};
use App\Domain\ValueObject\TwitterId;
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Service\ServiceInterface;
use Ytake\LaravelAspect\Annotation\{LogExceptions, Transactional};

/**
 * Class UserTwitterRegistrationService
 * @package App\Services
 */
class UserTwitterRegistrationService implements ServiceInterface
{
    /** @var RegistrationToUser */
    private $userRegistration;
    
    /** @var FindUserTwitter */
    private $findUserTwitter;
    
    /** @var RegistrationToUserTwitter */
    private $twitterRegistration;
    
    /**
     * UserTwitterRegistrationService constructor.
     * @param RegistrationToUser        $registrationToUser
     * @param FindUserTwitter           $findUserTwitter
     * @param RegistrationToUserTwitter $registrationToUserTwitter
     */
    public function __construct(
        RegistrationToUser        $registrationToUser,
        FindUserTwitter           $findUserTwitter,
        RegistrationToUserTwitter $registrationToUserTwitter
    )
    {
        $this->userRegistration    = $registrationToUser;
        $this->findUserTwitter     = $findUserTwitter;
        $this->twitterRegistration = $registrationToUserTwitter;
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
        return $this->createUser($newTwitter);
    }
    
    /**
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
        return $this->findUserTwitter->run($newTwitter);
    }
}
