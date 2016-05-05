<?php

namespace spec\EcomDev\CacheKey;

use EcomDev\CacheKey\ConverterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConverterChainSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    function it_implements_converter_interface()
    {
        $this->shouldHaveType(ConverterInterface::class);
    }

    function it_calls_first_converter_in_chain_calls(
        ConverterInterface $first,
        ConverterInterface $second,
        ConverterInterface $third
    )
    {
        $first->convert('some_specific_value')->willReturn(false)->shouldBeCalled();
        $second->convert('some_specific_value')->willReturn('expected_result')->shouldBeCalled();
        $third->convert(Argument::any())->shouldNotBeCalled();
        
        $this->beConstructedWith([
            $first,
            $second,
            $third
        ]);

        $this->convert('some_specific_value')->shouldReturn('expected_result');
    }

    function it_returns_false_if_none_of_converters_matches()
    {
        $this->convert('some_specific_value')->shouldReturn(false);
    }
}
