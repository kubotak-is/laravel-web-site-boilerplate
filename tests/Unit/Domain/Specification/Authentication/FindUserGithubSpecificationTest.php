<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserGithub};
use App\Domain\ValueObject\{UserId, GithubId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersGithubCriteriaInterface;
use App\Domain\Specification\Authentication\FindUserGithubSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class FindUserGithubSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class FindUserGithubSpecificationTest extends TestCase
{
    /**
     * @var FindUserGithubSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersGithubCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersGithubCriteriaInterface::class);
        $this->specification = new FindUserGithubSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $user = new User(new UserId);
        $github = new UserGithub($user, new GithubId("id"));
        $this->assertTrue($this->specification->isSatisfiedBy($github));
    
        $user2 = new User(new UserId);
        $user2->setFlag(true, true);
        $github2 = new UserGithub($user2, new GithubId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($github2));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testFindSuccess()
    {
        $this->criteria->shouldReceive('findByGithubId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => false,
            'github_id'        => 'id',
            'token'            => 'token',
            'nickname'         => 'nickname',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserGithub(new User(new UserId), new GithubId("id"));
        $result = $this->specification->find($entity);
        $this->assertTrue($result instanceof UserGithub);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserGithub
     */
    public function testRuntimeException()
    {
        $this->criteria->shouldReceive('findByGithubId')->andReturn([]);
        $entity = new User(new UserId());
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\NotFoundResourceException
     * @expectedExceptionMessage Not Found UserGithub
     */
    public function testNotFoundException()
    {
        $this->criteria->shouldReceive('findByGithubId')->andReturn([]);
        $entity = new UserGithub(new User(new UserId), new GithubId("id"));
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\Authentication\UserFrozenException
     */
    public function testFrozenException()
    {
        $this->criteria->shouldReceive('findByGithubId')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => true,
            'github_id'        => 'id',
            'token'            => 'token',
            'nickname'         => 'nickname',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserGithub(new User(new UserId), new GithubId("id"));
        $this->specification->find($entity);
    }
}
