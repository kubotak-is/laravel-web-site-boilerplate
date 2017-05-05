<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserTwitter;
use App\Domain\Repository\UsersTwitterRepository;
use App\Domain\Specification\Authentication\CreateUserTwitterSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToUserTwitter
 * @package App\Domain\UseCase\Authentication
 */
class RegistrationToUserTwitter implements UsecaseInterface
{
    /**
     * @var CreateUserTwitterSpecification
     */
    private $createUserTwitterSpecification;
    
    /**
     * RegistrationToUserFacebook constructor.
     * @param CreateUserTwitterSpecification $specification
     */
    public function __construct(CreateUserTwitterSpecification $specification)
    {
        $this->createUserTwitterSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserTwitter $user
     * @return bool
     */
    public function run(EntityInterface $userTwitter): bool
    {
        return (new UsersTwitterRepository($this->createUserTwitterSpecification))
            ->create($userTwitter);
    }
}
