<?php
declare(strict_types=1);

namespace App\Domain\UseCase\User;

use App\Domain\Entity\User;
use App\Domain\Entity\UserImage;
use App\Domain\Repository\UsersImageRepository;
use App\Domain\Specification\User\GetUserImageSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class CreateUserImage
 * @package App\Domain\UseCase\Image
 */
class GetUserImage implements UsecaseInterface
{
    /**
     * @var GetUserImageSpecification
     */
    private $getUserImageSpecification;
    
    /**
     * GetUserImage constructor.
     * @param GetUserImageSpecification $specification
     */
    public function __construct(GetUserImageSpecification $specification)
    {
        $this->getUserImageSpecification = $specification;
    }
    
    
    /**
     * @param EntityInterface|User $user
     * @return UserImage
     */
    public function run(EntityInterface $user): UserImage
    {
        return (new UsersImageRepository($this->getUserImageSpecification))
            ->get($user);
    }
}
