<?php

namespace spec\EcomDev\CacheKey\Converter;

use EcomDev\CacheKey;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HashConverterSpec extends ObjectBehavior
{
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

    function it_converts_array_into_json_based_hash()
    {
        $this->convert(['one' => 'two', 'three' => ['four' => 'five', 'six']])
            ->shouldReturn('e2a76865c15a331eb308bf0f24b1ec1a');
    }

}
