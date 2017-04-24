<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use PHPMentors\DomainKata\Entity\EntityInterface;
use App\Domain\ValueObject\UserId;

/**
 * Class User
 * @package App\Domain\Entity
 */
class User implements AggregateRoot, EntityInterface
{
    /** @var string */
    private $userId;
    
    /** @var string */
    private $name;
    
    /** @var bool */
    private $frozen = false;
    
    /** @var bool */
    private $deleted = false;
    
    /** @var int */
    private $lastLoginTime;
    
    /** @var int */
    private $updatedAt;
    
    /** @var int */
    private $createdAt;
    
    /**
     * User constructor.
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        if ($userId->isEmpty()) {
            $this->userId = $userId::generateAsString();
        } else {
            $this->userId = $userId->toNative();
        }
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * @param bool $frozen
     * @param bool $deleted
     */
    public function setFlag(bool $frozen, bool $deleted)
    {
        $this->frozen  = $frozen;
        $this->deleted = $deleted;
    }
    
    /**
     * @param \DateTime $lastLoginTime
     */
    public function setLastLoginTime(\DateTime $lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime->getTimestamp();
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
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return bool
     */
    public function isFrozen(): bool
    {
        return $this->frozen;
    }
    
    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }
    
    /**
     * @return int
     */
    public function getLastLoginTime(): int
    {
        if (empty($this->lastLoginTime)) {
            return (new \DateTime)->getTimestamp();
        }
        return $this->lastLoginTime;
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
