<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Criteria\UsersGoogleCriteriaInterface;
use App\Domain\Entity\User;
use App\Domain\Entity\UserGoogle;
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\ValueObject\GoogleId;
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserGoogleSpecification
 * @package App\Domain\Specification\Authentication
 */
class FindUserGoogleSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersGoogleCriteriaInterface
     */
    protected $criteria;
    
    /**
     * FindUserGoogleSpecification constructor.
     * @param UsersGoogleCriteriaInterface $criteria
     */
    public function __construct(UsersGoogleCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserGoogle $entity
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
     * @return UserGoogle
     * @throws NotFoundResourceException
     */
    public function find(EntityInterface $entity): UserGoogle
    {
        if (!$entity instanceof UserGoogle) {
            throw new \RuntimeException("Not Match UserGoogle");
        }
        
        $result = $this->criteria->findByGoogleId($entity->getGoogleId());
        
        if (empty($result)) {
            throw new NotFoundResourceException("Not Found UserGoogle");
        }
        
        $user  = new User(new UserId($result['user_id']));
        $user->setName($result['name']);
        $user->setFlag((bool)$result['frozen'], false);
        $user->setLastLoginTime(new \DateTime($result['last_login_time']));
        $user->setUpdatedAt(new \DateTime($result['user.updated_at']));
        $user->setCreatedAt(new \DateTime($result['user.created_at']));
        
        $google = new UserGoogle($user, new GoogleId($result['google_id']));
        $google->setToken($result['token']);
        $google->setUpdatedAt(new \DateTime($result['updated_at']));
        $google->setCreatedAt(new \DateTime($result['created_at']));
        
        return $google;
    }
}
