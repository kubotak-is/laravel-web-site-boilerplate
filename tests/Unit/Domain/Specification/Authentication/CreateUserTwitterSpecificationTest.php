<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserTwitter};
use App\Domain\ValueObject\{UserId, TwitterId};
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersTwitterCriteriaInterface;
use App\Domain\Specification\Authentication\CreateUserTwitterSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

/**
 * Class CreateUserTwitterSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class CreateUserTwitterSpecificationTest extends TestCase
{
    /**
     * @var CreateUserTwitterSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersTwitterCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersTwitterCriteriaInterface::class);
        $this->specification = new CreateUserTwitterSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $entity = new UserTwitter(new User(new UserId), new TwitterId('id'));
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
        $entity = new UserTwitter(new User(new UserId), new TwitterId('id'));
        $entity->setNickname('nickname');
        $entity->setToken('token');
        $entity->setTokenSecret('token_secret');
        $result = $this->specification->create($entity);
        $this->assertTrue($result);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserTwitter
     */
    public function testRuntimeException()
    {
        $entity = new User(new UserId());
        $this->specification->create($entity);
    }
}
