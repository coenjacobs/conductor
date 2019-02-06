<?php

namespace CoenJacobs\Conductor\Checks;

use CoenJacobs\Conductor\FileReader;
use CoenJacobs\Conductor\Handler;
use CoenJacobs\Conductor\OptionsRepository;

class PluginCheck extends BaseCheck
{
    /** @var OptionsRepository */
    protected $optionsRepository;

    /** @var FileReader */
    protected $fileReader;

    public function __construct()
    {
        $this->optionsRepository = new OptionsRepository();
        $this->fileReader = new FileReader();
    }

    public function getNoticeClass()
    {
        return 'notice notice-error';
    }

    public function getMessage()
    {
        $name = isset($this->arguments['name']) ? $this->arguments['name'] : $this->arguments['slug'];

        if (isset($this->arguments['version'])) {
            $message = 'This plugin requires <b>%s %s</b> or higher to be installed and activated, in order to run.';
            return sprintf($message, $name, $this->arguments['version']);
        } else {
            $message = 'This plugin requires <b>%s</b> to be installed and activated, in order to run.';
            return sprintf($message, $name);
        }
    }

    /**
     * @param Handler $handler
     * @return bool
     */
    public function check(Handler $handler)
    {
        if (false === $active = $this->isActive($this->arguments['slug'])) {
            $handler->reportFailure($this);
        }

        if ($active === true && isset($this->arguments['version'])) {
            if (false === $version = $this->isRequiredVersion($this->arguments['slug'], $this->arguments['version'])) {
                $handler->reportFailure($this);
                return false;
            }
        }

        return $active;
    }

    /**
     * @param string $slug
     * @return bool
     */
    protected function isActive($slug)
    {
        $pluginsOption = $this->optionsRepository->getOption('active_plugins', []);

        return in_array($slug, $pluginsOption);
    }

    /**
     * @param string $slug
     * @param string $version
     * @return bool
     */
    protected function isRequiredVersion($slug, $version)
    {
        if (!$this->isActive($slug)) {
            return false;
        }

        $pluginVersion = $this->fileReader->getPluginVersion($slug);

        return version_compare($pluginVersion, $version, '>=');
    }
}
