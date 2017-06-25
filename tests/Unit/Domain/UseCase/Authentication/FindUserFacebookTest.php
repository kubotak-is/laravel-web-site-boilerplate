<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserFacebook;
use App\Domain\ValueObject\FacebookId;
use App\Domain\UseCase\Authentication\FindUserFacebook;
use App\Domain\Specification\Authentication\FindUserFacebookSpecification;

/**
 * Class FindUserFacebookTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class FindUserFacebookTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|FindUserFacebookSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(FindUserFacebookSpecification::class);
        $this->useCase = new FindUserFacebook($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserFacebook(new User(new UserId()), new FacebookId('id'));
        $this->specification->shouldReceive('find')->andReturn($entity);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result instanceof UserFacebook);
    }
}
