<?php

namespace spec\EcomDev\CacheKey;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidArgumentExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('string');
    }

    function it_should_be_extended_from_native_invalid_argument_exception()
    {
        $this->shouldImplement(\InvalidArgumentException::class);
    }

    function it_should_generate_message_based_on_internal_php_type_string()
    {
        $this->beConstructedWith('some_text_value');
        $this->getMessage()->shouldReturn('A variable of type "string" is not suitable as cache key data');
    }

    function it_should_generate_message_based_on_internal_php_type_int()
    {
        $this->beConstructedWith(1000);
        $this->getMessage()->shouldReturn('A variable of type "integer" is not suitable as cache key data');
    }

    function it_should_generate_custom_message_for_object()
    {
        $this->beConstructedWith(new \stdClass());
        $this->getMessage()->shouldReturn('An instance of "stdClass" is not suitable as cache key data');
    }

    function it_should_return_passed_value()
    {
        $value = new \stdClass();
        $this->beConstructedWith($value);
        $this->getValue()->shouldReturn($value);
    }
}
