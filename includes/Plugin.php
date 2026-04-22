<?php

namespace S3S\WP\WistiaEmbedBlock;

class Plugin {

	/**
	 * Wistia embed pattern.
	 *
	 * @var string
	 */
	const EMBED_PATTERN = '#https?://[^.]+\.(wistia\.com|wi\.st|wistia\.net)/(medias|embed)/.*#';

	/**
	 * Plugin singleton instance.
	 *
	 * @var Plugin $instance Plugin Singleton instance
	 */
	public static $instance = null;

	/**
	 * Get the singleton instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Setup hooks.
	 */
	public function setup() {
		add_action( 'init', [ $this, 'add_oembed_provider' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );
		add_filter( 'rest_request_after_callbacks', [ $this, 'update_provider_name' ], 10, 3 );
	}

	/**
	 * Add Wistia as an oEmbed provider.
	 *
	 * @return void
	 */
	public function add_oembed_provider() {

		wp_oembed_add_provider(
			self::EMBED_PATTERN,
			'https://fast.wistia.com/oembed',
			true
		);
	}

	/**
	 * Enqueue the Wistia embed block variation.
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets() {

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

	/**
	 * Filter the REST response to change the provider name.
	 *
	 * @param  \WP_REST_Response|\WP_HTTP_Response|\WP_Error|mixed $response Result to send to the client.
	 * @param  array                                               $handler  Route handler used for the request.
	 * @param  \WP_REST_Request                                    $request  Request used to generate the response.
	 * @return \WP_REST_Response|\WP_HTTP_Response|\WP_Error|mixed
	 */
	public function update_provider_name( $response, $handler, $request ) {

		// Ignore requests that are not for the oEmbed proxy.
		if ( false === strpos( $request->get_route(), '/oembed/1.0/proxy' ) ) {
			return $response;
		}

		$params = $request->get_params();

		// Only update the provider name for Wistia oEmbeds.
		if ( ! isset( $params['url'] ) || ! preg_match( self::EMBED_PATTERN, $params['url'] ) ) {
			return $response;
		}

		if ( is_object( $response ) && isset( $response->provider_name ) ) {
			$response->provider_name = 'Wistia';
		}

		return $response;
	}
}
