<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use PHPMentors\DomainKata\Entity\EntityInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class UserEmail
 * @package App\Domain\Entity
 */
class UserEmail implements EntityInterface
{
    /** @var User */
    private $user;
    
    /** @var string */
    private $email;
    
    /** @var string */
    private $password;
    
    /** @var int */
    private $updatedAt;
    
    /** @var int */
    private $createdAt;
    
    /**
     * UserEmail constructor.
     * @param User         $user
     * @param EmailAddress $email
     */
    public function __construct(User $user, EmailAddress $email)
    {
        $this->user  = $user;
        $this->email = $email->toNative();
    }
    
    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
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
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
