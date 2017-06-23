<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use ValueObjects\Enum\Enum;

/**
 * Class ImageExt
 * @package App\Domain\ValueObject
 */
class ImageExt extends Enum
{
    const JPEG = 'jpeg';
    const JPG  = 'jpg';
    const PNG  = 'png';
    const GIF  = 'gif';
}
