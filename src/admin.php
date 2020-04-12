<?php
/**
 * Handles the plugin admin interface.
 *
 * @package TheSocialLinks
 */

namespace SeagynDavis\TheSocialLinks\Admin;

/**
 * Display the admin page.
 *
 * @return void
 */
function settings_page() {
	include_once 'html/admin.php';
}

/**
 * Sanitize the input from the user.
 *
 * @param string $input String inputted by the user.
 * @return string Returns a string that has been sanitized.
 */
function sanitize( $input ) {
	if ( ! empty( $input['links'] ) ) :
		var_dump($input['links']);exit;
		foreach ( $input['links'] as $key => $link ) :

			foreach ( $link as $network => $value ) :
				$input['links'][ $key ] = [ $network => esc_url_raw( $value, [ 'http', 'https' ] ) ];
			endforeach;

		endforeach;
	endif;

	return $input;
}

/**
 * Add settings and website links to The Social Links on the WordPress plugin page.
 *
 * @param array  $links An array of current links.
 * @param string $file  The filename and path of the plugin to apply action links to.
 * @return array Returns an array of links to display.
 */
function action_links( array $links, $file ) {
	if ( plugin_basename( THE_SOCIAL_LINKS_DIR . '/the-social-links.php' ) === $file ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=the-social-links' ) . '">' . __( 'Settings', 'the-social-links' ) . '</a>';
		$links[] = '<a href="https://github.com/seagyn/the-social-links">' . __( 'Plugin Website', 'the-social-links' ) . '</a>';
	}

	return $links;
}
