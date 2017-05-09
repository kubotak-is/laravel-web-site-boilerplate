<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Entity;

use App\Domain\ValueObject\TwitterId;
use Tests\TestCase;
use App\Domain\Entity\{
    AggregateRoot, User, UserTwitter
};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserTwitterTest
 * @package Test\Unit\Domain\Entity
 */
class UserTwitterTest extends TestCase
{
    /**
     * @var UserTwitter
     */
    private $entity;
    
    public function setUp()
    {
        $user = new User(new UserId);
        $this->entity = new UserTwitter($user, new TwitterId('twitter'));
    }
    
    public function testInstance()
    {
        $this->assertFalse($this->entity instanceof  AggregateRoot);
        $this->assertTrue($this->entity instanceof EntityInterface);
    }
    
    public function testValues()
    {
        $date = new \DateTime('2000-01-01 00:00:00');
        $this->entity->setNickname('nickname');
        $this->entity->setToken('token');
        $this->entity->setTokenSecret('token_secret');
        $this->entity->setUpdatedAt($date);
        $this->entity->setCreatedAt($date);
    
        $this->assertTrue($this->entity->getUser() instanceof User);
        $this->assertSame($this->entity->getTwitterId(), 'twitter');
        $this->assertSame($this->entity->getNickname(), 'nickname');
        $this->assertSame($this->entity->getToken(), 'token');
        $this->assertSame($this->entity->getTokenSecret(), 'token_secret');
        $this->assertSame($this->entity->getUpdatedAt(), $date->getTimestamp());
        $this->assertSame($this->entity->getCreatedAt(), $date->getTimestamp());
    }
}
