<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersImageCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersImageStorage
 * @package App\DataAccess\MySQL
 */
class UsersImageStorage extends MySQLConnection implements UsersImageCriteriaInterface
{
    const TABLE = 'users_image';
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function add(string $userId, int $imageId): bool
    {
        return (bool) $this->db->table(self::TABLE)
            ->insert([
                'user_id'  => $userId,
                'image_id' => $imageId,
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByUserId(string $userId): bool
    {
        $collection = $this->db->table(self::TABLE)
            ->where([
                'user_id' => $userId,
            ])
            ->get(['user_id']);
        return $collection->count() > 0;
    }
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function deleteAtUserId(string $userId): bool
    {
         return (bool) $this->db->table(self::TABLE)
            ->where([
                'user_id' => $userId,
            ])
            ->delete();
    }
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function deleteAtImageId(int $imageId): bool
    {
        return (bool) $this->db->table(self::TABLE)
            ->where([
                'image_id' => $imageId,
            ])
            ->delete();
    }
}
