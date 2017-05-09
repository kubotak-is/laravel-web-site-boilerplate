<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Criteria\UsersGithubCriteriaInterface;
use App\Domain\Entity\UserGithub;
use App\Domain\ValueObject\DbDateTimeFormat;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserGithubSpecification
 * @package App\Domain\Specification\Authentication
 */
class UpdateUserGithubSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersGithubCriteriaInterface
     */
    protected $criteria;
    
    /**
     * UpdateUserGithubSpecification constructor.
     * @param UsersGithubCriteriaInterface $criteria
     */
    public function __construct(UsersGithubCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserGithub $entity
     * @return bool
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if (empty($entity->getGithubId())) {
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
     * @param EntityInterface|UserGithub $entity
     * @return bool
     */
    public function update(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserGithub) {
            throw new \RuntimeException("Not Match UserGithub");
        }
        
        if (!$this->isSatisfiedBy($entity)) {
            throw new \RuntimeException("Not Satisfied UserGithub");
        }
        
        $attribute = [
            'nickname'   => $entity->getNickname(),
            'token'      => $entity->getToken(),
            'updated_at' =>
                (new \DateTime)
                    ->format(DbDateTimeFormat::FORMAT),
        ];
        return (bool) $this->criteria->update($entity->getUser()->getUserId(), $attribute);
    }
}
