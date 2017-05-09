<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserGoogle;
use App\Domain\Repository\UsersGoogleRepository;
use App\Domain\Specification\Authentication\UpdateUserGoogleSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class UpdateUserGoogle
 * @package App\Domain\UseCase\Authentication
 */
class UpdateUserGoogle implements UsecaseInterface
{
    /**
     * @var UpdateUserGoogleSpecification
     */
    private $updateUserGoogleSpecification;
    
    /**
     * UpdateUserGoogle constructor.
     * @param UpdateUserGoogleSpecification $specification
     */
    public function __construct(UpdateUserGoogleSpecification $specification)
    {
        $this->updateUserGoogleSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserGoogle $user
     * @return bool
     */
    public function run(EntityInterface $userGoogle): bool
    {
        return (new UsersGoogleRepository($this->updateUserGoogleSpecification))
            ->update($userGoogle);
    }
}