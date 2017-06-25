<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserFacebook;
use App\Domain\ValueObject\FacebookId;
use App\Domain\UseCase\Authentication\UpdateUserFacebook;
use App\Domain\Specification\Authentication\UpdateUserFacebookSpecification;

/**
 * Class UpdateUserFacebookTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class UpdateUserFacebookTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|UpdateUserFacebookSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(UpdateUserFacebookSpecification::class);
        $this->useCase = new UpdateUserFacebook($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserFacebook(new User(new UserId()), new FacebookId('id'));
        $this->specification->shouldReceive('update')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
