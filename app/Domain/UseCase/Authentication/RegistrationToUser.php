<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\User;
use App\Domain\Repository\CreateUserRepository;
use App\Domain\Specification\CreateUserSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToUser
 * @package App\Domain\UseCase
 */
class RegistrationToUser implements UsecaseInterface
{
    /**
     * @var CreateUserSpecification
     */
    private $createUserSpecification;
    
    /**
     * RegistrationToEmailUser constructor.
     * @param CreateUserSpecification $specification
     */
    public function __construct(
        CreateUserSpecification $specification
    )
    {
        $this->createUserSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|User $user
     * @return bool
     */
    public function run(EntityInterface $user): bool
    {
        return (new CreateUserRepository($user))
            ->create($this->createUserSpecification);
    }
}
