<?php
declare(strict_types=1);

namespace App\Domain\Criteria;

use PHPMentors\DomainKata\Entity\CriteriaInterface;

/**
 * Interface UsersCriteriaInterface
 * @package App\Domain\Criteria
 */
interface UsersCriteriaInterface extends CriteriaInterface
{
    /**
     * @param array $attributes
     * @return bool
     */
    public function add(array $attributes): bool;
    
    /**
     * @param string $userId
     * @param array  $attributes
     * @return bool
     */
    public function update(string $userId, array $attributes): bool;
    
    /**
     * @param string $userId
     * @param bool   $frozen
     * @param bool   $deleted
     * @return array
     */
    public function findById(string $userId, bool $frozen = false, bool $deleted = false): array;
}
