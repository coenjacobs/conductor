<?php

namespace CoenJacobs\Conductor\Checks;

use CoenJacobs\Conductor\Contracts\Check;

abstract class BaseCheck implements Check
{
    /** @var array */
    protected $arguments = [];

    public function setup($arguments = [])
    {
        $this->arguments = $arguments;
    }
}
