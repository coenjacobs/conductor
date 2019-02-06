<?php

namespace CoenJacobs\Conductor;

use CoenJacobs\Conductor\Checks\PhpVersionCheck;
use CoenJacobs\Conductor\Checks\PluginCheck;

class ChecksLoader
{
    public function getChecksByArray($arguments = [])
    {
        $checks = [];

        foreach ($arguments as $argument) {
            switch ($argument['type']) {
                case 'php':
                    $check = new PhpVersionCheck();
                    $check->setup($argument);
                    $checks[] = $check;
                    break;
                case 'plugin':
                    $check = new PluginCheck();
                    $check->setup($argument);
                    $checks[] = $check;
                    break;
                default:
                    break;
            }
        }

        return $checks;
    }
}
