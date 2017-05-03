<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserEmail;
use App\Domain\Repository\UsersMailRepository;
use App\Domain\Specification\Authentication\FindUserEmailSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class FindUserEmail
 * @package App\Domain\UseCase\Authentication
 */
class FindUserEmail implements UsecaseInterface
{
    /**
     * @var FindUserEmailSpecification
     */
    private $findUserEmailSpecification;
    
    /**
     * FindUserEmail constructor.
     * @param FindUserEmailSpecification $specification
     */
    public function __construct(FindUserEmailSpecification $specification)
    {
        $this->findUserEmailSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserEmail $user
     * @return UserEmail
     */
    public function run(EntityInterface $userEmail)
    {
        return (new UsersMailRepository($this->findUserEmailSpecification))
            ->find($userEmail);
    }
}
