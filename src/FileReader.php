<?php

namespace CoenJacobs\Conductor;

/**
 * Class FileReader
 *
 * @package CoenJacobs\Conductor
 */
class FileReader
{
	/**
	 * Get the current version of an installed plugin.
	 *
	 * @param string $slug
	 *
	 * @return false|string
	 */
	public function getPluginVersion($slug)
    {
	    // Stripped down list of headers.
	    $default_headers = [
		    'Version'     => 'Version',
	    ];

	    $plugin_data = get_file_data( WP_PLUGIN_DIR . '/' . $slug, $default_headers, 'plugin' );
	    return ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false; // Set default that you are set to handle as a false.
    }
}
