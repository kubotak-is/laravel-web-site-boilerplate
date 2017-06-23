<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\ImageExt;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class Image
 * @package App\Domain\Entity
 */
class Image implements AggregateRoot, EntityInterface
{
    /**
     * @var int|null
     */
    private $imageId;
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * @var string
     */
    private $fileName;
    
    /**
     * @var string
     */
    private $ext;
    
    /**
     * Image constructor.
     * @param int|null $imageId
     */
    public function __construct(int $imageId = null)
    {
        $this->imageId = $imageId;
    }
    
    /**
     * @param int $imageId
     */
    public function setImageId(int $imageId)
    {
        if (is_null($this->imageId)) {
            $this->imageId = $imageId;
        }
    }
    
    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }
    
    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }
    
    /**
     * @param string $ext
     */
    public function setExt(ImageExt $ext)
    {
        $this->ext = $ext->toNative();
    }
    
    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->imageId;
    }
    
    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
    
    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
    
    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }
    
    /**
     * @param string $suffix
     * @return string
     * FIXME suffix is enum?
     */
    public function getImagePath(string $suffix = ''): string
    {
        return "{$this->path}/{$this->fileName}{$suffix}.{$this->ext}";
    }
}
