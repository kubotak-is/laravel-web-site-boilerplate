<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * Class NotFoundException
 * @package App\Exceptions
 */
class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     * @param string|null    $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = null, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
