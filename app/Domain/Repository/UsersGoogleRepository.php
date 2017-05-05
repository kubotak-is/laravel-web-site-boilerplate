<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserGoogle;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersGoogleRepository
 * @package App\Domain\Repository
 */
class UsersGoogleRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * UsersGoogleRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param UserGoogle $entity
     * @return bool
     */
    public function create(UserGoogle $entity): bool
    {
        return $this->specification->create($entity);
    }
    
    /**
     * @param UserGoogle $entity
     * @return UserGoogle
     */
    public function find(UserGoogle $entity): UserGoogle
    {
        return $this->specification->find($entity);
    }
}
