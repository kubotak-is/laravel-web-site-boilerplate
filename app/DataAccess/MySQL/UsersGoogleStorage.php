<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersGoogleCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersGoogleStorage
 * @package App\DataAccess\MySQL
 */
class UsersGoogleStorage extends MySQLConnection implements UsersGoogleCriteriaInterface
{
    const TABLE = 'users_google';
    
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
            ->where('user_id', '=', $userId)
            ->get([
                'user_id',
                'google_id',
                'token',
                'updated_at',
                'created_at',
            ])
            ->toArray();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByGoogleId(string $googleId): array
    {
        return (array) $this->db->table(self::TABLE)
            ->join(UsersStorage::TABLE, UsersStorage::TABLE.'.user_id', '=', self::TABLE.'.user_id')
            ->where('google_id', $googleId)
            ->where('deleted', false)
            ->first([
                UsersStorage::TABLE.'.user_id',
                'name',
                'frozen',
                'last_login_time',
                'google_id',
                'token',
                UsersStorage::TABLE.'.updated_at as user.updated_at',
                UsersStorage::TABLE.'.created_at as user.created_at',
                self::TABLE.'.updated_at',
                self::TABLE.'.created_at',
            ]);
    }
}
