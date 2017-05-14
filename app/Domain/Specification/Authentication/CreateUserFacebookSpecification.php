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
 * Class CreateUserFacebookSpecification
 * @package App\Domain\Specification\Authentication
 */
class CreateUserFacebookSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersFacebookCriteriaInterface
     */
    protected $criteria;
    
    /**
     * CreateUserFacebookSpecification constructor.
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
    public function create(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserFacebook) {
            throw new \RuntimeException("Not Match UserFacebook");
        }
        
        $attribute = [
            'user_id'     => $entity->getUser()->getUserId(),
            'facebook_id' => $entity->getFacebookId(),
            'token'       => $entity->getToken(),
            'updated_at'  =>
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
