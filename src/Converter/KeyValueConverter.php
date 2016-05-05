<?php

namespace EcomDev\CacheKey\Converter;

use EcomDev\CacheKey\ConverterInterface;

/**
 * Key value converter
 *
 * Converts simple key value associative array
 */
class KeyValueConverter implements ConverterInterface
{
    /**
     * Scalar value converter
     *
     * @var ConverterInterface
     */
    private $converter;

    /**
     * Configures sub converter as dependency for key and value values
     *
     * @param ConverterInterface $converter
     */
    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

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
        if (!is_array($value)) {
            return false;
        }


        if (empty($value)) {
            return false;
        }

        $result = '';

        foreach ($value as $key => $item) {
            if (!is_scalar($item)) {
                return false;
            }

            if (empty($key)
                && !is_int($key)
                && empty($item)
                && !is_int($item)
            ) {
                return false;
            }

            $result .= $this->converter->convert($key) . '_' . $this->converter->convert($item) . '_';
        }

        return rtrim($result, '_');
    }
}
