<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\UseCase\Authentication\UpdateLastLoginTime;
use App\Domain\Specification\Authentication\UpdateLastLoginTimeSpecification;

/**
 * Class UpdateLastLoginTimeTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class UpdateLastLoginTimeTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|UpdateLastLoginTimeSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(UpdateLastLoginTimeSpecification::class);
        $this->useCase = new UpdateLastLoginTime($this->specification);
    }
    
    public function testRun()
    {
        $entity = new User(new UserId());
        $this->specification->shouldReceive('update')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
