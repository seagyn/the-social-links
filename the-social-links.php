<?php
/*
	Plugin Name: The Social Links
	Plugin URI: http://www.seagyndavis.com/wordpress/plugin/the-social-links/
	Description: The Social Links plugin add a widget to your WordPress website allowing you to display icons linking your social profiles.
	Version: 0.2.1
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
	'facebook' => 'Facebook',
	'twitter' => 'Twitter',
	'youtube' => 'YouTube',
	'linkedin' => 'LinkedIn',
	'delicious' => 'Delicious',
	'lastfm' => 'LastFM',
	'myspace' => 'MySpace',
	'vimeo' => 'Vimeo',
	'stumbleupon' => 'StumbleUpon',
	'orkut' => 'orkut',
	'googlebuzz' => 'Google Buzz',
	'friendfeed' => 'FriendFeed',
	'dribbble' => 'Dribbble'
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
}

function tsl_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/the-social-links.php' ) ) {
		$links[] = '<a href="themes.php?page=the-social-link">'.__('Settings').'</a>';
	}

	return $links;
}

add_filter( 'plugin_action_links', 'tsl_plugin_action_links', 10, 2 );
?>