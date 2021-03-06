<?php

namespace spec\EcomDev\CacheKey\Normalizer;

use EcomDev\CacheKey\NormalizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EncodeNormalizerSpec extends ObjectBehavior
{
    function it_implements_normalizer_interface()
    {
        $this->shouldHaveType(NormalizerInterface::class);
    }

    function it_encodes_everything_except_alphanums_hypen_and_underscores()
    {
        $this->normalize('this:is../not&a#valid91code')->shouldReturn('this3ais..2fnot26a23valid91code');
        
    }
    
    function it_lowers_uppercase_characters()
    {
        $this->normalize('ThisIsUpperCASE')->shouldReturn('thisisuppercase');
    }

    function it_allows_underscore_and_hypen_and_dot()
    {
        $this->normalize('this-is-a-valid-key')->shouldReturn('this-is-a-valid-key');
        $this->normalize('this_is_a_valid_key')->shouldReturn('this_is_a_valid_key');
        $this->normalize('this.is.a.valid.key')->shouldReturn('this.is.a.valid.key');
    }
}
