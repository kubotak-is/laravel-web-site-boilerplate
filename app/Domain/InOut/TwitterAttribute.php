<?php
declare(strict_types=1);

namespace App\Domain\InOut;

use PHPMentors\DomainKata\InOut\InOutInterface;

/**
 * Class TwitterAttribute
 * @package App\Domain\InOut
 */
class TwitterAttribute implements InOutInterface
{
    /**
     * @var string
     */
    public $token;
    
    /**
     * @var string
     */
    public $tokenSecret;
    
    /**
     * @var string
     */
    public $id;
    
    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string|null
     */
    public $email;
    
    /**
     * @var string
     */
    public $avatar;
    
    /**
     * {@inheritdoc}
     */
    public function setInput($input)
    {
        $this->token       = (string) $input->token;
        $this->tokenSecret = (string) $input->tokenSecret;
        $this->id          = (string) $input->id;
        $this->name        = (string) $input->name;
        $this->email       = (string) $input->email;
        $this->avatar      = (string) $input->avatar_original;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOutput($output)
    {
        // TODO: Implement setOutput() method.
    }
    
    /**
     * {@inheritdoc}
     */
    public function getInput()
    {
        // TODO: Implement getInput() method.
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOutput()
    {
        // TODO: Implement getOutput() method.
    }
}
