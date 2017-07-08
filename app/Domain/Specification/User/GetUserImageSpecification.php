<?php
declare(strict_types=1);

namespace App\Domain\Specification\User;

use App\Domain\Entity\User;
use App\Domain\Entity\Image;
use App\Domain\Entity\UserImage;
use App\Domain\Criteria\UsersImageCriteriaInterface;
use App\Domain\ValueObject\ImageExt;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class GetUserImageSpecification
 * @package App\Domain\Specification\User
 */
class GetUserImageSpecification implements SpecificationInterface, CriteriaBuilderInterface
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
     * @param EntityInterface|User $entity
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        return !empty($entity->getUserId());
    }
    
    /**
     * {@inheritdoc}
     */
    public function build(): CriteriaInterface
    {
        return $this->criteria;
    }
    
    /**
     * @param EntityInterface $user
     * @return UserImage
     * @throws \ErrorException
     */
    public function get(EntityInterface $user): UserImage
    {
        if (!$user instanceof User) {
            throw new \RuntimeException("Not Match User");
        }
        
        if (!$this->isSatisfiedBy($user)) {
            throw new \RuntimeException("Not Satisfied By Entity");
        }
        
        $imageData = $this->criteria->findByUserId($user->getUserId());
        $image     = new Image();
        
        if (!empty($imageData)) {
            $image->setImageId($imageData['image_id']);
            $image->setPath($imageData['path']);
            $image->setFileName($imageData['filename']);
            $image->setExt(ImageExt::get($imageData['ext']));
        }
        
        return new UserImage($user, $image);
    }
}
