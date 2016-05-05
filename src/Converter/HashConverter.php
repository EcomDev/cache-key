<?php

namespace EcomDev\CacheKey\Converter;

use EcomDev\CacheKey\ConverterInterface;

/**
 * Converts array values into hash
 */
class HashConverter implements ConverterInterface
{
    /**
     * Converts array values into hash
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function convert($value)
    {
        if (!is_array($value)) {
            return false;
        }

        $value = json_encode($value);
        return md5($value);
    }
}
