<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\UseCase\Authentication\RegistrationToUser;
use App\Domain\Specification\Authentication\CreateUserSpecification;

/**
 * Class RegistrationToUserTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class RegistrationToUserTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|CreateUserSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(CreateUserSpecification::class);
        $this->useCase = new RegistrationToUser($this->specification);
    }
    
    public function testRun()
    {
        $entity = new User(new UserId());
        $this->specification->shouldReceive('create')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
