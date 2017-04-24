<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersMailCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersStorage
 * @package App\DataAccess\MySQL
 */
class UsersMailStorage extends MySQLConnection implements UsersMailCriteriaInterface
{
    const TABLE = 'users_mail';
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function add(array $attributes): bool
    {
        return (bool) $this->db->table(self::TABLE)
            ->insert($attributes);
    }
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function update(string $userId, array $attributes): bool
    {
         return (bool) $this->db->table(self::TABLE)
            ->where([
                'user_id' => $userId,
            ])
            ->update($attributes);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findById(string $userId): array
    {
        return $this->db->table(self::TABLE)
            ->where([
                'user_id' => $userId
            ])
            ->get([
                'user_id',
                'email',
                'password',
                'updated_at',
                'created_at',
            ])
            ->toArray();
    }
}
