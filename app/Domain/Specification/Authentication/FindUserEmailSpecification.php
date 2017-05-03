<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Entity\User;
use App\Domain\Entity\UserEmail;
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\ValueObject\UserId;
use App\Domain\Criteria\UsersMailCriteriaInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class FindUserEmailSpecification
 * @package App\Domain\Specification\Authentication
 */
class FindUserEmailSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersMailCriteriaInterface
     */
    protected $criteria;
    
    /**
     * AuthenticationUserEmailSpecification constructor.
     * @param UsersMailCriteriaInterface $criteria
     */
    public function __construct(UsersMailCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserEmail $entity
     * @return bool
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if (empty($entity->getEmail())) {
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
     * @return UserEmail
     */
    public function find(EntityInterface $entity): UserEmail
    {
        if (!$entity instanceof UserEmail) {
            throw new \RuntimeException("Not Match UserEmail");
        }
        
        $result = $this->criteria->findByEmail($entity->getEmail());
        
        if (empty($result)) {
            throw new NotFoundResourceException("Not Found UserEmail");
        }
        
        $user  = new User(new UserId($result['user_id']));
        $user->setName($result['name']);
        $user->setFlag((bool)$result['frozen'], false);
        $user->setLastLoginTime(new \DateTime($result['last_login_time']));
        $user->setUpdatedAt(new \DateTime($result['user.updated_at']));
        $user->setCreatedAt(new \DateTime($result['user.created_at']));
        
        $email = new UserEmail($user, new EmailAddress($result['email']));
        $email->setPassword($result['password']);
        $email->setUpdatedAt(new \DateTime($result['updated_at']));
        $email->setCreatedAt(new \DateTime($result['created_at']));
        
        return $email;
    }
}
