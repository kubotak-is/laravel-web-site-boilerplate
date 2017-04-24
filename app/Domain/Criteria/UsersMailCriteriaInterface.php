<?php
declare(strict_types=1);

namespace App\Domain\Criteria;

use PHPMentors\DomainKata\Entity\CriteriaInterface;

/**
 * Interface UsersMailCriteriaInterface
 * @package App\Domain\Criteria
 */
interface UsersMailCriteriaInterface extends CriteriaInterface
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
     * @return array
     */
    public function findById(string $userId): array;
}
