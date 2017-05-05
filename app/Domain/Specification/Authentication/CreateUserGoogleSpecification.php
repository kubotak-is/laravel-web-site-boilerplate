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
 * Class CreateUserGoogleSpecification
 * @package App\Domain\Specification\Authentication
 */
class CreateUserGoogleSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersGoogleCriteriaInterface
     */
    protected $criteria;
    
    /**
     * CreateUserGoogleSpecification constructor.
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
    public function create(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserGoogle) {
            throw new \RuntimeException("Not Match UserGoogle");
        }
        
        $attribute = [
            'user_id'    => $entity->getUser()->getUserId(),
            'google_id'  => $entity->getGoogleId(),
            'token'      => $entity->getToken(),
            'updated_at' =>
                (new \DateTime)
                    ->setTimestamp($entity->getUpdatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
            'created_at'  =>
                (new \DateTime)
                    ->setTimestamp($entity->getCreatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->add($attribute);
    }
}
