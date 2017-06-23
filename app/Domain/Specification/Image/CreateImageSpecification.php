<?php
declare(strict_types=1);

namespace App\Domain\Specification\Image;

use App\Domain\Entity\Image;
use App\Domain\Entity\User;
use App\Domain\Criteria\UsersImageCriteriaInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateImageSpecification
 * @package App\Domain\Specification\Image
 */
class CreateImageSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var UsersImageCriteriaInterface
     */
    protected $criteria;
    
    /**
     * SaveImageSpecification constructor.
     * @param UsersImageCriteriaInterface $criteria
     */
    public function __construct(UsersImageCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|Image $entity
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
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
     * @param EntityInterface|User $user
     * @param EntityInterface|Image $image
     * @return bool
     */
    public function create(EntityInterface $user, EntityInterface $image): bool
    {
        if (!$user instanceof User) {
            throw new \RuntimeException("Not Match User");
        }
        
        if (!$image instanceof Image) {
            throw new \RuntimeException("Not Match Image");
        }
        
        // 既にユーザーイメージとのヒモ付があれば削除
        if ($this->criteria->findByUserId($user->getUserId())) {
            if (!$this->criteria->deleteAtUserId($user->getUserId())) {
                throw new \ErrorException("Failed Delete User Image: {$user->getUserId()}");
            }
        }
        
        return $this->criteria->add($user->getUserId(), $image->getImageId());
    }
}
