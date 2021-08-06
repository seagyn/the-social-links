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
	add_action( 'wp_enqueue_scripts', 'SeagynDavis\TheSocialLinks\enqueue_styles' );

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

	add_action( 'admin_enqueue_scripts', 'SeagynDavis\TheSocialLinks\enqueue_scripts' );
	add_action( 'admin_enqueue_scripts', 'SeagynDavis\TheSocialLinks\enqueue_styles' );
}

/**
 * Enqueue front end and admin styles.
 */
function enqueue_styles() {
	wp_enqueue_style( 'tsl-font-awesome', THE_SOCIAL_LINKS_URL . 'assets/css/fontawesome.min.css', [], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'tsl-font-awesome-brands', THE_SOCIAL_LINKS_URL . 'assets/css/brands.min.css', [ 'tsl-font-awesome' ], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'tsl-font-awesome-solid', THE_SOCIAL_LINKS_URL . 'assets/css/solid.min.css', [ 'tsl-font-awesome' ], THE_SOCIAL_LINKS_VERSION );
	wp_enqueue_style( 'the-social-links', THE_SOCIAL_LINKS_URL . 'assets/css/style.css', [], THE_SOCIAL_LINKS_VERSION );
}

/**
 * Enqueue admin scripts.
 */
function enqueue_scripts() {
  if ( is_settings_page() ) {
    wp_enqueue_script( 'the-social-links', THE_SOCIAL_LINKS_URL . 'assets/js/admin.js', [ 'jquery-ui-sortable' ], THE_SOCIAL_LINKS_VERSION, true );
  }
}

/**
 * Checks if the settings page is the current page.
 *
 * @return bool
 */
function is_settings_page() {
  $current_screen   = get_current_screen();
  $is_settings_page = false;

  if ( null !== $current_screen ) {
    if ( 'toplevel_page_the-social-links' === $current_screen->id ) {
      $is_settings_page = true;
    }
  }

  return $is_settings_page;
}

/**
 * A list of social networks we support.
 */
function get_social_networks() {
	$social_networks = apply_filters(
		'add_tsl_social_networks',
		[
			'telegram'     => 'Telegram',
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
