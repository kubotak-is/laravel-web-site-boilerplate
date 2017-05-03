<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\TwitterId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserTwitter
 * @package App\Domain\Entity
 */
class UserTwitter implements EntityInterface
{
    /** @var User */
    private $user;
    
    /** @var string */
    private $twitterId;
    
    /** @var string */
    private $nickname;
    
    /** @var string */
    private $token;
    
    /** @var string */
    private $tokenSecret;
    
    /** @var int */
    private $updatedAt;
    
    /** @var int */
    private $createdAt;
    
    /**
     * UserTwitter constructor.
     * @param User      $user
     * @param TwitterId $twitterId
     */
    public function __construct(User $user, TwitterId $twitterId)
    {
        $this->user      = $user;
        $this->twitterId = $twitterId->toNative();
    }
    
    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
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
    public function getTwitterId(): string
    {
        return $this->twitterId;
    }
    
    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }
    
    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    
    /**
     * @return string
     */
    public function getTokenSecret(): string
    {
        return $this->tokenSecret;
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
