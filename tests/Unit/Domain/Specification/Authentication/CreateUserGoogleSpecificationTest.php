<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserGoogle};
use App\Domain\ValueObject\{UserId, GoogleId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersGoogleCriteriaInterface;
use App\Domain\Specification\Authentication\CreateUserGoogleSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserGoogleSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class CreateUserGoogleSpecificationTest extends TestCase
{
    /**
     * @var CreateUserGoogleSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersGoogleCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersGoogleCriteriaInterface::class);
        $this->specification = new CreateUserGoogleSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $entity = new UserGoogle(new User(new UserId), new GoogleId('id'));
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
        $entity = new UserGoogle(new User(new UserId), new GoogleId('id'));
        $entity->setToken('token');
        $result = $this->specification->create($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserGoogle
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId());
        $this->specification->create($entity);
    }
}
