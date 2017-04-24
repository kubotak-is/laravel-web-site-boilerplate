<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserEmail;
use App\Domain\Specification\CreateMailUserSpecification;

/**
 * Class CreateMailUserRepository
 * @package App\Domain\Repository
 */
class CreateMailUserRepository
{
    /**
     * @var UserEmail
     */
    private $entity;
    
    /**
     * CreateMailUserRepository constructor.
     * @param UserEmail $entity
     */
    public function __construct(UserEmail $entity)
    {
        $this->entity = $entity;
    }
    
    /**
     * @param CreateMailUserSpecification $specification
     * @return bool
     */
    public function create(CreateMailUserSpecification $specification): bool
    {
        return $specification->create($this->entity);
    }
}
