<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Repository;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserGoogle};
use App\Domain\ValueObject\{UserId, GoogleId};
use App\Domain\Repository\UsersGoogleRepository;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersGoogleRepositoryTest
 * @package Test\Unit\Domain\Repository
 */
class UsersGoogleRepositoryTest extends TestCase
{
    /**
     * @var UserGoogle
     */
    private $entity;
    
    /**
     * @var SpecificationInterface|M\Mock
     */
    private $specification;
    
    /**
     * @var UsersGoogleRepository
     */
    private $repository;
    
    public function setUp()
    {
        $this->entity        = new UserGoogle(new User(new UserId), new GoogleId('id'));
        $this->specification = M::mock(SpecificationInterface::class);
        $this->repository    = new UsersGoogleRepository($this->specification);
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
        $this->assertTrue($result instanceof UserGoogle);
    }
    
    public function testUpdate()
    {
        $this->specification->shouldReceive('update')->andReturn(true);
        $this->assertTrue(
            $this->repository->update($this->entity)
        );
    }
}
