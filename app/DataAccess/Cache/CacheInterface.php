<?php

namespace App\DataAccess\Cache;

/**
 * Interface CacheInterface
 * @package App\DataAccess\Cache
 */
interface CacheInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);
    
    /**
     * @param string   $key
     * @param mixed    $value
     * @param null|int $minutes
     * @return mixed
     */
    public function put(string $key, $value, int $minutes = null);
    
    /**
     * @param string $key
     * @return mixed
     */
    public function has(string $key);
    
    /**
     * @param string $key
     * @return mixed
     */
    public function forget(string $key);
    
    /**
     * @return void
     */
    public function flush();
}
