<?php
declare(strict_types=1);

namespace App\Domain\Specification\Image;

use App\Domain\Entity\Image;
use App\Domain\ValueObject\DbDateTimeFormat;
use App\Domain\Criteria\ImagesCriteriaInterface;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class SaveImageSpecification
 * @package App\Domain\Specification\Image
 */
class SaveImageSpecification implements SpecificationInterface, CriteriaBuilderInterface
{
    /**
     * @var ImagesCriteriaInterface
     */
    protected $criteria;
    
    /**
     * SaveImageSpecification constructor.
     * @param ImagesCriteriaInterface $criteria
     */
    public function __construct(ImagesCriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }
    
    /**
     * @param EntityInterface|Image $entity
     */
    public function isSatisfiedBy(EntityInterface $entity): bool
    {
        if (
            $entity->getImagePath() &&
            $entity->getFileName() &&
            $entity->getExt()
        ) {
            return true;
        }
        return false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function build(): CriteriaInterface
    {
        return $this->criteria;
    }
    
    /**
     * @param EntityInterface|Image $entity
     * @return Image
     */
    public function save(EntityInterface $entity): Image
    {
        if (!$entity instanceof Image) {
            throw new \RuntimeException("Not Match Image");
        }
        
        $attribute = [
            'path'       => $entity->getPath(),
            'filename'   => $entity->getFileName(),
            'ext'        => $entity->getExt(),
            'created_at' => (new \DateTime())->format(DbDateTimeFormat::FORMAT),
        ];
        
        $imageId = (int) $this->criteria->add($attribute);
        $entity->setImageId($imageId);
        return $entity;
    }
}
