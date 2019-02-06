<?php

namespace CoenJacobs\Conductor;

use CoenJacobs\Conductor\Contracts\Check;

class Messages
{
    /** @var array */
    public $checks = [];

    public function setup($checks = [])
    {
        $this->checks = $checks;

        add_action('admin_notices', [$this, 'outputNoticesForChecks']);
    }

    public function outputNoticesForChecks()
    {
        /** @var Check $check */
        foreach ($this->checks as $check) {
            $class = $check->getNoticeClass();
            $message = $check->getMessage();

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        }
    }
}