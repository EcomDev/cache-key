<?php

namespace spec\EcomDev\CacheKey\Converter;

use EcomDev\CacheKey;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KeyValueConverterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new CacheKey\Converter\ScalarConverter());
    }

    function it_implements_converter_interface()
    {
        $this->shouldImplement(CacheKey\ConverterInterface::class);
    }

    function it_does_not_convert_scalars()
    {
        $this->convert(true)->shouldReturn(false);
        $this->convert(false)->shouldReturn(false);
        $this->convert(100)->shouldReturn(false);
    }

    function it_does_not_convert_objects()
    {
        $this->convert(new \stdClass())->shouldReturn(false);
    }

    function it_does_not_convert_complex_arrays()
    {
        $this->convert(['key' => ['value' => 'test']])->shouldReturn(false);
        $this->convert(['key' => new \stdClass()])->shouldReturn(false);
    }

    function it_does_not_convert_empty_key_value_pair()
    {
        $this->convert([])->shouldReturn(false);
        $this->convert(['' => ''])->shouldReturn(false);
    }

    function it_converts_key_value_pairs()
    {
        $this->convert(['key1' => 'value1', 'key2' => 'value2'])->shouldReturn('key1_value1_key2_value2');
    }
}
