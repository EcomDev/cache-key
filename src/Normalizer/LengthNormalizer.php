<?php

namespace EcomDev\CacheKey\Normalizer;

use EcomDev\CacheKey\NormalizerInterface;

/**
 * Length Normalizer
 *
 * Normalizes cache key length to not be longer than expected
 */
class LengthNormalizer implements NormalizerInterface
{
    /**
     * Maximum length for key
     *
     * @var int
     */
    private $length;

    /**
     * Configures maximum string length
     *
     * @param int $length
     */
    public function __construct($length = 255)
    {
        $this->length = $length;
    }

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
        if (strlen($key) > $this->length) {
            $checksum = dechex(crc32($key));
            return substr($key, 0, $this->length - strlen($checksum)) . $checksum;
        }

        return $key;
    }
}
