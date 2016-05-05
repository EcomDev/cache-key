<?php

namespace EcomDev\CacheKey;

/**
 * Normalizer Chain
 *
 * Used to combine multiple normalizers together
 *
 * All of the chains needs to be invoked, one by one
 */
class NormalizerChain implements NormalizerInterface
{
    /**
     * Chain of normalizers
     *
     * @var NormalizerInterface[]
     */
    private $chain;

    /**
     * Configures normalizer chain
     *
     * @param NormalizerInterface[] $chain
     */
    public function __construct(array $chain)
    {
        $this->chain = $chain;
    }

    /**
     * Normalizes key by calling each item in chain
     *
     * @param string $key
     *
     * @return string
     */
    public function normalize($key)
    {
        foreach ($this->chain as $normalizer) {
            $key = $normalizer->normalize($key);
        }

        return $key;
    }
}
