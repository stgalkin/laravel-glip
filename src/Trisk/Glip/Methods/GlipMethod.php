<?php

namespace Trisk\Glip\Methods;

use Illuminate\Contracts\Cache\Repository as Cache;
use Trisk\Glip\Contracts\ApiContract;

/**
 * Class GlipMethod
 *
 * @package Trisk\Glip\Methods
 */
abstract class GlipMethod
{
    /**
     * @var ApiContract
     */
    protected $api;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cachePrefix = '__trisk_glip_';

    /**
     * @param ApiContract  $api
     * @param Cache $cache
     */
    public function __construct(ApiContract $api, Cache $cache)
    {
        $this->api = $api;
        $this->cache = $cache;
    }

    /**
     * Returns the api.
     * @return ApiContract
     */
    public function api(): ApiContract
    {
        return $this->api;
    }

    /**
     * Cache a value.
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $minutes Default 1
     *
     * @return mixed
     */
    public function cachePut($key, $value, $minutes = 1)
    {
        $this->cache->put($this->cachePrefix($key), $value, $minutes);

        return $value;
    }

    /**
     * Remember the result value for a given closure.
     * @param $key
     * @param $minutes
     * @param $callback
     *
     * @return mixed
     */
    public function cacheRemember($key, $minutes, $callback)
    {
        return $this->cache->remember($this->cachePrefix($key), $minutes, $callback);
    }

    /**
     * Remember the result value for a closure forever.
     * @param $key
     * @param $callback
     *
     * @return mixed
     */
    public function cacheRememberForever($key, $callback)
    {
        return $this->cache->rememberForever($this->cachePrefix($key), $callback);
    }

    /**
     * Get a cache for a given key.
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function cacheGet($key, $default = null)
    {
        return $this->cache->get($this->cachePrefix($key), $default);
    }

    /**
     * Cache a value forever.
     * @param $key
     * @param $value
     */
    public function cacheForever($key, $value)
    {
        $this->cache->forever($this->cachePrefix($key), $value);
    }

    /**
     * Forget a value for a given key.
     * @param $key
     */
    public function cacheForget($key)
    {
        $this->cache->forget($this->cachePrefix($key));
    }

    /**
     * Get the default key prefix.
     *
     * @param string|null $key
     *
     * @return string
     */
    protected function cachePrefix($key = null)
    {
        return $this->cachePrefix.$key;
    }
}
