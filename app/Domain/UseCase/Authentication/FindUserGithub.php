<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserGithub;
use App\Domain\Repository\UsersGithubRepository;
use App\Domain\Specification\Authentication\FindUserGithubSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class FindUserGithub
 * @package App\Domain\UseCase\Authentication
 */
class FindUserGithub implements UsecaseInterface
{
    /**
     * @var FindUserGithubSpecification
     */
    private $findUserGithubSpecification;
    
    /**
     * FindUserGithub constructor.
     * @param FindUserGithubSpecification $specification
     */
    public function __construct(FindUserGithubSpecification $specification)
    {
        $this->findUserGithubSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserGithub $userGithub
     * @return UserGithub|bool
     */
    public function run(EntityInterface $userGithub)
    {
        return (new UsersGithubRepository($this->findUserGithubSpecification))
            ->find($userGithub);
    }
}
