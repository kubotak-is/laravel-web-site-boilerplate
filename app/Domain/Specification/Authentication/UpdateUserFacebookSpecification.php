<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Criteria\UsersFacebookCriteriaInterface;
use App\Domain\Entity\UserFacebook;
use App\Domain\ValueObject\DbDateTimeFormat;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserFacebookSpecification
 * @package App\Domain\Specification\Authentication
 */
class UpdateUserFacebookSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersFacebookCriteriaInterface
     */
    protected $criteria;
    
    /**
     * UpdateUserFacebookSpecification constructor.
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
        if (empty($entity->getFacebookId())) {
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
     * @param EntityInterface|UserFacebook $entity
     * @return bool
     */
    public function update(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserFacebook) {
            throw new \RuntimeException("Not Match UserFacebook");
        }
        
        if (!$this->isSatisfiedBy($entity)) {
            throw new \RuntimeException("Not Satisfied UserFacebook");
        }
        
        $attribute = [
            'token'       => $entity->getToken(),
            'updated_at'  =>
                (new \DateTime)
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->update($entity->getUser()->getUserId(), $attribute);
    }
}
