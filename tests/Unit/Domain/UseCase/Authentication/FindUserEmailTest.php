<?php
declare(strict_types=1);

namespace Test\Unit\Domain\UseCase\Authentication;

use Tests\TestCase;
use Mockery as M;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\UserEmail;
use App\Domain\UseCase\Authentication\FindUserEmail;
use App\Domain\Specification\Authentication\FindUserEmailSpecification;
use ValueObjects\Web\EmailAddress;

/**
 * Class FindUserEmailTest
 * @package Test\Unit\Domain\UseCase\Authentication
 */
class FindUserEmailTest extends TestCase
{
    /**
     * @var
     */
    private $useCase;
    
    /**
     * @var M\Mock|FindUserEmailSpecification
     */
    private $specification;
    
    public function setUp()
    {
        $this->specification = M::mock(FindUserEmailSpecification::class);
        $this->useCase = new FindUserEmail($this->specification);
    }
    
    public function testRun()
    {
        $entity = new UserEmail(new User(new UserId()), new EmailAddress('test@test.com'));
        $this->specification->shouldReceive('find')->andReturn($entity);
        $result = $this->useCase->run($entity);
        $this->assertTrue($result instanceof UserEmail);
    }
}
