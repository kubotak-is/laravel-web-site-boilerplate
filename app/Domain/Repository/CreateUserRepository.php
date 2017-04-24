<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Specification\CreateUserSpecification;

/**
 * Class CreateUserRepository
 * @package App\Domain\Repository
 */
class CreateUserRepository
{
    /**
     * @var User
     */
    private $entity;
    
    /**
     * CreateUserRepository constructor.
     * @param User $entity
     */
    public function __construct(User $entity)
    {
        $this->entity = $entity;
    }
    
    /**
     * @param CreateUserSpecification $specification
     * @return bool
     */
    public function create(CreateUserSpecification $specification): bool
    {
        return $specification->create($this->entity);
    }
}
