<?php

namespace spec\EcomDev\CacheKey\Normalizer;

use EcomDev\CacheKey\Normalizer\EncodeNormalizer;
use EcomDev\CacheKey\Normalizer\LengthNormalizer;
use EcomDev\CacheKey\NormalizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Psr6NormalizerSpec extends ObjectBehavior
{

    function it_implements_normalizer_interface(
        EncodeNormalizer $encodeNormalizer, LengthNormalizer $lengthNormalizer
    )
    {
        $this->beConstructedWith($encodeNormalizer, $lengthNormalizer);
        $this->shouldHaveType(NormalizerInterface::class);
    }

    function it_uses_encode_and_length_normalizer_as_dependency(
        EncodeNormalizer $encodeNormalizer, LengthNormalizer $lengthNormalizer
    )
    {
        $this->beConstructedWith($encodeNormalizer, $lengthNormalizer);
        $encodeNormalizer->normalize('value1')->willReturn('value2')->shouldBeCalled();
        $lengthNormalizer->normalize('value2')->willReturn('value_normalized')->shouldBeCalled();
        $this->normalize('value1')->shouldReturn('value_normalized');
    }

    function it_has_factory_to_create_it_with_needed_normalizers()
    {
        $this->beConstructedThrough('create');
        $this->normalize('some-in&valid-012931231value')->shouldReturn('some-in26valid-012931231value');
        $this->normalize('some-very-long-value-that-is-longer-than-sixty-four-characters-can-you-belive-it')
            ->shouldReturn('some-very-long-value-that-is-longer-than-sixty-four-char485b813b');
    }
}
