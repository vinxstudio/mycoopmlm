<?php

namespace App\Helpers;

use App\Helpers\MultidimensionalArrayHelper;

class MultidimensionalArrayHelper
{

    function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {

            if (($strict ? $item === $needle : $item == $needle || (is_array($item) && $this->in_array_r($needle, $item, $strict)))) {
                return true;
            }
        }

        return false;
    }

}