<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserFacebook};
use App\Domain\ValueObject\{UserId, FacebookId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersFacebookCriteriaInterface;
use App\Domain\Specification\Authentication\UpdateUserFacebookSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class UpdateUserFacebookSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class UpdateUserFacebookSpecificationTest extends TestCase
{
    /**
     * @var UpdateUserFacebookSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersFacebookCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersFacebookCriteriaInterface::class);
        $this->specification = new UpdateUserFacebookSpecification($this->criteria);
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
    
        $user3 = new User(new UserId);
        $user3->setFlag(false, true);
        $facebook3 = new UserFacebook($user3, new FacebookId("id"));
        $this->assertFalse($this->specification->isSatisfiedBy($facebook3));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testUpdateSuccess()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $entity = new UserFacebook(new User(new UserId), new FacebookId("id"));
        $entity->setToken('token');
        $result = $this->specification->update($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserFacebook
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId);
        $this->specification->update($entity);
    }
    
    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Not Satisfied UserFacebook
     */
    public function testErrorException()
    {
        $this->criteria->shouldReceive('update')->andReturn(true);
        $user = new User(new UserId);
        $user->setFlag(true, true);
        $entity = new UserFacebook($user, new FacebookId("id"));
        $entity->setToken('token');
        $this->specification->update($entity);
    }
}
