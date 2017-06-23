<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Image;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class ImagesRepository
 * @package App\Domain\Repository
 */
class ImagesRepository
{
    /**
     * @var SpecificationInterface
     */
    private $specification;
    
    /**
     * ImagesRepository constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }
    
    /**
     * @param Image $entity
     * @return int
     */
    public function save(Image $entity): Image
    {
        return $this->specification->save($entity);
    }
}
