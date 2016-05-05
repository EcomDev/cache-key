<?php

namespace EcomDev\CacheKey;

/**
 * Invalid argument exception
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * Value, based on which exception message is generated
     *
     * @var mixed
     */
    private $value;

    /**
     * Creates exception with message based on value
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
        parent::__construct($this->generateMessage($value));
    }

    /**
     * Generates message based on variable type
     *
     * @param mixed $value
     *
     * @return string
     */
    private function generateMessage($value)
    {
        if (is_object($value)) {
            return sprintf('An instance of "%s" is not suitable as cache key data', get_class($value));
        }

        return sprintf('A variable of type "%s" is not suitable as cache key data', gettype($value));
    }

    /**
     * Original value that was passed
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
