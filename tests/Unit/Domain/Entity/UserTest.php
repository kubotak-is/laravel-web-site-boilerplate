<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Entity;

use Tests\TestCase;
use App\Domain\Entity\{AggregateRoot, User};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;

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
    
    public function setUp()
    {
        $this->entity = new User(new UserId);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->entity instanceof  AggregateRoot);
        $this->assertTrue($this->entity instanceof EntityInterface);
    }
    
    public function testValues()
    {
        $date = new \DateTime('2000-01-01 00:00:00');
        $this->entity->setName('name');
        $this->entity->setFlag(true, false);
        $this->entity->setLastLoginTime($date);
        $this->entity->setUpdatedAt($date);
        $this->entity->setCreatedAt($date);
        
        $this->assertTrue(is_string($this->entity->getUserId()));
        $this->assertSame($this->entity->getName(), 'name');
        $this->assertSame($this->entity->getLastLoginTime(), $date->getTimestamp());
        $this->assertSame($this->entity->getUpdatedAt(), $date->getTimestamp());
        $this->assertSame($this->entity->getCreatedAt(), $date->getTimestamp());
        $this->assertTrue($this->entity->isFrozen());
        $this->assertFalse($this->entity->isDeleted());
    }
}
