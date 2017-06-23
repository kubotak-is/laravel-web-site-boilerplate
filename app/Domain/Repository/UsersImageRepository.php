<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Image;
use App\Domain\Entity\User;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersImageRepository
 * @package App\Domain\Repository
 */
class UsersImageRepository
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
     * @param User  $user
     * @param Image $image
     * @return bool
     */
    public function create(User $user, Image $image): bool
    {
        return $this->specification->create($user, $image);
    }
    
    /**
     * @param User $entity
     * @return bool
     */
    public function delete(User $entity): bool
    {
        return $this->specification->delete($entity);
    }
}
