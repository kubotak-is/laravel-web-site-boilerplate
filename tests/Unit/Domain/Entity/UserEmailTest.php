<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Entity;

use Tests\TestCase;
use App\Domain\Entity\{
    AggregateRoot, User, UserEmail
};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class UserEmailTest
 * @package Test\Unit\Domain\Entity
 */
class UserEmailTest extends TestCase
{
    /**
     * @var UserEmail
     */
    private $entity;
    
    public function setUp()
    {
        $user = new User(new UserId);
        $this->entity = new UserEmail($user, new EmailAddress('test@test.com'));
    }
    
    public function testInstance()
    {
        $this->assertFalse($this->entity instanceof  AggregateRoot);
        $this->assertTrue($this->entity instanceof EntityInterface);
    }
    
    public function testValues()
    {
        $this->entity->setPassword('password');
    
        $this->assertTrue($this->entity->getUser() instanceof User);
        $this->assertSame($this->entity->getEmail(), 'test@test.com');
        $this->assertSame($this->entity->getPassword(), 'password');
        $this->assertTrue(is_int($this->entity->getUpdatedAt()));
        $this->assertTrue(is_int($this->entity->getCreatedAt()));
        
    
        $date = new \DateTime('2000-01-01 00:00:00');
        $this->entity->setUpdatedAt($date);
        $this->entity->setCreatedAt($date);
        $this->assertSame($this->entity->getUpdatedAt(), $date->getTimestamp());
        $this->assertSame($this->entity->getCreatedAt(), $date->getTimestamp());
    }
}
