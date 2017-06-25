<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserGithub;
use App\Domain\ValueObject\GithubId;
use App\Domain\UseCase\Authentication\FindUserGithub;
use App\Domain\Specification\Authentication\FindUserGithubSpecification;

/**
 * Class FindUserGithubTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class FindUserGithubTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|FindUserGithubSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(FindUserGithubSpecification::class);
        $this->useCase = new FindUserGithub($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserGithub(new User(new UserId()), new GithubId('id'));
        $this->specification->shouldReceive('find')->andReturn($entity);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result instanceof UserGithub);
    }
}
