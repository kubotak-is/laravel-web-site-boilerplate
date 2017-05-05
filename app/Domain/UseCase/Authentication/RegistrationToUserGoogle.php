<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserGoogle;
use App\Domain\Repository\UsersGoogleRepository;
use App\Domain\Specification\Authentication\CreateUserGoogleSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToUserGoogle
 * @package App\Domain\UseCase\Authentication
 */
class RegistrationToUserGoogle implements UsecaseInterface
{
    /**
     * @var CreateUserGoogleSpecification
     */
    private $createUserGoogleSpecification;
    
    /**
     * RegistrationToUserGoogle constructor.
     * @param CreateUserGoogleSpecification $specification
     */
    public function __construct(CreateUserGoogleSpecification $specification)
    {
        $this->createUserGoogleSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserGoogle $user
     * @return bool
     */
    public function run(EntityInterface $userGoogle): bool
    {
        return (new UsersGoogleRepository($this->createUserGoogleSpecification))
            ->create($userGoogle);
    }
}