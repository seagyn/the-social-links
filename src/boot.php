<?php
/**
 * Initialises the plugin requirements.
 *
 * @package TheSocialLinks
 */

namespace SeagynDavis\TheSocialLinks;

/**
 * Initialises the app.
 */
function boot() {
	/**
	 * Frontend stuff
	 */
	add_shortcode( 'the-social-links', 'SeagynDavis\TheSocialLinks\Shortcode\shortcode' );
	add_action(
		'widgets_init',
		function() {
			register_widget( 'SeagynDavis\TheSocialLinks\Widget\Links' );
		}
	);

	/**
	 * Admin related hooks
	 */
	add_action(
		'admin_menu',
		function() {
			\add_menu_page(
				'The Social Links',
				'The Social Links',
				'manage_options',
				'the-social-links',
				'SeagynDavis\TheSocialLinks\Admin\settings_page',
				'dashicons-share'
			);
		}
	);
	add_action(
		'admin_init',
		function() {
			register_setting( 'the_social_links_settings', 'the_social_links_settings', 'sanitize' );
		}
	);
	add_filter( 'plugin_action_links', 'SeagynDavis\TheSocialLinks\Admin\action_links', 10, 2 );

	add_action( 'admin_enqueue_scripts', 'SeagynDavis\TheSocialLinks\enqueue_admin_scripts' );
}

/**
 * Enqueue scripts needed for the admin page.
 */
function enqueue_admin_scripts() {
	wp_enqueue_script( 'jquery-ui-sortable', null, [ 'jquery' ], THE_SOCIAL_LINKS_VERSION, true );
	wp_enqueue_style( 'font-awesome', THE_SOCIAL_LINKS_URL . 'assets/css/fontawesome.min.css', [], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'font-awesome-brands', THE_SOCIAL_LINKS_URL . 'assets/css/brands.min.css', [ 'font-awesome' ], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'font-awesome-solid', THE_SOCIAL_LINKS_URL . 'assets/css/solid.min.css', [ 'font-awesome' ], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'the-social-links', THE_SOCIAL_LINKS_URL . 'assets/css/style.css', [], THE_SOCIAL_LINKS_VERSION );
}

/**
 * Enqueue scripts needed for the admin page.
 */
function enqueue_public_scripts() {
	wp_enqueue_style( 'font-awesome', THE_SOCIAL_LINKS_URL . 'assets/css/fontawesome.min.css', [], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'font-awesome-brands', THE_SOCIAL_LINKS_URL . 'assets/css/brands.min.css', [ 'font-awesome' ], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'font-awesome-solid', THE_SOCIAL_LINKS_URL . 'assets/css/solid.min.css', [ 'font-awesome' ], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'the-social-links', THE_SOCIAL_LINKS_URL . 'assets/css/style.css', [], THE_SOCIAL_LINKS_VERSION );
}

/**
 * A list of social networks we support.
 */
function get_social_networks() {
	$social_networks = apply_filters(
		'add_tsl_social_networks',
		[
			'facebook'     => 'Facebook',
			'google-plus'  => 'Google+',
			'instagram'    => 'Instagram',
			'linkedin'     => 'LinkedIn',
			'pinterest'    => 'Pinterest',
			'rss'          => 'RSS Feed',
			'twitter'      => 'Twitter',
			'vimeo-square' => 'Vimeo',
			'youtube'      => 'YouTube',
			'behance'      => 'Behance',
			'bitcoin'      => 'Bitcoin',
			'delicious'    => 'Delicious',
			'deviantart'   => 'DeviantArt',
			'digg'         => 'Digg',
			'dribbble'     => 'Dribbble',
			'flickr'       => 'Flickr',
			'foursquare'   => 'Foursquare',
			'github'       => 'GitHub',
			'lastfm'       => 'LastFM',
			'medium'       => 'Medium',
			'skype'        => 'Skype',
			'soundcloud'   => 'Soundcloud',
			'spotify'      => 'Spotify',
			'tumblr'       => 'Tumblr',
			'vine'         => 'Vine',
			'wordpress'    => 'WordPress',
		]
	);

	asort( $social_networks );

	return $social_networks;
}

/**
 * Runs when the plugin is activated and sets defaults.
 *
 * @return void
 */
function activate() {
	if ( ! get_option( 'the_social_links_settings' ) ) :
		update_option(
			'the_social_links_settings',
			array(
				'style'    => 'default',
				'style'    => 'square',
				'size'     => 32,
				'target'   => '_blank',
				'networks' => array(),
				'links'    => array(),
			)
		);
	endif;

	update_option( 'the_social_links_version', THE_SOCIAL_LINKS_VERSION );
}
