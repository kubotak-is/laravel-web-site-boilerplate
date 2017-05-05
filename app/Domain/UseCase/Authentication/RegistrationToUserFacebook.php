<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserFacebook;
use App\Domain\Repository\UsersFacebookRepository;
use App\Domain\Specification\Authentication\CreateUserFacebookSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class RegistrationToUserFacebook
 * @package App\Domain\UseCase\Authentication
 */
class RegistrationToUserFacebook implements UsecaseInterface
{
    /**
     * @var CreateUserFacebookSpecification
     */
    private $createUserFacebookSpecification;
    
    /**
     * RegistrationToUserFacebook constructor.
     * @param CreateUserFacebookSpecification $specification
     */
    public function __construct(CreateUserFacebookSpecification $specification)
    {
        $this->createUserFacebookSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserFacebook $user
     * @return bool
     */
    public function run(EntityInterface $userFacebook): bool
    {
        return (new UsersFacebookRepository($this->createUserFacebookSpecification))
            ->create($userFacebook);
    }
}