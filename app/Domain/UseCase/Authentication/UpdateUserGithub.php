<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserGithub;
use App\Domain\Repository\UsersGithubRepository;
use App\Domain\Specification\Authentication\UpdateUserGithubSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class UpdateUserGithub
 * @package App\Domain\UseCase\Authentication
 */
class UpdateUserGithub implements UsecaseInterface
{
    /**
     * @var UpdateUserGithubSpecification
     */
    private $updateUserGithubSpecification;
    
    /**
     * UpdateUserGithub constructor.
     * @param UpdateUserGithubSpecification $specification
     */
    public function __construct(UpdateUserGithubSpecification $specification)
    {
        $this->updateUserGithubSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserGithub $userGithub
     * @return bool
     */
    public function run(EntityInterface $userGithub): bool
    {
        return (new UsersGithubRepository($this->updateUserGithubSpecification))
            ->update($userGithub);
    }
}
