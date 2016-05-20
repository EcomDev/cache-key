<?php

namespace EcomDev\CacheKey\Normalizer;

use EcomDev\CacheKey\NormalizerInterface;

/**
 * Encode Normalizer
 *
 * Encodes all characters that are not alphanum, dash, underscore or dots
 * Also it makes all characters lower cased
 *
 * Fully PSR-6 compliant cache key generator
 */
class EncodeNormalizer implements NormalizerInterface
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
    public function normalize($key)
    {
        return strtolower(strtr(
            filter_var(
                $key,
                FILTER_SANITIZE_ENCODED,
                FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_AMP
            ),
            [
                '%' => ''
            ]
        ));
    }
}
