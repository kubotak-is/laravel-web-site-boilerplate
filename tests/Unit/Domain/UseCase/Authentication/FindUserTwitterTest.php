<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserTwitter;
use App\Domain\ValueObject\TwitterId;
use App\Domain\UseCase\Authentication\FindUserTwitter;
use App\Domain\Specification\Authentication\FindUserTwitterSpecification;

/**
 * Class FindUserGoogleTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class FindUserGoogleTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|FindUserTwitterSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(FindUserTwitterSpecification::class);
        $this->useCase = new FindUserTwitter($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserTwitter(new User(new UserId()), new TwitterId('id'));
        $this->specification->shouldReceive('find')->andReturn($entity);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result instanceof UserTwitter);
    }
}
