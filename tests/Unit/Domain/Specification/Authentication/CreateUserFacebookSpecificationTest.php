<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserFacebook};
use App\Domain\ValueObject\{UserId, FacebookId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersFacebookCriteriaInterface;
use App\Domain\Specification\Authentication\CreateUserFacebookSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserFacebookSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class CreateUserFacebookSpecificationTest extends TestCase
{
    /**
     * @var CreateUserFacebookSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersFacebookCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersFacebookCriteriaInterface::class);
        $this->specification = new CreateUserFacebookSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $entity = new UserFacebook(new User(new UserId), new FacebookId('id'));
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
        $entity = new UserFacebook(new User(new UserId), new FacebookId('id'));
        $entity->setToken('token');
        $result = $this->specification->create($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserFacebook
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId());
        $this->specification->create($entity);
    }
}
