<?php

namespace EcomDev\CacheKey;

/**
 * Converter Chain
 *
 * Used to combine multiple converters together
 *
 * If one of the converters returns non `false` value, then its value will be returned
 */
class ConverterChain implements ConverterInterface
{
    /**
     * Chain of converter interfaces
     *
     * @var ConverterInterface[]
     */
    private $chain;

    /**
     * Configures chain based converter
     *
     * @param ConverterInterface[] $chain
     */
    public function __construct(array $chain = [])
    {
        $this->chain = $chain;
    }

    /**
     * Converts incoming data into string
     *
     * Walks over all converters,
     * if some of them gives a match, then
     *
     * @param mixed $data
     *
     * @return string|bool
     */
    public function convert($data)
    {
        foreach ($this->chain as $converter) {
            $result = $converter->convert($data);
            if ($result !== false) {
                return $result;
            }
        }
        
        return false;
    }
}
