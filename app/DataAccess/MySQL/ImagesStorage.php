<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use App\Domain\Criteria\ImagesCriteriaInterface;
use Ytake\LaravelAspect\Annotation\Loggable;

/**
 * Class ImagesStorage
 * @package App\DataAccess\MySQL
 */
class ImagesStorage extends MySQLConnection implements ImagesCriteriaInterface
{
    const TABLE = 'images';
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function add(array $attributes): int
    {
        return (int) $this->db->table(self::TABLE)
            ->insertGetId($attributes);
    }
    
    /**
     * @Loggable()
     * {@inheritdoc}
     */
    public function delete(int $imageId): bool
    {
        return (bool) $this->db->table(self::TABLE)
            ->where([
                'image_id' => $imageId,
            ])
            ->delete();
    }
}
