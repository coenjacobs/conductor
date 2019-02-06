<?php

namespace CoenJacobs\Conductor;

class FileReader
{
    public function getPluginVersion($slug)
    {
        $contents = file_get_contents(WP_PLUGIN_DIR .'/' . $slug);
        $matches = [];
        preg_match('/(?:.*)(?:Version:)\s*(.*)?/', $contents, $matches);
        return $matches[1];
    }
}
