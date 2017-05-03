<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserFacebook;
use App\Domain\Repository\UsersFacebookRepository;
use App\Domain\Specification\Authentication\FindUserEmailSpecification;
use App\Domain\Specification\Authentication\FindUserFacebookSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class FindUserEmail
 * @package App\Domain\UseCase\Authentication
 */
class FindUserFacebook implements UsecaseInterface
{
    /**
     * @var FindUserEmailSpecification
     */
    private $findUserFacebookSpecification;
    
    /**
     * FindUserFacebook constructor.
     * @param FindUserFacebookSpecification $specification
     */
    public function __construct(FindUserFacebookSpecification $specification)
    {
        $this->findUserFacebookSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserFacebook $user
     * @return UserFacebook|bool
     */
    public function run(EntityInterface $userFacebook)
    {
        return (new UsersFacebookRepository($this->findUserFacebookSpecification))
            ->find($userFacebook);
    }
}
