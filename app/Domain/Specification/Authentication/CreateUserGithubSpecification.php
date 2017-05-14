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
 * Class CreateUserGithubSpecification
 * @package App\Domain\Specification\Authentication
 *
 */
class CreateUserGithubSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersGithubCriteriaInterface
     */
    protected $criteria;
    
    /**
     * CreateUserGithubSpecification constructor.
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
    public function create(EntityInterface $entity): bool
    {
        if (!$entity instanceof UserGithub) {
            throw new \RuntimeException("Not Match UserGithub");
        }
        
        $attribute = [
            'user_id'    => $entity->getUser()->getUserId(),
            'github_id'  => $entity->getGithubId(),
            'nickname'   => $entity->getNickname(),
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
