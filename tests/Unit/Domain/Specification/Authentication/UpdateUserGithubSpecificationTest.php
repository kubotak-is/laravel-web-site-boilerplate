<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{
    User, UserGithub
};
use App\Domain\ValueObject\{
    GithubId, UserId
};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersGithubCriteriaInterface;
use App\Domain\Specification\Authentication\UpdateUserGithubSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserGithubSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class UpdateUserGithubSpecificationTest extends TestCase
{
    /**
     * @var UpdateUserGithubSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersGithubCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersGithubCriteriaInterface::class);
        $this->specification = new UpdateUserGithubSpecification($this->criteria);
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
    
        $user3 = new User(new UserId);
        $user3->setFlag(false, true);
        $github3 = new UserGithub($user3, new GithubId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($github3));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testUpdateSuccess()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $entity = new UserGithub(new User(new UserId), new GithubId("id"));
        $entity->setNickname('nickname');
        $entity->setToken('token');
        $result = $this->specification->update($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserGithub
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId);
        $this->specification->update($entity);
    }
    
    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Not Satisfied UserGithub
     */
    public function testErrorException()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $user = new User(new UserId);
        $user->setFlag(true, true);
        $entity = new UserGithub($user, new GithubId("id"));
        $entity->setNickname('nickname');
        $entity->setToken('token');
        $this->specification->update($entity);
    }
}
