<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Entity\User;
use App\Domain\Entity\UserTwitter;
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\ValueObject\UserId;
use App\Domain\Criteria\UsersTwitterCriteriaInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserTwitterSpecification
 * @package App\Domain\Specification\Authentication
 */
class FindUserTwitterSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersTwitterCriteriaInterface
     */
    protected $criteria;
    
    /**
     * FindUserTwitterSpecification constructor.
     * @param UsersTwitterCriteriaInterface $criteria
     */
    public function __construct(UsersTwitterCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserTwitter $entity
     * @return bool
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if (empty($entity->getToken())) {
            return false;
        }
        
        if (empty($entity->getTokenSecret())) {
            return false;
        }
        
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function build(): CriteriaInterface
    {
        return $this->criteria;
    }
    
    /**
     * @param EntityInterface $entity
     * @return UserTwitter
     * @throws NotFoundResourceException
     */
    public function find(EntityInterface $entity): UserTwitter
    {
        if (!$entity instanceof UserTwitter) {
            throw new \RuntimeException("Not Match UserTwitter");
        }
        
        $result = $this->criteria->findByTwitterId($entity->getTwitterId());
        
        if (empty($result)) {
            throw new NotFoundResourceException("Not Found UserTwitter");
        }
        
        $user  = new User(new UserId($result['user_id']));
        $user->setName($result['name']);
        $user->setFlag((bool)$result['frozen'], false);
        $user->setLastLoginTime(new \DateTime($result['last_login_time']));
        $user->setUpdatedAt(new \DateTime($result['user.updated_at']));
        $user->setCreatedAt(new \DateTime($result['user.created_at']));
        
        $twitter = new UserTwitter($user, $result['twitter_id']);
        $twitter->setToken($result['token']);
        $twitter->setNickname($result['nickname']);
        $twitter->setTokenSecret($result['token_secret']);
        $twitter->setUpdatedAt(new \DateTime($result['updated_at']));
        $twitter->setCreatedAt(new \DateTime($result['created_at']));
        
        return $twitter;
    }
}
