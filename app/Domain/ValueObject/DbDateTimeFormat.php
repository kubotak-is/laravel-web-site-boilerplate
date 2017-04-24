<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use ValueObjects\DateTime\DateTime;

/**
 * Class DbDateTimeFormat
 * @package App\Domain\ValueObject
 */
class DbDateTimeFormat extends DateTime
{
   const FORMAT = 'Y-m-d H:i:s';
}
