<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\UsersGithubCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class UsersGithubStorage
 * @package App\DataAccess\MySQL
 */
class UsersGithubStorage extends MySQLConnection implements UsersGithubCriteriaInterface
{
    const TABLE = 'users_github';
    
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
                'github_id',
                'nickname',
                'token',
                'updated_at',
                'created_at',
            ])
            ->toArray();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByGithubId(string $githubId): array
    {
        return (array) $this->db->table(self::TABLE)
            ->join(UsersStorage::TABLE, UsersStorage::TABLE.'.user_id', '=', self::TABLE.'.user_id')
            ->where('github_id', $githubId)
            ->where('deleted', false)
            ->first([
                UsersStorage::TABLE.'.user_id',
                'name',
                'frozen',
                'last_login_time',
                'github_id',
                'nickname',
                'token',
                UsersStorage::TABLE.'.updated_at as user.updated_at',
                UsersStorage::TABLE.'.created_at as user.created_at',
                self::TABLE.'.updated_at',
                self::TABLE.'.created_at',
            ]);
    }
}
