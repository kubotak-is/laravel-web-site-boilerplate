<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersTwitterCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersTwitterStorage
 * @package App\DataAccess\MySQL
 */
class UsersTwitterStorage extends MySQLConnection implements UsersTwitterCriteriaInterface
{
    const TABLE = 'users_twitter';
    
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
                'facebook_id',
                'token',
                'token_secret',
                'updated_at',
                'created_at',
            ])
            ->toArray();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByTwitterId(string $twitterId): array
    {
        return (array) $this->db->table(self::TABLE)
            ->join(UsersStorage::TABLE, UsersStorage::TABLE.'.user_id', '=', self::TABLE.'.user_id')
            ->where('twitter_id', $twitterId)
            ->where('deleted', false)
            ->first([
                UsersStorage::TABLE.'.user_id',
                'name',
                'frozen',
                'last_login_time',
                'nickname',
                'twitter_id',
                'token',
                'token_secret',
                UsersStorage::TABLE.'.updated_at as user.updated_at',
                UsersStorage::TABLE.'.created_at as user.created_at',
                self::TABLE.'.updated_at',
                self::TABLE.'.created_at',
            ]);
    }
}
