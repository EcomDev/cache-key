<?php

namespace EcomDev\CacheKey;

/**
 * Converter implementation interface
 *
 * Converter is used within generator to convert all
 * non string variables into string representation
 */
interface ConverterInterface
{
    /**
     * Converts value into string for cache key
     *
     * In case if value is not convertible, it should return false
     *
     * @param mixed $value
     *
     * @return string|bool
     */
    public function convert($value);
}
