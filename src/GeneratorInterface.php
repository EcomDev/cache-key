<?php


namespace EcomDev\CacheKey;

/**
 * Cache key generator implementation interface
 *
 * Plays a role of configurable facade
 * that uses converters and normalizers for cache key generation
 */
interface GeneratorInterface
{
    /**
     * Generates a cache key based on provided data
     *
     * @param mixed $data
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function generate($data);
}
