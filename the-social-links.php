<?php
/*
	Plugin Name: The Social Links
	Plugin URI: http://www.seagyndavis.com/wordpress/plugin/the-social-links/
	Description: The Social Links plugin add a widget to your WordPress website allowing you to display icons linking your social profiles.
	Version: 0.3.1
	Author: Seagyn Davis
	Author URI: http://www.seagyndavis.com/
	License: GPL2

	Copyright 2011 Seagyn Davis (email : seagyn@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$social_networks = array(
	'aim' => 'AIM',
	'android' => 'Android',
	'appstore' => 'Apple Store',
	'bebo' => 'Bebo',
	'blogger' => 'Blogger',
	'delicious' => 'Delicious',
	'designfloat' => 'DesignFloat',
	'deviantart' => 'DeviantArt',
	'digg' => 'Digg',
	'dribbble' => 'Dribbble',
	'ebay' => 'eBay',
	'evernote' => 'Evernote',
	'facebook' => 'Facebook',
	'feedburner-2' => 'Feedburner',
	'flickr-1' => 'Flickr (blue)',
	'foursquare' => 'foursquare',
	'gmail' => 'Gmail',
	'google' => 'Google Profile',
	'gowalla' => 'Gowalla',
	'grooveshark-1' => 'Grooveshark',
	'gtalk' => 'Gtalk',
	'hi5-1' => 'Hi5',
	'lastfm' => 'LastFM',
	'linkedin' => 'LinkedIn',
	'livejournal' => 'LiveJournal',
	'metacafe' => 'Metacafe',
	'mobileme' => 'MobileMe',
	'msn-1' => 'MSN',
	'myspace' => 'MySpace',
	'ning' => 'Ning',
	'openid-2' => 'OpenID',
	'orkut' => 'orkut',
	'pandora' => 'Pandora',
	'paypal' => 'PayPal',
	'picasa' => 'Picasa',
	'plurk' => 'Plurk',
	'posterous' => 'Posterous',
	'reddit' => 'Reddit',
	'rss' => 'RSS Feed',
	'skype' => 'Skype',
	'stumbleupon' => 'StumbleUpon',
	'tumblr' => 'Tumblr',	
	'twitter' => 'Twitter',
	'vimeo' => 'Vimeo',
	'wordpress' => 'WordPress',
	'xing' => 'XING',
	'yelp' => 'Yelp',
	'youtube' => 'YouTube'
);

$plugin_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__) );

include 'includes/options.php';
include 'includes/widget.php';

register_activation_hook( __FILE__, 'tsl_defaults' );

function tsl_defaults(){
	if( !get_option( 'tsl_icon_size' ) )
		update_option( 'tsl_icon_size', '32x32' );
	if( !get_option( 'tsl_display_credit' ) )
		update_option( 'tsl_display_credit', false );
	if( !get_option( 'tsl_link_target' ) )
		update_option( 'tsl_link_target', '_parent' );
}

function tsl_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/the-social-links.php' ) ) {
		$links[] = '<a href="themes.php?page=the-social-link">'.__('Settings').'</a>';
	}

	return $links;
}

add_filter( 'plugin_action_links', 'tsl_plugin_action_links', 10, 2 );

function tsl_admin_bar_link() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	$wp_admin_bar->add_menu( array(
            'id' => 'tsl_admin_bar',
            'parent' => 'appearance',
            'title' => __( 'The Social Links'),
            'href' => admin_url( 'themes.php?page=the-social-link' )
	) );
}

function tsl_admin_bar_init(){
    add_action('admin_bar_menu', 'tsl_admin_bar_link', 70);
}
add_action('admin_bar_init', 'tsl_admin_bar_init');

?>