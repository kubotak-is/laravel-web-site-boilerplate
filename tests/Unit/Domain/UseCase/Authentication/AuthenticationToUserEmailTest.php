<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserEmail;
use App\Domain\UseCase\Authentication\AuthenticationToUserEmail;
use App\Domain\Specification\Authentication\AuthenticationUserEmailSpecification;
use ValueObjects\Web\EmailAddress;

/**
 * Class AuthenticationUserEmailSpecificationTest
 * @package Test\Unit\Domain\Specification\Authentication
 */
class AuthenticationToUserEmailTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|AuthenticationUserEmailSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(AuthenticationUserEmailSpecification::class);
        $this->useCase = new AuthenticationToUserEmail($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserEmail(new User(new UserId()), new EmailAddress('test@test.com'));
        $this->specification->shouldReceive('find')->andReturn($entity);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result instanceof UserEmail);
    }
}
