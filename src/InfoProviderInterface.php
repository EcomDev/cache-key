<?php

namespace EcomDev\CacheKey;

/**
 * Cache Key Info Provider implementation interface
 *
 * Allows to supply directly into cache key generator and object,
 * that supports this data instead of passing data array
 */
interface InfoProviderInterface
{
    /**
     * Returns cache key info from which cache key will be built up
     *
     * @return mixed
     */
    public function getCacheKeyInfo();
}
