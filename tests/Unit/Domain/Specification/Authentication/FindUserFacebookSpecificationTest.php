<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserFacebook};
use App\Domain\ValueObject\{UserId, FacebookId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersFacebookCriteriaInterface;
use App\Domain\Specification\Authentication\FindUserFacebookSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserFacebookSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class FindUserFacebookSpecificationTest extends TestCase
{
    /**
     * @var FindUserFacebookSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersFacebookCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersFacebookCriteriaInterface::class);
        $this->specification = new FindUserFacebookSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $user = new User(new UserId);
        $facebook = new UserFacebook($user, new FacebookId("id"));
        $this->assertTrue($this->specification->isSatisfiedBy($facebook));
    
        $user2 = new User(new UserId);
        $user2->setFlag(true, true);
        $facebook2 = new UserFacebook($user2, new FacebookId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($facebook2));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testFindSuccess()
    {
        $this->criteria->shouldReceive('findByFacebookId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => false,
            'facebook_id'      => 'id',
            'token'            => 'token',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserFacebook(new User(new UserId), new FacebookId("id"));
        $result = $this->specification->find($entity);
        $this->assertTrue($result instanceof UserFacebook);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserFacebook
     */
    public function testRuntimeException()
    {
        $this->criteria->shouldReceive('findByFacebookId')->andReturn([]);
        $entity = new User(new UserId());
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\NotFoundResourceException
     * @expectedExceptionMessage Not Found UserFacebook
     */
    public function testNotFoundException()
    {
        $this->criteria->shouldReceive('findByFacebookId')->andReturn([]);
        $entity = new UserFacebook(new User(new UserId), new FacebookId("id"));
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\Authentication\UserFrozenException
     */
    public function testFrozenException()
    {
        $this->criteria->shouldReceive('findByFacebookId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => true,
            'facebook_id'      => 'id',
            'token'            => 'token',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserFacebook(new User(new UserId), new FacebookId("id"));
        $this->specification->find($entity);
    }
}
