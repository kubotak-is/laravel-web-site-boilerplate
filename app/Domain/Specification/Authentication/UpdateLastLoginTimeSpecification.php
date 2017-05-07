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
 * Class UpdateLastLoginTimeSpecification
 * @package App\Domain\Specification\Authentication
 */
class UpdateLastLoginTimeSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersCriteriaInterface
     */
    protected $criteria;
    
    /**
     * UpdateLastLoginTimeSpecification constructor.
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
        if (empty($entity->getUserId())) {
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
    public function update(EntityInterface $entity): bool
    {
        if (!$entity instanceof User) {
            throw new \RuntimeException("Not Match User");
        }
        
        if (!$this->isSatisfiedBy($entity)) {
            throw new \ErrorException("Not Satisfied Entity");
        }
        
        $attribute = [
            'last_login_time' =>
                (new \DateTime)
                    ->format(DbDateTimeFormat::FORMAT),
            'updated_at' =>
                (new \DateTime)
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->update($entity->getUserId(), $attribute);
    }
}
