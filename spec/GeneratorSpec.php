<?php

namespace spec\EcomDev\CacheKey;

use EcomDev\CacheKey;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorSpec extends ObjectBehavior
{
    /**
     * @var CacheKey\ConverterInterface;
     */
    private $converter;

    /**
     * @var CacheKey\NormalizerInterface
     */
    private $normalizer;

    function let(CacheKey\ConverterInterface $converter, CacheKey\NormalizerInterface $normalizer)
    {
        $this->converter = $converter;
        $this->normalizer = $normalizer;
        $this->beConstructedWith($this->normalizer, $this->converter);
        $this->normalizer->normalize(Argument::type('string'))->willReturnArgument(0);
    }

    function it_implements_generator_interface()
    {
        $this->shouldImplement(CacheKey\GeneratorInterface::class);
    }

    function it_should_be_possible_to_use_generator_without_converter()
    {
        $this->beConstructedWith($this->normalizer);
        $this->generate('some_value')->shouldReturn('some_value');
    }

    function it_does_not_call_converter_if_value_is_a_string()
    {
        $this->converter->convert(Argument::any())->shouldNotBeCalled();
        $this->generate('string_value')->shouldReturn('string_value');
    }

    function it_should_be_possible_to_specify_prefix()
    {
        $this->beConstructedWith($this->normalizer, $this->converter, 'prefix_');
        $this->converter->convert(true)->willReturn('true');
        $this->converter->convert(false)->willReturn('false');

        $this->generate('string_value')->shouldReturn('prefix_string_value');
        $this->generate(true)->shouldReturn('prefix_true');
        $this->generate(false)->shouldReturn('prefix_false');
    }

    function it_calls_converter_if_value_is_not_a_string()
    {
        $this->converter->convert(true)->willReturn('true');
        $this->converter->convert(false)->willReturn('false');

        $this->generate(true)->shouldReturn('true');
        $this->generate(false)->shouldReturn('false');
    }

    function it_allows_info_provider_to_supply_custom_data_for_key_generator(CacheKey\InfoProviderInterface $info)
    {
        $info->getCacheKeyInfo()->willReturn(['array', 'of', 'some', 'data']);

        $this->converter->convert(['array', 'of', 'some', 'data'])->willReturn('converted_some_data');
        $this->generate($info)->shouldReturn('converted_some_data');
    }

    function it_should_throw_an_exception_if_value_was_not_converted()
    {
        $this->converter->convert([])->willReturn(false);
        $this->shouldThrow(new CacheKey\InvalidArgumentException([]))->duringGenerate([]);
    }

    function it_should_throw_an_exception_if_there_is_no_converter_and_value_is_unknown()
    {
        $this->beConstructedWith($this->normalizer);
        $this->shouldThrow(new CacheKey\InvalidArgumentException([]))->duringGenerate([]);
    }
}
