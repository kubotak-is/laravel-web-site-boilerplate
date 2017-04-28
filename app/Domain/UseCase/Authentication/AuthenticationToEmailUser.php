<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserEmail;
use App\Domain\Repository\UsersMailRepository;
use App\Domain\Specification\Authentication\CreateMailUserSpecification;
use App\Domain\Specification\Authentication\FindMailUserSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class AuthenticationToEmailUser
 * @package App\Domain\UseCase\Authentication
 */
class AuthenticationToEmailUser implements UsecaseInterface
{
    /**
     * @var FindMailUserSpecification
     */
    private $findMailUserSpecification;
    
    /**
     * AuthenticationToEmailUser constructor.
     * @param FindMailUserSpecification $specification
     */
    public function __construct(FindMailUserSpecification $specification)
    {
        $this->findMailUserSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserEmail $user
     * @return bool
     */
    public function run(EntityInterface $userEmail): UserEmail
    {
        return (new UsersMailRepository($this->findMailUserSpecification))
            ->find($userEmail);
    }
}