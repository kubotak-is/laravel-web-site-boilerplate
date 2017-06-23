<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Image;

use App\Domain\Entity\User;
use App\Domain\Entity\Image;
use App\Domain\Repository\UsersImageRepository;
use App\Domain\Specification\Image\CreateImageSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class CreateUserImage
 * @package App\Domain\UseCase\Image
 */
class CreateUserImage
{
    /**
     * @var CreateImageSpecification
     */
    private $createUserImageSpecification;
    
    /**
     * SaveImage constructor.
     * @param CreateImageSpecification $specification
     */
    public function __construct(CreateImageSpecification $specification)
    {
        $this->createUserImageSpecification = $specification;
    }
    
    
    /**
     * @param EntityInterface|User $user
     * @param EntityInterface|Image $image
     * @return bool
     */
    public function run(EntityInterface $user, EntityInterface $image): bool
    {
        return (new UsersImageRepository($this->createUserImageSpecification))
            ->create($user, $image);
    }
}
