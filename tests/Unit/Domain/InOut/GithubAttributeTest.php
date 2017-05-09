<?php
declare(strict_types=1);

namespace Test\Unit\Domain\InOut;

use Tests\TestCase;
use App\Domain\InOut\GithubAttribute;
use PHPMentors\DomainKata\InOut\InOutInterface;

/**
 * Class GithubAttributeTest
 * @package Test\Unit\Domain\InOut
 */
class GithubAttributeTest extends TestCase
{
    /**
     * @var GithubAttribute
     */
    private $attr;
    
    /**
     * @var \stdClass
     */
    private $dummy;
    
    public function setUp()
    {
        $this->attr  = new GithubAttribute;
        $this->dummy = new \stdClass();
        $this->dummy->token    = 'token';
        $this->dummy->id       = 1234567890;
        $this->dummy->name     = 'name';
        $this->dummy->nickname = 'nickname';
        $this->dummy->email    = 'test@test.com';
        $this->dummy->avatar   = 'http://test.com';
    }
    
    public function testInstance()
    {
        $this->assertTrue($this->attr instanceof InOutInterface);
    }
    
    public function testSet()
    {
        $this->attr->setInput($this->dummy);
        // not use
        $this->attr->setOutput([]);
        // void
        $this->attr->getInput();
        // void
        $this->attr->getOutput();
    }
}
