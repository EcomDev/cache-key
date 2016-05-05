<?php

namespace spec\EcomDev\CacheKey\Normalizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LengthNormalizerSpec extends ObjectBehavior
{
    function it_implements_normalizer_interface()
    {
        $this->shouldHaveType('EcomDev\CacheKey\NormalizerInterface');
    }

    function it_is_possible_to_specify_custom_max_length()
    {
        $this->beConstructedWith(32);
        $this->normalize('this_is_longer_than_thirty_two_characters')->shouldReturn(
            'this_is_longer_than_thirabff9ba9'
        );
    }

    function it_does_not_normalize_by_default_string_which_is_longer_than_255_characters()
    {
        $this->normalize('this_is_to_short_to_cut')->shouldReturn('this_is_to_short_to_cut');
        $this
            ->normalize(
                'this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_'
                . 'this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_'
                . 'this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_this_is_still_t'
            )->shouldReturn(
                'this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_'
                . 'this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_'
                . 'this_is_still_to_short_to_cut_this_is_still_to_short_to_cut_this_is_still_t'
            );
    }

    function it_normalizes_string_that_is_longer_than_255_characters()
    {
        $this
            ->normalize(
                'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to_cut_'
                . 'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to_cut_'
                . 'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to_cut_'
                . 'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to_cut_'
            )->shouldReturn(
                'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to_cut_'
                . 'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to_cut_'
                . 'this_is_right_length_to_cut_this_is_right_length_to_cut_this_is_right_length_to5c81d1f1'
            );
    }


}
