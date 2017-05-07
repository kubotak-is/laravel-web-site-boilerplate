<?php
declare(strict_types=1);

namespace App\Domain\Criteria;

use PHPMentors\DomainKata\Entity\CriteriaInterface;

/**
 * Interface UsersGithubCriteriaInterface
 * @package App\Domain\Criteria
 *
 */
interface UsersGithubCriteriaInterface extends CriteriaInterface
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
     * @param string $githubId
     * @return array
     */
    public function findByGithubId(string $githubId): array;
}
