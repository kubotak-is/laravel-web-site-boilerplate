<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserTwitter};
use App\Domain\ValueObject\{UserId, twitterId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersTwitterCriteriaInterface;
use App\Domain\Specification\Authentication\FindUserTwitterSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserTwitterSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class FindUserTwitterSpecificationTest extends TestCase
{
    /**
     * @var FindUserTwitterSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersTwitterCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersTwitterCriteriaInterface::class);
        $this->specification = new FindUserTwitterSpecification($this->criteria);
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
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testFindSuccess()
    {
        $this->criteria->shouldReceive('findByTwitterId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => false,
            'twitter_id'       => 'id',
            'nickname'         => 'nickname',
            'token'            => 'token',
            'token_secret'     => 'token_secret',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserTwitter(new User(new UserId), new TwitterId("id"));
        $result = $this->specification->find($entity);
        $this->assertTrue($result instanceof UserTwitter);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserTwitter
     */
    public function testRuntimeException()
    {
        $this->criteria->shouldReceive('findByTwitterId')->andReturn([]);
        $entity = new User(new UserId());
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\NotFoundResourceException
     * @expectedExceptionMessage Not Found UserTwitter
     */
    public function testNotFoundException()
    {
        $this->criteria->shouldReceive('findByTwitterId')->andReturn([]);
        $entity = new UserTwitter(new User(new UserId), new TwitterId("id"));
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\Authentication\UserFrozenException
     */
    public function testFrozenException()
    {
        $this->criteria->shouldReceive('findByTwitterId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => true,
            'twitter_id'       => 'id',
            'nickname'         => 'nickname',
            'token'            => 'token',
            'token_secret'     => 'token_secret',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserTwitter(new User(new UserId), new TwitterId("id"));
        $this->specification->find($entity);
    }
}
