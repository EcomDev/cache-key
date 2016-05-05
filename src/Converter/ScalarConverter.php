<?php

namespace EcomDev\CacheKey\Converter;

use EcomDev\CacheKey\ConverterInterface;

/**
 * Scalar value converter
 *
 * Converts booleans, integers and floats into string
 */
class ScalarConverter implements ConverterInterface
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
    public function convert($value)
    {
        if (!is_scalar($value)) {
            return false;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_float($value)) {
            return sprintf('float_%.4f', $value);
        }

        $prefix = '';

        if (!is_bool($value)) {
            $prefix = gettype($value) . '_';
        }

        
        return $prefix . var_export($value, true);
    }
}
