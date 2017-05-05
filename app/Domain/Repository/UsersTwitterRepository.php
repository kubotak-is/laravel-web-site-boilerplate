<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserTwitter;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersFacebookRepository
 * @package App\Domain\Repository
 */
class UsersTwitterRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * UsersTwitterRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param UserTwitter $entity
     * @return bool
     */
    public function create(UserTwitter $entity): bool
    {
        return $this->specification->create($entity);
    }
    
    /**
     * @param UserTwitter $entity
     * @return UserTwitter
     */
    public function find(UserTwitter $entity): UserTwitter
    {
        return $this->specification->find($entity);
    }
}
