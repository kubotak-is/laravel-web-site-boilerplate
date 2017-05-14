<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{
    User, UserGoogle
};
use App\Domain\ValueObject\{
    GoogleId, UserId
};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersGoogleCriteriaInterface;
use App\Domain\Specification\Authentication\UpdateUserGoogleSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserGoogleSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class UpdateUserGoogleSpecificationTest extends TestCase
{
    /**
     * @var UpdateUserGoogleSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersGoogleCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersGoogleCriteriaInterface::class);
        $this->specification = new UpdateUserGoogleSpecification($this->criteria);
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
    
        $user3 = new User(new UserId);
        $user3->setFlag(true, false);
        $google3 = new UserGoogle($user3, new GoogleId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($google3));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testUpdateSuccess()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $entity = new UserGoogle(new User(new UserId), new GoogleId("id"));
        $entity->setToken('token');
        $result = $this->specification->update($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserGoogle
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId);
        $this->specification->update($entity);
    }
    
    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Not Satisfied UserGoogle
     */
    public function testErrorException()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $user = new User(new UserId);
        $user->setFlag(true, true);
        $entity = new UserGoogle($user, new GoogleId("id"));
        $entity->setToken('token');
        $this->specification->update($entity);
    }
}
