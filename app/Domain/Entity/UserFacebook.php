<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\FacebookId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserFacebook
 * @package App\Domain\Entity
 */
class UserFacebook implements EntityInterface
{
    /** @var User */
    private $user;
    
    /** @var string */
    private $facebookId;
    
    /** @var string */
    private $token;
    
    /** @var int */
    private $updatedAt;
    
    /** @var int */
    private $createdAt;
    
    /**
     * UserFacebook constructor.
     * @param User       $user
     * @param FacebookId $facebookId
     */
    public function __construct(User $user, FacebookId $facebookId)
    {
        $this->user       = $user;
        $this->facebookId = $facebookId->toNative();
    }
    
    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }
    
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt->getTimestamp();
    }
    
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt->getTimestamp();
    }
    
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * @return string
     */
    public function getFacebookId(): string
    {
        return $this->facebookId;
    }
    
    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    
    /**
     * @return int
     */
    public function getUpdatedAt(): int
    {
        if (empty($this->updatedAt)) {
            return (new \DateTime)->getTimestamp();
        }
        return $this->updatedAt;
    }
    
    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        if (empty($this->createdAt)) {
            return (new \DateTime)->getTimestamp();
        }
        return $this->createdAt;
    }
}
