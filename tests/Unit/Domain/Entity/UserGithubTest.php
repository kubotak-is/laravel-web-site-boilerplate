<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Entity;

use App\Domain\ValueObject\GithubId;
use Tests\TestCase;
use App\Domain\Entity\{
    AggregateRoot, User, UserGithub
};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserGithubTest
 * @package Test\Unit\Domain\Entity
 */
class UserGithubTest extends TestCase
{
    /**
     * @var UserGithub
     */
    private $entity;
    
    public function setUp()
    {
        $user = new User(new UserId);
        $this->entity = new UserGithub($user, new GithubId('github'));
    }
    
    public function testInstance()
    {
        $this->assertFalse($this->entity instanceof  AggregateRoot);
        $this->assertTrue($this->entity instanceof EntityInterface);
    }
    
    public function testValues()
    {
        $this->entity->setNickname('nickname');
        $this->entity->setToken('token');
    
        $this->assertTrue($this->entity->getUser() instanceof User);
        $this->assertSame($this->entity->getGithubId(), 'github');
        $this->assertSame($this->entity->getNickname(), 'nickname');
        $this->assertSame($this->entity->getToken(), 'token');
        $this->assertTrue(is_int($this->entity->getUpdatedAt()));
        $this->assertTrue(is_int($this->entity->getCreatedAt()));
    
    
        $date = new \DateTime('2000-01-01 00:00:00');
        $this->entity->setUpdatedAt($date);
        $this->entity->setCreatedAt($date);
        $this->assertSame($this->entity->getUpdatedAt(), $date->getTimestamp());
        $this->assertSame($this->entity->getCreatedAt(), $date->getTimestamp());;
    }
}
