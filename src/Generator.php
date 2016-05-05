<?php

namespace EcomDev\CacheKey;

/**
 * Default cache key generator implementation
 *
 * Plays a role of configurable facade
 * that uses converters and normalizers for cache key generation
 */
class Generator implements GeneratorInterface
{
    /**
     * Converter of data inot key value
     *
     * @var ConverterInterface
     */
    private $converter;

    /**
     * Normalizer for key value
     *
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * Cache key prefix
     *
     * @var string|null
     */
    private $prefix;

    /**
     * Configures generator dependencies
     *
     * @param NormalizerInterface $normalizer
     * @param ConverterInterface $converter
     * @param string|null $prefix
     */
    public function __construct(
        NormalizerInterface $normalizer,
        ConverterInterface $converter = null,
        $prefix = null
    ) {
    
        $this->converter = $converter;
        $this->normalizer = $normalizer;
        $this->prefix = $prefix;
    }

    /**
     * Generates a cache key based on provided data
     *
     * @param mixed $data
     *
     * @return string
     * @throws InvalidArgumentException in case if value was not converted
     */
    public function generate($data)
    {
        if ($data instanceof InfoProviderInterface) {
            $data = $data->getCacheKeyInfo();
        }

        if ($this->converter && !is_string($data)) {
            $convertedData = $this->converter->convert($data);
            if ($convertedData === false) {
                throw new InvalidArgumentException($data);
            }

            $data = $convertedData;
        } elseif (!is_string($data)) {
            throw new InvalidArgumentException($data);
        }

        $cacheKey = $this->normalizer->normalize($data);

        if ($this->prefix) {
            return $this->prefix . $cacheKey;
        }

        return $cacheKey;
    }
}
