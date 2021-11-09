<?php
/**
 * Template tag functions.
 *
 * @package TheSocialLinks
 */

/**
 * Displays the links with a template tag.
 */
function the_social_links() {
	\SeagynDavis\TheSocialLinks\enqueue_public_scripts();

	include_once 'html/links.php';
}
