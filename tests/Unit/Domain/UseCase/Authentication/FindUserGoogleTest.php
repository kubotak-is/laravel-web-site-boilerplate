<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserGoogle;
use App\Domain\ValueObject\GoogleId;
use App\Domain\UseCase\Authentication\FindUserGoogle;
use App\Domain\Specification\Authentication\FindUserGoogleSpecification;

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
     * @var M\Mock|FindUserGoogleSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(FindUserGoogleSpecification::class);
        $this->useCase = new FindUserGoogle($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserGoogle(new User(new UserId()), new GoogleId('id'));
        $this->specification->shouldReceive('find')->andReturn($entity);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result instanceof UserGoogle);
    }
}
