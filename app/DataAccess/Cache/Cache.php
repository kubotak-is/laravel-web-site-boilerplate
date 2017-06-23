<?php
declare(strict_types=1);

namespace App\DataAccess\Cache;

use Illuminate\Cache\CacheManager;
use Psr\SimpleCache\CacheInterface;

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
     * Cache constructor.
     * @param CacheManager $cache
     * @param string       $cacheKey
     */
    public function __construct(CacheManager $cache, string $cacheKey)
    {
        $this->cache    = $cache;
        $this->cacheKey = $cacheKey;
    }
    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }
        return $this->cache->get($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $minutes = null): bool
    {
        return (bool) $this->cache->put($key, $value, $minutes);
    }
    
    /**
     * {@inheritdoc}
     */
    public function has($key): bool
    {
        return (bool) $this->cache->has($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function delete($key): bool
    {
        return (bool) $this->cache->forget($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function clear(): bool
    {
        return (bool) $this->cache->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMultiple($keys, $default = null): array
    {
        $values = [];
        foreach ($keys as $key) {
            $values[] = $this->get($key, $default);
        }
        return $values;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $val) {
            if (!$this->set($key, $val)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                return false;
            }
        }
        return true;
    }
}
