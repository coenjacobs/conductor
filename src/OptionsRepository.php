<?php

namespace CoenJacobs\Conductor;

class OptionsRepository
{
    public function getOption($option, $default = [])
    {
        return get_option($option, $default);
    }
}
