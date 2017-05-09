<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Repository;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserEmail};
use App\Domain\ValueObject\UserId;
use App\Domain\Repository\UsersMailRepository;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use ValueObjects\Web\EmailAddress;

/**
 * Class UsersMailRepositoryTest
 * @package Test\Unit\Domain\Repository
 */
class UsersMailRepositoryTest extends TestCase
{
    /**
     * @var UserEmail
     */
    private $entity;
    
    /**
     * @var SpecificationInterface|M\Mock
     */
    private $specification;
    
    /**
     * @var UsersMailRepository
     */
    private $repository;
    
    public function setUp()
    {
        $this->entity        = new UserEmail(new User(new UserId), new EmailAddress('test@test.com'));
        $this->specification = M::mock(SpecificationInterface::class);
        $this->repository    = new UsersMailRepository($this->specification);
    }
    
    public function testCreate()
    {
        $this->specification->shouldReceive('create')->andReturn(true);
        $this->assertTrue(
            $this->repository->create($this->entity)
        );
    }
    
    public function testFind()
    {
        $this->specification->shouldReceive('find')->andReturn($this->entity);
        $result = $this->repository->find($this->entity);
        $this->assertTrue($result instanceof UserEmail);
    }
}
