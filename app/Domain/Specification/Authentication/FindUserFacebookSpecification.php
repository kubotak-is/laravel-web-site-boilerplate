<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Entity\User;
use App\Domain\Entity\UserFacebook;
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\ValueObject\UserId;
use App\Domain\Criteria\UsersFacebookCriteriaInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserFacebookSpecification
 * @package App\Domain\Specification\Authentication
 */
class FindUserFacebookSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersFacebookCriteriaInterface
     */
    protected $criteria;
    
    /**
     * FindUserFacebookSpecification constructor.
     * @param UsersFacebookCriteriaInterface $criteria
     */
    public function __construct(UsersFacebookCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserFacebook $entity
     * @return bool
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if (empty($entity->getToken())) {
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
     * @return UserFacebook
     * @throws NotFoundResourceException
     */
    public function find(EntityInterface $entity): UserFacebook
    {
        if (!$entity instanceof UserFacebook) {
            throw new \RuntimeException("Not Match UserFacebook");
        }
        
        $result = $this->criteria->findByFacebookId($entity->getFacebookId());
        
        if (empty($result)) {
            throw new NotFoundResourceException("Not Found UserFacebook");
        }
        
        $user  = new User(new UserId($result['user_id']));
        $user->setName($result['name']);
        $user->setFlag((bool)$result['frozen'], false);
        $user->setLastLoginTime(new \DateTime($result['last_login_time']));
        $user->setUpdatedAt(new \DateTime($result['user.updated_at']));
        $user->setCreatedAt(new \DateTime($result['user.created_at']));
        
        $facebook = new UserFacebook($user, $result['facebook_id']);
        $facebook->setToken($result['token']);
        $facebook->setUpdatedAt(new \DateTime($result['updated_at']));
        $facebook->setCreatedAt(new \DateTime($result['created_at']));
        
        return $facebook;
    }
}
