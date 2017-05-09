<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Repository;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Repository\UsersRepository;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersRepositoryTest
 * @package Test\Unit\Domain\Repository
 */
class UsersRepositoryTest extends TestCase
{
    /**
     * @var User
     */
    private $entity;
    
    /**
     * @var SpecificationInterface|M\Mock
     */
    private $specification;
    
    /**
     * @var UsersRepository
     */
    private $repository;
    
    public function setUp()
    {
        $this->entity        = new User(new UserId);
        $this->specification = M::mock(SpecificationInterface::class);
        $this->repository    = new UsersRepository($this->specification);
    }
    
    public function testCreate()
    {
        $this->specification->shouldReceive('create')->andReturn(true);
        $this->assertTrue(
            $this->repository->create($this->entity)
        );
    }
    
    public function testUpdate()
    {
        $this->specification->shouldReceive('update')->andReturn(true);
        $this->assertTrue(
            $this->repository->update($this->entity)
        );
    }
}
