<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Entity;

use App\Domain\ValueObject\GoogleId;
use Tests\TestCase;
use App\Domain\Entity\{
    AggregateRoot, User, UserGoogle
};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Class UserGoogleTest
 * @package Test\Unit\Domain\Entity
 */
class UserGoogleTest extends TestCase
{
    /**
     * @var UserGoogle
     */
    private $entity;
    
    public function setUp()
    {
        $user = new User(new UserId);
        $this->entity = new UserGoogle($user, new GoogleId('google'));
    }
    
    public function testInstance()
    {
        $this->assertFalse($this->entity instanceof  AggregateRoot);
        $this->assertTrue($this->entity instanceof EntityInterface);
    }
    
    public function testValues()
    {
        $date = new \DateTime('2000-01-01 00:00:00');
        $this->entity->setToken('token');
        $this->entity->setUpdatedAt($date);
        $this->entity->setCreatedAt($date);
    
        $this->assertTrue($this->entity->getUser() instanceof User);
        $this->assertSame($this->entity->getGoogleId(), 'google');
        $this->assertSame($this->entity->getToken(), 'token');
        $this->assertSame($this->entity->getUpdatedAt(), $date->getTimestamp());
        $this->assertSame($this->entity->getCreatedAt(), $date->getTimestamp());
    }
}
