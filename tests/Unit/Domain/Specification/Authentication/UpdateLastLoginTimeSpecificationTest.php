<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use App\Domain\Entity\UserEmail;
use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersCriteriaInterface;
use App\Domain\Specification\Authentication\UpdateLastLoginTimeSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class UpdateLastLoginTimeSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class UpdateLastLoginTimeSpecificationTest extends TestCase
{
    /**
     * @var UpdateLastLoginTimeSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersCriteriaInterface::class);
        $this->specification = new UpdateLastLoginTimeSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $entity = new User(new UserId);
        $this->assertTrue($this->specification->isSatisfiedBy($entity));
        
        $entity->setFlag(true, true);
        $this->assertFalse($this->specification->isSatisfiedBy($entity));
        
        $entity->setFlag(true, false);
        $this->assertFalse($this->specification->isSatisfiedBy($entity));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testUpdateSuccess()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $entity = new User(new UserId);
        $result = $this->specification->update($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match User
     */
    public function testRuntimeException()
    {
        $entity = new UserEmail(new User(new UserId()), new EmailAddress('test@test.com'));
        $this->specification->update($entity);
    }
    
    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Not Satisfied Entity
     */
    public function testErrorException()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $entity = new User(new UserId);
        $entity->setFlag(true, true);
        $this->specification->update($entity);
    }
}
