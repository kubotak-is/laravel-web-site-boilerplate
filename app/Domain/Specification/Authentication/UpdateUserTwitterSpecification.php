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
 * Class UpdateUserTwitterSpecification
 * @package App\Domain\Specification\Authentication
 */
class UpdateUserTwitterSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersTwitterCriteriaInterface
     */
    protected $criteria;
    
    /**
     * UpdateUserTwitterSpecification constructor.
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
        if (empty($entity->getTwitterId())) {
            return false;
        }
        
        if (empty($entity->getToken())) {
            return false;
        }
    
        if (empty($entity->getTokenSecret())) {
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
     * @param EntityInterface|UserTwitter $entity
     * @return bool
     */
    public function update(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserTwitter) {
            throw new \RuntimeException("Not Match UserTwitter");
        }
    
        if (!$this->isSatisfiedBy($entity)) {
            throw new \RuntimeException("Not Satisfied UserTwitter");
        }
        
        $attribute = [
            'nickname'     => $entity->getNickname(),
            'token'        => $entity->getToken(),
            'token_secret' => $entity->getTokenSecret(),
            'updated_at'   =>
                (new \DateTime)
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->update($entity->getUser()->getUserId(), $attribute);
    }
}
