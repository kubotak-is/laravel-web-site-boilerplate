<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\Entity\UserEmail;
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersMailCriteriaInterface;
use App\Domain\Specification\Authentication\CreateUserEmailSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class CreateUserEmailSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class CreateUserEmailSpecificationTest extends TestCase
{
    /**
     * @var CreateUserEmailSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersMailCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersMailCriteriaInterface::class);
        $this->specification = new CreateUserEmailSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
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
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $entity->setPassword('password');
        $result = $this->specification->create($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserEmail
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId());
        $this->specification->create($entity);
    }
}
