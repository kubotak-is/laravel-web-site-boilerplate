<?php
declare(strict_types=1);

namespace App\Domain\Specification\Authentication;

use App\Domain\Criteria\UsersGithubCriteriaInterface;
use App\Domain\Entity\User;
use App\Domain\Entity\UserGithub;
use App\Domain\Exception\Authentication\UserFrozenException;
use App\Domain\Exception\NotFoundResourceException;
use App\Domain\ValueObject\GithubId;
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserGithubSpecification
 * @package App\Domain\Specification\Authentication
 */
class FindUserGithubSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersGithubCriteriaInterface
     */
    protected $criteria;
    
    /**
     * FindUserGithubSpecification constructor.
     * @param UsersGithubCriteriaInterface $criteria
     */
    public function __construct(UsersGithubCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|UserGithub $entity
     * @return bool
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if ($entity->getUser()->isFrozen()) {
            return false;
        }
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function build(): CriteriaInterface
    {
        return $this->criteria;
    }
    
    /**
     * @param EntityInterface $entity
     * @return UserGithub
     * @throws NotFoundResourceException
     */
    public function find(EntityInterface $entity): UserGithub
    {
        if (!$entity instanceof UserGithub) {
            throw new \RuntimeException("Not Match UserGithub");
        }
        
        $result = $this->criteria->findByGithubId($entity->getGithubId());
        
        if (empty($result)) {
            throw new NotFoundResourceException("Not Found UserGithub");
        }
        
        $user = new User(new UserId($result['user_id']));
        $user->setName($result['name']);
        $user->setFlag((bool)$result['frozen'], false);
        $user->setLastLoginTime(new \DateTime($result['last_login_time']));
        $user->setUpdatedAt(new \DateTime($result['user.updated_at']));
        $user->setCreatedAt(new \DateTime($result['user.created_at']));
        
        $github = new UserGithub($user, new GithubId($result['github_id']));
        $github->setToken($result['token']);
        $github->setNickname($result['nickname']);
        $github->setUpdatedAt(new \DateTime($result['updated_at']));
        $github->setCreatedAt(new \DateTime($result['created_at']));
    
        if (!$this->isSatisfiedBy($github)) {
            throw new UserFrozenException();
        }
        
        return $github;
    }
}
