<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserTwitter};
use App\Domain\ValueObject\{UserId, TwitterId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersTwitterCriteriaInterface;
use App\Domain\Specification\Authentication\UpdateUserTwitterSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserTwitterSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class UpdateUserTwitterSpecificationTest extends TestCase
{
    /**
     * @var UpdateUserTwitterSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersTwitterCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersTwitterCriteriaInterface::class);
        $this->specification = new UpdateUserTwitterSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $user = new User(new UserId);
        $twitter = new UserTwitter($user, new TwitterId("id"));
        $this->assertTrue($this->specification->isSatisfiedBy($twitter));
    
        $user2 = new User(new UserId);
        $user2->setFlag(true, true);
        $twitter2 = new UserTwitter($user2, new TwitterId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($twitter2));
    
        $user3 = new User(new UserId);
        $user3->setFlag(false, true);
        $twitter3 = new UserTwitter($user3, new TwitterId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($twitter3));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testUpdateSuccess()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $entity = new UserTwitter(new User(new UserId), new TwitterId("id"));
        $entity->setNickname('nickname');
        $entity->setToken('token');
        $entity->setTokenSecret('token_secret');
        $result = $this->specification->update($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserTwitter
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId);
        $this->specification->update($entity);
    }
    
    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Not Satisfied UserTwitter
     */
    public function testErrorException()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $user = new User(new UserId);
        $user->setFlag(true, true);
        $entity = new UserTwitter($user, new TwitterId("id"));
        $entity->setNickname('nickname');
        $entity->setToken('token');
        $entity->setTokenSecret('token_secret');
        $this->specification->update($entity);
    }
}
