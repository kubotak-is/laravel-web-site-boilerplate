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
use App\Domain\Specification\Authentication\AuthenticationUserEmailSpecification;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class AuthenticationUserEmailSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class AuthenticationUserEmailSpecificationTest extends TestCase
{
    /**
     * @var AuthenticationUserEmailSpecification
     */
    private $specification;
    
    /**
     * @var M\Mock|UsersMailCriteriaInterface
     */
    private $criteria;
    
    public function setUp()
    {
        $this->criteria      = M::mock(UsersMailCriteriaInterface::class);
        $this->specification = new AuthenticationUserEmailSpecification($this->criteria);
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
    
    public function testFind()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([
            'user_id'         => (new UserId)->toNative(),
            'name'            => 'name',
            'frozen'          => true,
            'last_login_time' => '2000-01-01 00:00:00',
            'user.updated_at' => '2000-01-01 00:00:00',
            'user.created_at' => '2000-01-01 00:00:00',
            'email'           => 'test@test.com',
            'password'        => password_hash('test', PASSWORD_BCRYPT, []),
            'updated_at'      => '2000-01-01 00:00:00',
            'created_at'      => '2000-01-01 00:00:00',
        ]);
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $entity->setPassword('test');
        $result = $this->specification->find($entity);
        $this->assertTrue($result instanceof UserEmail);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not Match UserEmail
     */
    public function testFindReturnRuntimeException()
    {
        $entity = new User(new UserId);
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\NotFoundResourceException
     * @expectedExceptionMessage Not Fount Email
     */
    public function testFindReturnNotFoundResourceException()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([]);
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $this->specification->find($entity);
    }
    
    /**
     * @expectedException \App\Domain\Exception\Authentication\ValidPasswordException
     * @expectedExceptionMessage Valid Password
     */
    public function testFindReturnValidPasswordException()
    {
        $this->criteria->shouldReceive('findByEmail')->andReturn([
            'user_id'         => (new UserId)->toNative(),
            'name'            => 'name',
            'frozen'          => true,
            'last_login_time' => '2000-01-01 00:00:00',
            'user.updated_at' => '2000-01-01 00:00:00',
            'user.created_at' => '2000-01-01 00:00:00',
            'email'           => 'test@test.com',
            'password'        => password_hash('test', PASSWORD_BCRYPT, []),
            'updated_at'      => '2000-01-01 00:00:00',
            'created_at'      => '2000-01-01 00:00:00',
        ]);
        $entity = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $entity->setPassword('valid');
        $this->specification->find($entity);
    }
}
