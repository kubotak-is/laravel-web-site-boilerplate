<?php
declare(strict_types=1);

namespace App\DataAccess\Cache;

use Illuminate\Cache\CacheManager;

/**
 * Class Cache
 * @package App\DataAccess\Cache
 */
class Cache implements CacheInterface
{
    /**
     * @var CacheManager
     */
    protected $cache;
    
    /**
     * @var string
     */
    protected $cacheKey;
    
    /**
     * @var null|int
     */
    protected $minutes;
    
    /**
     * @param CacheManager $cache
     * @param string       $cacheKey
     * @param null|int     $minutes
     */
    public function __construct(CacheManager $cache, string $cacheKey, int $minutes = null)
    {
        $this->cache    = $cache;
        $this->cacheKey = $cacheKey;
        $this->minutes  = $minutes;
    }
    /**
     * {@inheritdoc}
     */
    public function get(string $key)
    {
        return $this->cache->get($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function put(string $key, $value, int $minutes = null)
    {
        if (is_null($minutes)) {
            $minutes = $this->minutes;
        }
        return $this->cache->put($key, $value, $minutes);
    }
    
    /**
     * {@inheritdoc}
     */
    public function has(string $key)
    {
        return $this->cache->has($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function forget(string $key)
    {
        return $this->cache->forget($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->cache->flush();
    }
}
