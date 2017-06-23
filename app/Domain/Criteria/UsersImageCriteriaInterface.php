<?php
declare(strict_types=1);

namespace App\Domain\Criteria;

use PHPMentors\DomainKata\Entity\CriteriaInterface;

/**
 * Interface UsersImageCriteriaInterface
 * @package App\Domain\Criteria
 */
interface UsersImageCriteriaInterface extends CriteriaInterface
{
    /**
     * @param string $userId
     * @param int    $imageId
     * @return bool
     */
    public function add(string $userId, int $imageId): bool;
    
    /**
     * @param string $userId
     * @return bool
     */
    public function findByUserId(string $userId): bool;
    
    /**
     * @param int $imageId
     * @return bool
     */
    public function deleteAtImageId(int $imageId): bool;
    
    /**
     * @param string $userId
     * @return bool
     */
    public function deleteAtUserId(string $userId): bool;
}
