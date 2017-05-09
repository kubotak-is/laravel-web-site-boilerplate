<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Repository;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserGithub};
use App\Domain\ValueObject\{UserId, GithubId};
use App\Domain\Repository\UsersGithubRepository;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersGithubRepositoryTest
 * @package Test\Unit\Domain\Repository
 */
class UsersGithubRepositoryTest extends TestCase
{
    /**
     * @var UserGithub
     */
    private $entity;
    
    /**
     * @var SpecificationInterface|M\Mock
     */
    private $specification;
    
    /**
     * @var UsersGithubRepository
     */
    private $repository;
    
    public function setUp()
    {
        $this->entity        = new UserGithub(new User(new UserId), new GithubId('id'));
        $this->specification = M::mock(SpecificationInterface::class);
        $this->repository    = new UsersGithubRepository($this->specification);
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
        $this->assertTrue($result instanceof UserGithub);
    }
    
    public function testUpdate()
    {
        $this->specification->shouldReceive('update')->andReturn(true);
        $this->assertTrue(
            $this->repository->update($this->entity)
        );
    }
}
