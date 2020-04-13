<?php
/**
 * The Social Links plugin adds a widget and shortcode to your WordPress website allowing you to display icons linking to your social profiles.
 *
 * @package   TheSocialLinks
 * @author    Seagyn Davis
 * @copyright 2020 Seagyn Davis
 * @license   GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: The Social Links
 * Plugin URI: https://github.com/seagyn/the-social-links
 * Description: The Social Links plugin adds a widget and shortcode to your WordPress website allowing you to display icons linking to your social profiles.
 * Version: 2.0.2
 * Requires at least: 4.2
 * Requires PHP: 5.6
 * Author: Seagyn Davis
 * Author URI: https://www.seagyndavis.com
 * License: GPL2
 * Text Domain: the-social-links
 *
 * Copyright 2020 Seagyn Davis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License,
 * version 2, as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace SeagynDavis\TheSocialLinks;

define( 'THE_SOCIAL_LINKS_VERSION', '2.0.2' );
define( 'THE_SOCIAL_LINKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'THE_SOCIAL_LINKS_URL', plugin_dir_url( __FILE__ ) );

require_once 'src/boot.php';
require_once 'src/admin.php';
require_once 'src/shortcode.php';
require_once 'src/template-tags.php';
require_once 'src/widget-class.php';

/**
 * Initialise the plugin.
 */
function init() {
	boot();
}
add_action( 'plugins_loaded', 'SeagynDavis\TheSocialLinks\init' );

/**
 * Activation of plugin.
 */
register_activation_hook( __FILE__, 'SeagynDavis\TheSocialLinks\activate' );
