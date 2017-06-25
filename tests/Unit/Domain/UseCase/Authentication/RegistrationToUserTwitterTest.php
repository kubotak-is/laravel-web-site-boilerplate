<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserTwitter;
use App\Domain\ValueObject\TwitterId;
use App\Domain\UseCase\Authentication\RegistrationToUserTwitter;
use App\Domain\Specification\Authentication\CreateUserTwitterSpecification;

/**
 * Class RegistrationToUserTwitterTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class RegistrationToUserTwitterTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|CreateUserTwitterSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(CreateUserTwitterSpecification::class);
        $this->useCase = new RegistrationToUserTwitter($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserTwitter(new User(new UserId()), new TwitterId('id'));
        $this->specification->shouldReceive('create')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
