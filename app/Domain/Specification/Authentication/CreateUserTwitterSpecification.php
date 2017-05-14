<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Entity\UserTwitter;
use App\Domain\ValueObject\DbDateTimeFormat;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersTwitterCriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserTwitterSpecification
 * @package App\Domain\Specification\Authentication
 */
class CreateUserTwitterSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersTwitterCriteriaInterface
     */
    protected $criteria;
    
    /**
     * CreateUserTwitterSpecification constructor.
     * @param UsersTwitterCriteriaInterface $criteria
     */
    public function __construct(UsersTwitterCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserTwitter $entity
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
     * @param EntityInterface|UserTwitter $entity
     * @return bool
     */
    public function create(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserTwitter) {
            throw new \RuntimeException("Not Match UserTwitter");
        }
        
        $attribute = [
            'user_id'      => $entity->getUser()->getUserId(),
            'twitter_id'   => $entity->getTwitterId(),
            'nickname'     => $entity->getNickname(),
            'token'        => $entity->getToken(),
            'token_secret' => $entity->getTokenSecret(),
            'updated_at'   =>
                (new \DateTime)
                    ->setTimestamp($entity->getUpdatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
            'created_at'   =>
                (new \DateTime)
                    ->setTimestamp($entity->getCreatedAt())
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->add($attribute);
    }
}
