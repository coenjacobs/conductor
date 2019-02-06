<?php

namespace CoenJacobs\Conductor\Checks;

use CoenJacobs\Conductor\Handler;

class PhpVersionCheck extends BaseCheck
{
    /**
     * @param Handler $handler
     * @return mixed
     */
    public function check(Handler $handler)
    {
        if (false === version_compare(phpversion(), $this->arguments['version'], '>=')) {
            $handler->reportFailure($this);
            return false;
        }

        return true;
    }

    public function getNoticeClass()
    {
        return 'notice notice-error';
    }

    public function getMessage()
    {
        $message = 'This plugin requires <b>PHP %s</b> or higher in order to run.';
        return sprintf($message, $this->arguments['version']);
    }
}
