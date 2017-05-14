<?php
declare(strict_types=1);

namespace App\Domain\Exception\Authentication;

use Exception;
use ErrorException;

/**
 * Class UserFrozenException
 * @package App\Domain\Exception\Authentication
 */
class UserFrozenException extends ErrorException
{
    /**
     * UserFrozenException constructor.
     * @param string    $message
     * @param int       $code
     * @param int       $severity
     * @param string    $filename
     * @param int       $lineno
     * @param Exception $previous
     */
    public function __construct(
        $message = "",
        $code = 0,
        $severity = 1,
        $filename = __FILE__,
        $lineno = __LINE__,
        Exception $previous = null
    )
    {
        if (empty($message)) {
            $message = "This User is Frozen";
        }
        parent::__construct($message, 500, $severity, $filename, $lineno, $previous);
    }
}
