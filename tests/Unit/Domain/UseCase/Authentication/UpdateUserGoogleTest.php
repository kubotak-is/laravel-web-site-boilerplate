<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserGoogle;
use App\Domain\ValueObject\GoogleId;
use App\Domain\UseCase\Authentication\UpdateUserGoogle;
use App\Domain\Specification\Authentication\UpdateUserGoogleSpecification;

/**
 * Class UpdateUserGoogleTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class UpdateUserGoogleTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|UpdateUserGoogleSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(UpdateUserGoogleSpecification::class);
        $this->useCase = new UpdateUserGoogle($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserGoogle(new User(new UserId()), new GoogleId('id'));
        $this->specification->shouldReceive('update')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
