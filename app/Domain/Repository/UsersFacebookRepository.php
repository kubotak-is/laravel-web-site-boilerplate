<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserFacebook;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersFacebookRepository
 * @package App\Domain\Repository
 */
class UsersFacebookRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * UsersFacebookRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param UserFacebook $entity
     * @return bool
     */
    public function create(UserFacebook $entity): bool
    {
        return $this->specification->create($entity);
    }
    
    /**
     * @param UserFacebook $entity
     * @return UserFacebook
     */
    public function find(UserFacebook $entity): UserFacebook
    {
        return $this->specification->find($entity);
    }
    
    /**
     * @param UserFacebook $entity
     * @return mixed
     */
    public function update(UserFacebook $entity)
    {
        return $this->specification->update($entity);
    }
}
