<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Specification\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserEmail};
use App\Domain\ValueObject\UserId;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use App\Domain\Criteria\UsersMailCriteriaInterface;
use App\Domain\Specification\Authentication\FindUserEmailSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class FindUserEmailSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class FindUserEmailSpecificationTest extends TestCase
{
    /**
     * @var FindUserEmailSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersMailCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersMailCriteriaInterface::class);
        $this->specification = new FindUserEmailSpecification($this->criteria);
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->specification instanceof  SpecificationInterface);
        $this->assertTrue($this->specification instanceof  CriteriaBuilderInterface);
    }
    
    public function testShouldIsSatisfiedByReturnBoolean()
    {
        $user = new User(new UserId);
        $email = new UserEmail($user, new EmailAddress("test@test.com"));
        $this->assertTrue($this->specification->isSatisfiedBy($email));
    
        $user2 = new User(new UserId);
        $user2->setFlag(true, true);
        $email2 = new UserEmail($user2, new EmailAddress("test@test.com"));
        $this->assertFalse($this->specification->isSatisfiedBy($email2));
    }
    
    public function testBuild()
    {
        $criteria = $this->specification->build();
        $this->assertTrue($criteria instanceof CriteriaInterface);
    }
    
    public function testFindSuccess()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => false,
            'email'            => 'test@test.com',
            'password'         => 'password',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $result = $this->specification->find($entity);
        $this->assertTrue($result instanceof UserEmail);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserEmail
     */
    public function testRuntimeException()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([]);
        $entity = new User(new UserId());
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\NotFoundResourceException
     * @expectedExceptionMessage Not Found UserEmail
     */
    public function testNotFoundException()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([]);
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\Authentication\UserFrozenException
     */
    public function testFrozenException()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([
            'user_id'          => UserId::generateAsString(),
            'name'             => 'name',
            'frozen'           => true,
            'email'            => 'test@test.com',
            'password'         => 'password',
            'last_login_time'  => '2000-01-01 00:00:00',
            'user.updated_at'  => '2000-01-01 00:00:00',
            'user.created_at'  => '2000-01-01 00:00:00',
            'updated_at'       => '2000-01-01 00:00:00',
            'created_at'       => '2000-01-01 00:00:00',
        ]);
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $this->specification->find($entity);
    }
}
