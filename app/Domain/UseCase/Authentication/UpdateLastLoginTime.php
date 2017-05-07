<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\User;
use App\Domain\Repository\UsersRepository;
use App\Domain\Specification\Authentication\UpdateLastLoginTimeSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class UpdateLastLoginTime
 * @package App\Domain\UseCase\Authentication
 */
class UpdateLastLoginTime implements UsecaseInterface
{
    /**
     * @var UpdateLastLoginTimeSpecification
     */
    private $updateLastLoginTimeSpecification;
    
    /**
     * UpdateLastLoginTime constructor.
     * @param UpdateLastLoginTimeSpecification $specification
     */
    public function __construct(
        UpdateLastLoginTimeSpecification $specification
    )
    {
        $this->updateLastLoginTimeSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|User $user
     * @return bool
     */
    public function run(EntityInterface $user): bool
    {
        return (new UsersRepository($this->updateLastLoginTimeSpecification))
            ->update($user);
    }
}
