<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Repository;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserTwitter};
use App\Domain\ValueObject\{UserId, TwitterId};
use App\Domain\Repository\UsersTwitterRepository;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersTwitterRepositoryTest
 * @package Test\Unit\Domain\Repository
 */
class UsersTwitterRepositoryTest extends TestCase
{
    /**
     * @var UserTwitter
     */
    private $entity;
    
    /**
     * @var SpecificationInterface|M\Mock
     */
    private $specification;
    
    /**
     * @var UsersTwitterRepository
     */
    private $repository;
    
    public function setUp()
    {
        $this->entity        = new UserTwitter(new User(new UserId), new TwitterId('id'));
        $this->specification = M::mock(SpecificationInterface::class);
        $this->repository    = new UsersTwitterRepository($this->specification);
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
        $this->assertTrue($result instanceof UserTwitter);
    }
    
    public function testUpdate()
    {
        $this->specification->shouldReceive('update')->andReturn(true);
        $this->assertTrue(
            $this->repository->update($this->entity)
        );
    }
}
