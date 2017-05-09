<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserFacebook;
use App\Domain\Repository\UsersFacebookRepository;
use App\Domain\Specification\Authentication\UpdateUserFacebookSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class UpdateUserFacebook
 * @package App\Domain\UseCase\Authentication
 */
class UpdateUserFacebook implements UsecaseInterface
{
    /**
     * @var UpdateUserFacebookSpecification
     */
    private $updateUserFacebookSpecification;
    
    /**
     * UpdateUserFacebook constructor.
     * @param UpdateUserFacebookSpecification $specification
     */
    public function __construct(UpdateUserFacebookSpecification $specification)
    {
        $this->updateUserFacebookSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserFacebook $user
     * @return bool
     */
    public function run(EntityInterface $userFacebook): bool
    {
        return (new UsersFacebookRepository($this->updateUserFacebookSpecification))
            ->update($userFacebook);
    }
}