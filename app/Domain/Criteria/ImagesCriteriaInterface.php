<?php
declare(strict_types=1);

namespace App\Domain\Criteria;

use PHPMentors\DomainKata\Entity\CriteriaInterface;

/**
 * Interface ImagesCriteriaInterface
 * @package App\Domain\Criteria
 */
interface ImagesCriteriaInterface extends CriteriaInterface
{
    /**
     * @param array $attributes
     * @return int
     */
    public function add(array $attributes): int;
    
    /**
     * @param int $imageId
     * @return bool
     */
    public function delete(int $imageId): bool;
}
