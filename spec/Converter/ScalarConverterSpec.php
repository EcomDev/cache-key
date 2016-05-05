<?php

namespace spec\EcomDev\CacheKey\Converter;

use EcomDev\CacheKey\ConverterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScalarConverterSpec extends ObjectBehavior
{
    function it_implements_converter_interface()
    {
        $this->shouldImplement(ConverterInterface::class);
    }

    function it_converts_boolean_into_string()
    {
        $this->convert(true)->shouldReturn('true');
        $this->convert(false)->shouldReturn('false');
    }

    function it_converts_numbers_into_string_with_prefix()
    {
        $this->convert(1)->shouldReturn('integer_1');
        $this->convert(1.1)->shouldReturn('float_1.1000');
    }

    function it_does_not_convert_arrays()
    {
        $this->convert([])->shouldReturn(false);
    }

    function it_does_not_convert_objects()
    {
        $this->convert(new \stdClass())->shouldReturn(false);
    }

    function it_returns_string_as_is()
    {
        $this->convert('string')->shouldReturn('string');
    }
}
