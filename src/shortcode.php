<?php
/**
 * Displays the links via a shortcode.
 *
 * @package TheSocialLinks
 */

namespace SeagynDavis\TheSocialLinks\Shortcode;

/**
 * Register a shortcode to display the banner.
 *
 * @return string HTML to output.
 */
function shortcode() {
	\SeagynDavis\TheSocialLinks\enqueue_public_scripts();

	ob_start();

	include_once 'html/links.php';

	return ob_get_clean();
}
