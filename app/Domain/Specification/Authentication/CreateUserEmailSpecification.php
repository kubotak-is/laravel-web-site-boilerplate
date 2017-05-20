<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Entity\UserEmail;
use App\Domain\Criteria\UsersMailCriteriaInterface;
use App\Domain\ValueObject\DbDateTimeFormat;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserEmailSpecification
 * @package App\Domain\Specification
 */
class CreateUserEmailSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersMailCriteriaInterface
     */
    protected $criteria;
    
    /**
     * CreateUserSpecification constructor.
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
     * @param EntityInterface|UserEmail $entity
     * @return bool
     */
    public function create(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserEmail) {
            throw new \RuntimeException("Not Match UserEmail");
        }
        
        $attribute = [
            'user_id'    => $entity->getUser()->getUserId(),
            'email'      => $entity->getEmail(),
            'password'   => $entity->getPassword(),
            'updated_at' =>
                (new \DateTime)
                    ->setTimestamp($entity->getUpdatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
            'created_at' =>
                (new \DateTime)
                    ->setTimestamp($entity->getCreatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->add($attribute);
    }
}
