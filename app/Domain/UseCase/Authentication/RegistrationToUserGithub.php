<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserGithub;
use App\Domain\Repository\UsersGithubRepository;
use App\Domain\Specification\Authentication\CreateUserGithubSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToUserGithub
 * @package App\Domain\UseCase\Authentication
 */
class RegistrationToUserGithub implements UsecaseInterface
{
    /**
     * @var CreateUserGithubSpecification
     */
    private $createUserGithubSpecification;
    
    /**
     * RegistrationToUserGithub constructor.
     * @param CreateUserGithubSpecification $specification
     */
    public function __construct(CreateUserGithubSpecification $specification)
    {
        $this->createUserGithubSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserGithub $userGithub
     * @return bool
     */
    public function run(EntityInterface $userGithub): bool
    {
        return (new UsersGithubRepository($this->createUserGithubSpecification))
            ->create($userGithub);
    }
}
