<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserEmail;
use App\Domain\UseCase\Authentication\RegistrationToUserEmail;
use App\Domain\Specification\Authentication\CreateUserEmailSpecification;
use ValueObjects\Web\EmailAddress;

/**
 * Class RegistrationToUserEmailTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class RegistrationToUserEmailTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|CreateUserEmailSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(CreateUserEmailSpecification::class);
        $this->useCase = new RegistrationToUserEmail($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserEmail(new User(new UserId()), new EmailAddress('test@test.com'));
        $this->specification->shouldReceive('create')->andReturn(true);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result);
    }
}
