<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserTwitter;
use App\Domain\ValueObject\TwitterId;
use App\Domain\UseCase\Authentication\UpdateUserTwitter;
use App\Domain\Specification\Authentication\UpdateUserTwitterSpecification;

/**
 * Class UpdateUserTwitterTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class UpdateUserTwitterTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|UpdateUserTwitterSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(UpdateUserTwitterSpecification::class);
        $this->useCase = new UpdateUserTwitter($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserTwitter(new User(new UserId()), new TwitterId('id'));
        $this->specification->shouldReceive('update')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
