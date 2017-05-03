<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\GoogleId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserGoogle
 * @package App\Domain\Entity
 */
class UserGoogle implements EntityInterface
{
    /** @var User */
    private $user;
    
    /** @var string */
    private $googleId;
    
    /** @var string */
    private $token;
    
    /** @var int */
    private $updatedAt;
    
    /** @var int */
    private $createdAt;
    
    /**
     * UserGoogle constructor.
     * @param User     $user
     * @param GoogleId $googleId
     */
    public function __construct(User $user, GoogleId $googleId)
    {
        $this->user     = $user;
        $this->googleId = $googleId->toNative();
    }
    
    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }
    
    /**
     * @param string $tokenSecret
     */
    public function setTokenSecret(string $tokenSecret)
    {
        $this->tokenSecret = $tokenSecret;
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
    public function getGoogleId(): string
    {
        return $this->googleId;
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
