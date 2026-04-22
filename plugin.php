<?php
/**
 * Plugin Name:       Wistia Embed Block
 * Description:       Embed a Wistia video.
 * Plugin URI:        https://github.com/s3rgiosan/wistia-embed-block
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Version:           1.5.0
 * Author:            Sérgio Santos
 * Author URI:        https://s3rgiosan.dev/?utm_source=wp-plugins&utm_medium=wistia-embed-block&utm_campaign=author-uri
 * License:           GPL-3.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-3.0-or-later.html
 * Update URI:        https://s3rgiosan.dev/
 * GitHub Plugin URI: https://github.com/s3rgiosan/wistia-embed-block
 * Text Domain:       wistia-embed-block
 */

namespace S3S\WP\WistiaEmbedBlock;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'S3S_WISTIA_EMBED_BLOCK_PATH', plugin_dir_path( __FILE__ ) );
define( 'S3S_WISTIA_EMBED_BLOCK_URL', plugin_dir_url( __FILE__ ) );

if ( file_exists( S3S_WISTIA_EMBED_BLOCK_PATH . 'vendor/autoload.php' ) ) {
	require_once S3S_WISTIA_EMBED_BLOCK_PATH . 'vendor/autoload.php';
}

PucFactory::buildUpdateChecker(
	'https://github.com/s3rgiosan/wistia-embed-block/',
	__FILE__,
	'wistia-embed-block'
);

/**
 * Load the plugin.
 */
add_action(
	'plugins_loaded',
	function () {
		$plugin = Plugin::get_instance();
		$plugin->setup();
	}
);
