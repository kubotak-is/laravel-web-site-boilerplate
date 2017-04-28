<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserEmail;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersMailRepository
 * @package App\Domain\Repository
 */
class UsersMailRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * UsersMailRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param UserEmail $entity
     * @return bool
     */
    public function create(UserEmail $entity): bool
    {
        return $this->specification->create($entity);
    }
    
    /**
     * @param UserEmail $entity
     * @return UserEmail
     */
    public function find(UserEmail $entity): UserEmail
    {
        return $this->specification->find($entity);
    }
}
