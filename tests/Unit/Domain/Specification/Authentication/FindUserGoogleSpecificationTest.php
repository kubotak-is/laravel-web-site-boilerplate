<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserGoogle};
use App\Domain\ValueObject\{UserId, googleId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersGoogleCriteriaInterface;
use App\Domain\Specification\Authentication\FindUserGoogleSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserGoogleSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class FindUserGoogleSpecificationTest extends TestCase
{
    /**
     * @var FindUserGoogleSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersGoogleCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersGoogleCriteriaInterface::class);
        $this->specification = new FindUserGoogleSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $user = new User(new UserId);
        $google = new UserGoogle($user, new GoogleId("id"));
        $this->assertTrue($this->specification->isSatisfiedBy($google));
    
        $user2 = new User(new UserId);
        $user2->setFlag(true, true);
        $google2 = new UserGoogle($user2, new GoogleId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($google2));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testFindSuccess()
    {
        $this->criteria->shouldReceive('findByGoogleId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => false,
            'google_id'        => 'id',
            'token'            => 'token',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserGoogle(new User(new UserId), new GoogleId("id"));
        $result = $this->specification->find($entity);
        $this->assertTrue($result instanceof UserGoogle);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserGoogle
     */
    public function testRuntimeException()
    {
        $this->criteria->shouldReceive('findByGoogleId')->andReturn([]);
        $entity = new User(new UserId());
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\NotFoundResourceException
     * @expectedExceptionMessage Not Found UserGoogle
     */
    public function testNotFoundException()
    {
        $this->criteria->shouldReceive('findByGoogleId')->andReturn([]);
        $entity = new UserGoogle(new User(new UserId), new GoogleId("id"));
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\Authentication\UserFrozenException
     */
    public function testFrozenException()
    {
        $this->criteria->shouldReceive('findByGoogleId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => true,
            'google_id'        => 'id',
            'token'            => 'token',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserGoogle(new User(new UserId), new GoogleId("id"));
        $this->specification->find($entity);
    }
}
