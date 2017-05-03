<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\GithubId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserGithub
 * @package App\Domain\Entity
 */
class UserGithub implements EntityInterface
{
    /** @var User */
    private $user;
    
    /** @var string */
    private $githubId;
    
    /** @var string */
    private $nickname;
    
    /** @var string */
    private $token;
    
    /** @var int */
    private $updatedAt;
    
    /** @var int */
    private $createdAt;
    
    /**
     * UserGithub constructor.
     * @param User     $user
     * @param GithubId $githubId
     */
    public function __construct(User $user, GithubId $githubId)
    {
        $this->user     = $user;
        $this->githubId = $githubId->toNative();
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
    public function getGithubId(): string
    {
        return $this->githubId;
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
