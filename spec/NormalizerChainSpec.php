<?php

namespace spec\EcomDev\CacheKey;

use EcomDev\CacheKey\NormalizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NormalizerChainSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    function it_implements_converter_interface()
    {
        $this->shouldHaveType(NormalizerInterface::class);
    }

    function it_calls_all_normalizers_in_chain(
        NormalizerInterface $first,
        NormalizerInterface $second,
        NormalizerInterface $third
    )
    {
        $first->normalize('some_specific_value')->willReturn('first_specific_value')->shouldBeCalled();
        $second->normalize('first_specific_value')->willReturn('second_specific_value')->shouldBeCalled();
        $third->normalize('second_specific_value')->willReturn('third_specific_value')->shouldBeCalled();

        $this->beConstructedWith([
            $first,
            $second,
            $third
        ]);

        $this->normalize('some_specific_value')->shouldReturn('third_specific_value');
    }

    function it_returns_same_value_if_no_items_in_chain()
    {
        $this->normalize('some_specific_value')->shouldReturn('some_specific_value');
    }
}
