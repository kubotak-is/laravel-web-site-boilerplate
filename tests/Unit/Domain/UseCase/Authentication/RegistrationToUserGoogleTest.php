<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserGoogle;
use App\Domain\ValueObject\GoogleId;
use App\Domain\UseCase\Authentication\RegistrationToUserGoogle;
use App\Domain\Specification\Authentication\CreateUserGoogleSpecification;

/**
 * Class RegistrationToUserGoogleTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class RegistrationToUserGoogleTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|CreateUserGoogleSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(CreateUserGoogleSpecification::class);
        $this->useCase = new RegistrationToUserGoogle($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserGoogle(new User(new UserId()), new GoogleId('id'));
        $this->specification->shouldReceive('create')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
