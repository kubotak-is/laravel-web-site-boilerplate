<?php
declare(strict_types=1);

namespace Test\Unit\Domain\InOut;

use Tests\TestCase;
use App\Domain\InOut\GoogleAttribute;
use PHPMentors\DomainKata\InOut\InOutInterface;

/**
 * Class GoogleAttributeTest
 * @package Test\Unit\Domain\InOut
 */
class GoogleAttributeTest extends TestCase
{
    /**
     * @var GoogleAttribute
     */
    private $attr;
    
    /**
     * @var \stdClass
     */
    private $dummy;
    
    public function setUp()
    {
        $this->attr  = new GoogleAttribute;
        $this->dummy = new \stdClass();
        $this->dummy->token           = 'token';
        $this->dummy->id              = 1234567890;
        $this->dummy->nickname        = 'name';
        $this->dummy->email           = 'test@test.com';
        $this->dummy->avatar_original = 'http://test.com';
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
