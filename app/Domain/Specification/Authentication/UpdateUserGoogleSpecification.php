<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Criteria\UsersGoogleCriteriaInterface;
use App\Domain\Entity\UserGoogle;
use App\Domain\ValueObject\DbDateTimeFormat;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserGoogleSpecification
 * @package App\Domain\Specification\Authentication
 */
class UpdateUserGoogleSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersGoogleCriteriaInterface
     */
    protected $criteria;
    
    /**
     * UpdateUserGoogleSpecification constructor.
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
        if (empty($entity->getGoogleId())) {
            return false;
        }
        
        if (empty($entity->getToken())) {
            return false;
        }
        
        if (!is_string($entity->getUser()->getUserId())) {
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
     * @param EntityInterface|UserGoogle $entity
     * @return bool
     */
    public function update(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserGoogle) {
            throw new \RuntimeException("Not Match UserGoogle");
        }
    
        if (!$this->isSatisfiedBy($entity)) {
            throw new \RuntimeException("Not Satisfied UserGoogle");
        }
        
        $attribute = [
            'token'      => $entity->getToken(),
            'updated_at' =>
                (new \DateTime)
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->update($entity->getUser()->getUserId(), $attribute);
    }
}
