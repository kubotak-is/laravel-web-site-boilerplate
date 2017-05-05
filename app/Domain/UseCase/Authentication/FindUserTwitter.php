<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserTwitter;
use App\Domain\Repository\UsersTwitterRepository;
use App\Domain\Specification\Authentication\FindUserTwitterSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class FindUserTwitter
 * @package App\Domain\UseCase\Authentication
 */
class FindUserTwitter implements UsecaseInterface
{
    /**
     * @var FindUserTwitterSpecification
     */
    private $findUserTwitterSpecification;
    
    
    public function __construct(FindUserTwitterSpecification $specification)
    {
        $this->findUserTwitterSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserTwitter $user
     * @return UserTwitter|bool
     */
    public function run(EntityInterface $userTwitter)
    {
        return (new UsersTwitterRepository($this->findUserTwitterSpecification))
            ->find($userTwitter);
    }
}
