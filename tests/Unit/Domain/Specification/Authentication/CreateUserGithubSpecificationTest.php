<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserGithub};
use App\Domain\ValueObject\{UserId, GithubId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersGithubCriteriaInterface;
use App\Domain\Specification\Authentication\CreateUserGithubSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserGithubSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class CreateUserGithubSpecificationTest extends TestCase
{
    /**
     * @var CreateUserGithubSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersGithubCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersGithubCriteriaInterface::class);
        $this->specification = new CreateUserGithubSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $entity = new UserGithub(new User(new UserId), new GithubId('id'));
        $this->assertTrue($this->specification->isSatisfiedBy($entity));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testCreateSuccess()
    {
        $this->criteria->shouldReceive('add')->andReturn(true);
        $entity = new UserGithub(new User(new UserId), new GithubId('id'));
        $entity->setNickname('nickname');
        $entity->setToken('token');
        $result = $this->specification->create($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserGithub
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId());
        $this->specification->create($entity);
    }
}
