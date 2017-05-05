<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Authentication;

use App\Domain\Entity\UserGoogle;
use App\Domain\Repository\UsersGoogleRepository;
use App\Domain\Specification\Authentication\FindUserGoogleSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class FindUserGoogle
 * @package App\Domain\UseCase\Authentication
 */
class FindUserGoogle implements UsecaseInterface
{
    /**
     * @var FindUserGoogleSpecification
     */
    private $findUserGoogleSpecification;
    
    
    public function __construct(FindUserGoogleSpecification $specification)
    {
        $this->findUserGoogleSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|UserGoogle $userGoogle
     * @return UserGoogle|bool
     */
    public function run(EntityInterface $userGoogle)
    {
        return (new UsersGoogleRepository($this->findUserGoogleSpecification))
            ->find($userGoogle);
    }
}
