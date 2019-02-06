<?php

namespace CoenJacobs\Conductor;

use CoenJacobs\Conductor\Contracts\Check;
use CoenJacobs\Conductor\Checks\BaseCheck;

class Handler
{
    /** @var array */
    protected $checks = [];

    /** @var array */
    protected $failures = [];

    /** @var ChecksLoader */
    protected $checksLoader;

    public function __construct()
    {
        $this->checksLoader = new ChecksLoader();
    }

    /**
     * @param array $arguments
     */
    public function setup($arguments = [])
    {
        $this->checks = $this->checksLoader->getChecksByArray($arguments);
    }

    /**
     * @param bool $returnOnFail
     * @return bool
     */
    public function check($returnOnFail = false)
    {
        $endResult = true;

        /** @var Check $check */
        foreach ($this->checks as $check) {
            $result = $check->check($this);

            if ($result === false) {
                if ($returnOnFail === true) {
                    return false;
                }

                $endResult = false;
            }
        }

        return $endResult;
    }

    /**
     * @param BaseCheck $check
     */
    public function reportFailure(BaseCheck $check)
    {
        $this->failures[] = $check;
    }

    /**
     * @return array
     */
    public function getFailures()
    {
        return $this->failures;
    }
}
