<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserTwitter;
use App\Domain\Repository\UsersTwitterRepository;
use App\Domain\Specification\Authentication\UpdateUserTwitterSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class UpdateUserTwitter
 * @package App\Domain\UseCase\Authentication
 */
class UpdateUserTwitter implements UsecaseInterface
{
    /**
     * @var UpdateUserTwitterSpecification
     */
    private $updateUserTwitterSpecification;
    
    /**
     * UpdateUserTwitter constructor.
     * @param UpdateUserTwitterSpecification $specification
     */
    public function __construct(UpdateUserTwitterSpecification $specification)
    {
        $this->updateUserTwitterSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserTwitter $user
     * @return bool
     */
    public function run(EntityInterface $userTwitter): bool
    {
        return (new UsersTwitterRepository($this->updateUserTwitterSpecification))
            ->update($userTwitter);
    }
}
