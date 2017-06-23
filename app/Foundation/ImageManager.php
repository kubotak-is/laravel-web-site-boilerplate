<?php
declare(strict_types=1);

namespace App\Foundation;

use App\Domain\Entity\Image as DomainImage;
use App\Domain\ValueObject\ImageExt;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager as Image;

/**
 * Class ImageManager
 * @package App\Foundation
 */
class ImageManager
{
    /**
     * @var Image
     */
    protected $image;
    
    /**
     * @var Filesystem
     */
    protected $file;
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * @var null|string
     */
    private $fullPath = null;
    
    /**
     * ImageManager constructor.
     * @param Image $image
     */
    public function __construct(Image $image, Filesystem $file)
    {
        $this->image = $image;
        $this->file  = $file;
    }
    
    /**
     * @param string $path
     * @return void
     */
    public function setSavePath(string $path)
    {
        $this->path     = '/images/' . $path;
        $this->fullPath = public_path() . $this->path;
        if (!$this->file->exists($this->fullPath)) {
            $this->file->makeDirectory($this->fullPath);
        }
    }
    
    /**
     * @param mixed $file
     * @param int    $normal
     * @param int    $thumbnail
     * @return DomainImage
     * @throws \ErrorException
     */
    public function create($file, $normal = 300, $thumbnail = 150): DomainImage
    {
        if (is_null($this->fullPath)) {
            throw new \ErrorException("not set save path");
        }
        $image    = $this->image->make($file);
        $fileName = $this->makeRandStr();
        $ext      = ImageExt::PNG;
        
        $image->save($this->fullPath . "/{$fileName}_original.{$ext}")
            ->resize($normal, $normal)
            ->save($this->fullPath . "/{$fileName}.{$ext}")
            ->resize($thumbnail, $thumbnail)
            ->save($this->fullPath . "/{$fileName}_thumbnail.{$ext}");
        
        $entity = new DomainImage();
        $entity->setPath($this->path);
        $entity->setFileName($fileName);
        $entity->setExt(ImageExt::get($ext));
        return $entity;
    }
    
    /**
     * @param int $length
     * @return string
     */
    private function makeRandStr($length = 16): string
    {
        static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= $chars[mt_rand(0, 61)];
        }
        return $str;
    }
    
    /**
     * @return void
     */
    public function reset()
    {
        $this->fullPath = null;
    }
}
