<?php
declare(strict_types=1);

namespace Test\Unit\Domain\Repository;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\{User, UserFacebook};
use App\Domain\ValueObject\{UserId, FacebookId};
use App\Domain\Repository\UsersFacebookRepository;
use PHPMentors\DomainKata\Specification\SpecificationInterface;

/**
 * Class UsersFacebookRepositoryTest
 * @package Test\Unit\Domain\Repository
 */
class UsersFacebookRepositoryTest extends TestCase
{
    /**
     * @var UserFacebook
     */
    private $entity;
    
    /**
     * @var SpecificationInterface|M\Mock
     */
    private $specification;
    
    /**
     * @var UsersFacebookRepository
     */
    private $repository;
    
    public function setUp()
    {
        $this->entity        = new UserFacebook(new User(new UserId), new FacebookId('id'));
        $this->specification = M::mock(SpecificationInterface::class);
        $this->repository    = new UsersFacebookRepository($this->specification);
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
        $this->assertTrue($result instanceof UserFacebook);
    }
    
    public function testUpdate()
    {
        $this->specification->shouldReceive('update')->andReturn(true);
        $this->assertTrue(
            $this->repository->update($this->entity)
        );
    }
}
