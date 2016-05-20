<?php

namespace EcomDev\CacheKey\Normalizer;


use EcomDev\CacheKey\NormalizerInterface;


/**
 * PSR-6 Normalizer
 *
 * By default follows these rules:
 * Implementing libraries MUST support keys consisting of the characters A-Z, a-z, 0-9, _,
 * and . in any order in UTF-8 encoding and a length of up to 64 characters.
 */
class Psr6Normalizer implements NormalizerInterface
{
    /**
     * Encode normalizer
     *
     * @var EncodeNormalizer
     */
    private $encodeNormalizer;

    /**
     * Length normalizer
     *
     * @var LengthNormalizer
     */
    private $lengthNormalizer;

    /**
     * Configured dependencies
     *
     * @param EncodeNormalizer $encodeNormalizer
     * @param LengthNormalizer $lengthNormalizer
     */
    public function __construct(
        EncodeNormalizer $encodeNormalizer,
        LengthNormalizer $lengthNormalizer
    )
    {
        $this->encodeNormalizer = $encodeNormalizer;
        $this->lengthNormalizer = $lengthNormalizer;
    }

    /**
     * Creates a new instance of PSR-6 compatible normalizer
     *
     * @return static
     */
    public static function create()
    {
        return new static(new EncodeNormalizer(), new LengthNormalizer(64));
    }

    /**
     * Normalizes key according to PSR-6 specification
     *
     * @param string $key
     * @return string
     */
    public function normalize($key)
    {
        return $this->lengthNormalizer->normalize(
            $this->encodeNormalizer->normalize($key)
        );
    }

}
