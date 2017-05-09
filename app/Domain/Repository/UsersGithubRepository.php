<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserGithub;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersGithubRepository
 * @package App\Domain\Repository
 */
class UsersGithubRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * UsersGithubRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param UserGithub $entity
     * @return bool
     */
    public function create(UserGithub $entity): bool
    {
        return $this->specification->create($entity);
    }
    
    /**
     * @param UserGithub $entity
     * @return UserGithub
     */
    public function find(UserGithub $entity): UserGithub
    {
        return $this->specification->find($entity);
    }
    
    /**
     * @param UserGithub $entity
     * @return mixed
     */
    public function update(UserGithub $entity)
    {
        return $this->specification->update($entity);
    }
}
