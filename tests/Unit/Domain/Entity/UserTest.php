<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Entity;

use Tests\TestCase;
use App\Domain\Entity\{AggregateRoot, User};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;
use ValueObjects\Identity\UUID;

/**
 * Class UserTest
 * @package Test\Unit\Domain\Entity
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $entity;
    
    /**
     * @var string
     */
    private $uuid;
    
    public function setUp()
    {
        $this->uuid   = UUID::generateAsString();
        $this->entity = new User(new UserId($this->uuid));
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->entity instanceof  AggregateRoot);
        $this->assertTrue($this->entity instanceof EntityInterface);
    }
    
    public function testValues()
    {
        $this->entity->setName('name');
        $this->entity->setFlag(true, false);
        
        
        $this->assertSame($this->entity->getUserId(), $this->uuid);
        $this->assertSame($this->entity->getName(), 'name');
        $this->assertTrue(is_int($this->entity->getLastLoginTime()));
        $this->assertTrue(is_int($this->entity->getUpdatedAt()));
        $this->assertTrue(is_int($this->entity->getCreatedAt()));
        $this->assertTrue($this->entity->isFrozen());
        $this->assertFalse($this->entity->isDeleted());
        
        
        $date = new \DateTime('2000-01-01 00:00:00');
        $this->entity->setLastLoginTime($date);
        $this->entity->setUpdatedAt($date);
        $this->entity->setCreatedAt($date);
        $this->assertSame($this->entity->getLastLoginTime(), $date->getTimestamp());
        $this->assertSame($this->entity->getUpdatedAt(), $date->getTimestamp());
        $this->assertSame($this->entity->getCreatedAt(), $date->getTimestamp());
    }
}
