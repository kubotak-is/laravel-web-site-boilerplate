<?php
declare(strict_types=1);

namespace App\Foundation;

use App\DataAccess\Cache\CacheInterface;

/**
 * Class LoginChecker
 * @package App\Foundation
 */
class LoginChecker
{
    /**
     * @var CacheInterface
     */
    private $cache;
    
    /**
     * LoginChecker constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * @param string $key
     * @param int    $max
     * @return bool
     */
    public function check(string $key, int $max = 3)
    {
        if (!$key) {
            return true;
        }
        
        $hash = sha1("login-checker:{$key}");
        
        if (!$this->cache->has($hash)) {
            return true;
        }
        
        $count = (int) $this->cache->get($hash);
        
        return $count < $max;
    }
    
    /**
     * @param string $key
     * @param int    $minutes
     */
    public function put(string $key, int $minutes = 10)
    {
        if (!$key) {
            return;
        }
    
        $hash = sha1("login-checker:{$key}");
        
        $count = 1;
        if ($this->cache->has($hash)) {
            $count = (int) $this->cache->get($hash) + 1;
        }
        
        $this->cache->put($hash, $count, $minutes);
    }
}
