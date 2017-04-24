<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersStorage
 * @package App\DataAccess\MySQL
 */
class UsersStorage extends MySQLConnection implements UsersCriteriaInterface
{
    const TABLE = 'users';
    
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
    public function findById(string $userId, bool $frozen = false, bool $deleted = false): array
    {
        return $this->db->table(self::TABLE)
            ->where([
                'user_id' => $userId,
                'frozen'  => $frozen,
                'deleted' => $deleted,
            ])
            ->get([
                'user_id',
                'name',
                'frozen',
                'deleted',
                'last_login_time',
                'updated_at',
                'created_at',
            ])
            ->toArray();
    }
}
