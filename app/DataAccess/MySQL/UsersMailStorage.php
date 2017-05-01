<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersMailCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersMailStorage
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
            ->where('user_id', '=', $userId)
            ->get([
                'user_id',
                'email',
                'password',
                'updated_at',
                'created_at',
            ])
            ->toArray();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByEmail(string $email): array
    {
        return (array) $this->db->table(self::TABLE)
            ->join(UsersStorage::TABLE, UsersStorage::TABLE.'.user_id', '=', self::TABLE.'.user_id')
            ->where('email', $email)
            ->where('deleted', false)
            ->first([
                UsersStorage::TABLE.'.user_id',
                'name',
                'frozen',
                'last_login_time',
                'email',
                'password',
                UsersStorage::TABLE.'.updated_at as user.updated_at',
                UsersStorage::TABLE.'.created_at as user.created_at',
                self::TABLE.'.updated_at',
                self::TABLE.'.created_at',
            ]);
    }
}
