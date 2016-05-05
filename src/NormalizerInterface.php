<?php

namespace EcomDev\CacheKey;

/**
 * Normalizer implementation interface
 *
 * Normalizer is used within generator to normalize cache key string into
 */
interface NormalizerInterface
{
    /**
     * Normalizes string key representation
     *
     * Should not rise any exceptions,
     * just sanitize or remove not allowed characters
     *
     * @param string $key
     *
     * @return string
     */
    public function normalize($key);
}
