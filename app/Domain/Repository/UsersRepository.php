<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersRepository
 * @package App\Domain\Repository
 */
class UsersRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * UsersRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param User $entity
     * @return bool
     */
    public function create(User $entity): bool
    {
        return $this->specification->create($entity);
    }
    
    /**
     * @param User $entity
     * @return mixed
     */
    public function update(User $entity)
    {
        return $this->specification->update($entity);
    }
    
    /**
     * @param User $entity
     * @return User
     */
    public function get(User $entity): User
    {
        return $this->specification->get($entity);
    }
}
