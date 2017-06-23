<?php
declare(strict_types=1);

namespace App\Domain\UseCase\Image;

use App\Domain\Entity\Image;
use App\Domain\Repository\ImagesRepository;
use App\Domain\Specification\Image\SaveImageSpecification;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\UsecaseInterface;

/**
 * Class SaveImage
 * @package App\Domain\UseCase\Image
 */
class SaveImage implements UsecaseInterface
{
    /**
     * @var SaveImageSpecification
     */
    private $saveImageSpecification;
    
    /**
     * SaveImage constructor.
     * @param SaveImageSpecification $specification
     */
    public function __construct(SaveImageSpecification $specification)
    {
        $this->saveImageSpecification = $specification;
    }
    
    /**
     * @param EntityInterface|Image $image
     * @return Image
     */
    public function run(EntityInterface $image): Image
    {
        return (new ImagesRepository($this->saveImageSpecification))
            ->save($image);
    }
}
