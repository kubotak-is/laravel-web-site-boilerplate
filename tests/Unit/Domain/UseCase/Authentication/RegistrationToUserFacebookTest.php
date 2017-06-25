<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserFacebook;
use App\Domain\ValueObject\FacebookId;
use App\Domain\UseCase\Authentication\RegistrationToUserFacebook;
use App\Domain\Specification\Authentication\CreateUserFacebookSpecification;

/**
 * Class RegistrationToUserFacebookTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class RegistrationToUserFacebookTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|CreateUserFacebookSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(CreateUserFacebookSpecification::class);
        $this->useCase = new RegistrationToUserFacebook($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserFacebook(new User(new UserId()), new FacebookId('id'));
        $this->specification->shouldReceive('create')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
