<?php

/**
 * Output the social links.
 */
function the_social_links() {

	$frontend = new TheSocialLinksFrontend;

	$frontend->display();

}