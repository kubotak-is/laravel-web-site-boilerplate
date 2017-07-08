<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserImage
 * @package App\Domain\Entity
 */
class UserImage implements EntityInterface
{
    /**
     * @var User
     */
    private $user;
    
    /**
     * @var Image
     */
    private $image;
    
    /**
     * @var string
     */
    private $defaultImage;
    
    /**
     * UserImage constructor.
     * @param User  $user
     * @param Image $image
     */
    public function __construct(User $user, Image $image)
    {
        $this->user = $user;
        $this->image = $image;
    }
    
    /**
     * @param string $defaultImage
     */
    public function setDefaultImage(string $defaultImage)
    {
        $this->defaultImage = $defaultImage;
    }
    
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * @param string $suffix
     * @return string
     */
    public function getImagePath(string $suffix = ''): string
    {
        if (empty($this->image)) {
            return $this->defaultImage;
        }
        
        return $this->image->getPath() .
            '/' .
            $this->image->getFileName() .
            $suffix .
            '.' .
            $this->image->getExt();
    }
    
}
