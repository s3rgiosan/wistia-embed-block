<?php
/**
 * Plugin Name:       Wistia Embed Block
 * Description:       Embed a Wistia video.
 * Plugin URI:        https://github.com/s3rgiosan/wistia-embed-block
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Version:           1.2.0
 * Author:            Sérgio Santos
 * Author URI:        https://s3rgiosan.dev/?utm_source=wp-plugins&utm_medium=wistia-embed-block&utm_campaign=author-uri
 * License:           GPL-3.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-3.0-or-later.html
 * Text Domain:       wistia-embed-block
 *
 * @package           WistiaEmbedBlock
 */

namespace S3S\WP\WistiaEmbedBlock;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'S3S_WISTIA_EMBED_BLOCK_PATH', plugin_dir_path( __FILE__ ) );
define( 'S3S_WISTIA_EMBED_BLOCK_URL', plugin_dir_url( __FILE__ ) );

// Define the Wistia embed pattern.
const WISTIA_EMBED_PATTERN = '#https?://[^.]+\.(wistia\.com|wi\.st)/(medias|embed)/.*#';

if ( file_exists( S3S_WISTIA_EMBED_BLOCK_PATH . 'vendor/autoload.php' ) ) {
	require_once S3S_WISTIA_EMBED_BLOCK_PATH . 'vendor/autoload.php';
}

PucFactory::buildUpdateChecker(
	'https://github.com/s3rgiosan/wistia-embed-block/',
	__FILE__,
	'wistia-embed-block'
)->setBranch( 'main' );

/**
 * Add Wistia as an oEmbed provider.
 *
 * @return void
 */
function add_oembed_provider() {

	wp_oembed_add_provider(
		WISTIA_EMBED_PATTERN,
		'https://fast.wistia.com/oembed',
		true
	);
}

add_action( 'init', __NAMESPACE__ . '\add_oembed_provider' );

/**
 * Enqueue the Wistia embed block variation.
 *
 * @return void
 */
function enqueue_block_editor_assets() {

	$asset_file = sprintf(
		'%s/build/index.asset.php',
		untrailingslashit( S3S_WISTIA_EMBED_BLOCK_PATH )
	);

	$asset        = file_exists( $asset_file ) ? require $asset_file : null;
	$dependencies = isset( $asset['dependencies'] ) ? $asset['dependencies'] : [];
	$version      = isset( $asset['version'] ) ? $asset['version'] : filemtime( $asset_file );

	wp_enqueue_script(
		'wistia-embed-block',
		sprintf(
			'%s/build/index.js',
			untrailingslashit( S3S_WISTIA_EMBED_BLOCK_URL )
		),
		$dependencies,
		$version,
		true
	);
}

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );

/**
 * Filter the REST response to change the provider name.
 *
 * @param  \WP_REST_Response|\WP_HTTP_Response|\WP_Error|mixed $response Result to send to the client.
 * @param  array                                               $handler  Route handler used for the request.
 * @param  \WP_REST_Request                                    $request  Request used to generate the response.
 * @return \WP_REST_Response|\WP_HTTP_Response|\WP_Error|mixed
 */
function update_provider_name( $response, $handler, $request ) {

	// Ignore requests that are not for the oEmbed proxy.
	if ( false === strpos( $request->get_route(), '/oembed/1.0/proxy' ) ) {
		return $response;
	}

	$params = $request->get_params();

	// Only update the provider name for Wistia oEmbeds.
	if ( ! isset( $params['url'] ) || ! preg_match( WISTIA_EMBED_PATTERN, $params['url'] ) ) {
		return $response;
	}

	if ( is_object( $response ) && isset( $response->provider_name ) ) {
		$response->provider_name = 'Wistia';
	}

	return $response;
}

add_filter( 'rest_request_after_callbacks', __NAMESPACE__ . '\update_provider_name', 10, 3 );
