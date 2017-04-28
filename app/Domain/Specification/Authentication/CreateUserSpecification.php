<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Entity\User;
use App\Domain\Criteria\UsersCriteriaInterface;
use App\Domain\ValueObject\DbDateTimeFormat;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserSpecification
 * @package App\Domain\Specification
 */
class CreateUserSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersCriteriaInterface
     */
    protected $criteria;
    
    /**
     * CreateUserSpecification constructor.
     * @param UsersCriteriaInterface $criteria
     */
    public function __construct(UsersCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|User $entity
     * @return bool
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if ($entity->isDeleted()) {
            return false;
        }
    
        if ($entity->isFrozen()) {
            return false;
        
        }
        
        if (!is_string($entity->getUserId())) {
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
     * @param EntityInterface|User $entity
     * @return bool
     */
    public function create(EntityInterface $entity): bool
    {
        if (!$entity instanceof User) {
            throw new \RuntimeException("Not Match Entity");
        }
        
        $attribute = [
            'user_id'         => $entity->getUserId(),
            'name'            => $entity->getName(),
            'last_login_time' =>
                (new \DateTime)
                    ->setTimestamp($entity->getLastLoginTime())
                    ->format(DbDateTimeFormat::FORMAT),
            'updated_at'      =>
                (new \DateTime)
                    ->setTimestamp($entity->getUpdatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
            'created_at'      =>
                (new \DateTime)
                    ->setTimestamp($entity->getCreatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->add($attribute);
    }
}
