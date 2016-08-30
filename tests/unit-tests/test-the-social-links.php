<?php
class TheSocialLinksTests extends WP_UnitTestCase {

	function test_default_social_networks() {
		$the_social_links = new TheSocialLinks();
		$default_networks = array(
			'facebook' => 'Facebook',
			'google-plus' => 'Google+',
			'instagram' => 'Instagram',
			'linkedin' => 'LinkedIn',
			'pinterest' => 'Pinterest',
			'rss' => 'RSS Feed',
			'twitter' => 'Twitter',
			'vimeo-square' => 'Vimeo',
			'youtube' => 'YouTube',
		);

		$this->assertEquals( $default_networks, $the_social_links->social_networks );
	}

	function test_settings_update() {
		
		$default_settings = array(
			'style' => 'rounded',
			'size' => 32,
			'target' => '_blank',
			'networks' => array(),
			'links' => array(),
		);

		update_option( 'the_social_links_settings', $default_settings );

		$settings = get_option( 'the_social_links_settings' );

		$this->assertEquals( $default_settings, $settings );
	}
}
