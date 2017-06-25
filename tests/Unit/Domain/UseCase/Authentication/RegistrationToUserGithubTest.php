<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserGithub;
use App\Domain\ValueObject\GithubId;
use App\Domain\UseCase\Authentication\RegistrationToUserGithub;
use App\Domain\Specification\Authentication\CreateUserGithubSpecification;

/**
 * Class RegistrationToUserGithubTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class RegistrationToUserGithubTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|CreateUserGithubSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(CreateUserGithubSpecification::class);
        $this->useCase = new RegistrationToUserGithub($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserGithub(new User(new UserId()), new GithubId('id'));
        $this->specification->shouldReceive('create')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
