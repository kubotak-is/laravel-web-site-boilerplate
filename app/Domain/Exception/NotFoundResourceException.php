<?php
declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;
use ErrorException;

/**
 * Class NotFoundResourceException
 * @package App\Domain\Exception
 */
class NotFoundResourceException extends ErrorException
{
    public function __construct(
        $message = "",
        $code = 0,
        $severity = 1,
        $filename = __FILE__,
        $lineno = __LINE__,
        Exception $previous = null
    ) {
        parent::__construct($message, 404, $severity, $filename, $lineno, $previous);
    }
}
