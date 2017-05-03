<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserEmail;
use App\Domain\Repository\UsersMailRepository;
use App\Domain\Specification\Authentication\CreateUserEmailSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToUserEmail
 * @package App\Domain\UseCase
 */
class RegistrationToUserEmail implements UsecaseInterface
{
    /**
     * @var CreateUserEmailSpecification
     */
    private $createUserMailSpecification;
    
    /**
     * RegistrationToUserEmail constructor.
     * @param CreateUserEmailSpecification $specification
     */
    public function __construct(CreateUserEmailSpecification $specification)
    {
        $this->createUserMailSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserEmail $user
     * @return bool
     */
    public function run(EntityInterface $userEmail): bool
    {
        return (new UsersMailRepository($this->createUserMailSpecification))
            ->create($userEmail);
    }
}