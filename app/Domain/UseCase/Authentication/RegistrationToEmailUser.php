<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserEmail;
use App\Domain\Repository\CreateMailUserRepository;
use App\Domain\Specification\CreateMailUserSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToEmailUser
 * @package App\Domain\UseCase
 */
class RegistrationToEmailUser implements UsecaseInterface
{
    /**
     * @var CreateMailUserSpecification
     */
    private $createMailUserSpecification;
    
    /**
     * RegistrationToEmailUser constructor.
     * @param CreateMailUserSpecification $specification
     */
    public function __construct(CreateMailUserSpecification $specification)
    {
        $this->createMailUserSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserEmail $user
     * @return bool
     */
    public function run(EntityInterface $userEmail): bool
    {
        return (new CreateMailUserRepository($userEmail))
            ->create($this->createMailUserSpecification);
    }
}