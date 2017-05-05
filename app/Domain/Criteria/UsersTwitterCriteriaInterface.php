<?php
declare(strict_types=1);

namespace App\Domain\Criteria;

use PHPMentors\DomainKata\Entity\CriteriaInterface;

/**
 * Interface UsersTwitterCriteriaInterface
 * @package App\Domain\Criteria
 */
interface UsersTwitterCriteriaInterface extends CriteriaInterface
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
    
    /**
     * @param string $twitterId
     * @return array
     */
    public function findByTwitterId(string $twitterId): array;
}
