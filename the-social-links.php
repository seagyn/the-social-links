<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             0.0.1
 * @package           The_Social_Links
 *
 * @wordpress-plugin
 * Plugin Name:       The Social Links
 * Plugin URI:        http://www.digitalleap.co.za/plugins/the-social-links.zip
 * Description:       List your social links anywhere on your site
 * Version:           0.0.1
 * Author:            Digital Leap
 * Author URI:        http://www.digitalleap.co.za/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       the-social-links
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-the-social-links-activator.php
 */
function activate_the_social_links() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-social-links-activator.php';
	The_Social_Links_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-the-social-links-deactivator.php
 */
function deactivate_the_social_links() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-social-links-deactivator.php';
	The_Social_Links_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_the_social_links' );
register_deactivation_hook( __FILE__, 'deactivate_the_social_links' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-the-social-links.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_the_social_links() {

	$plugin = new The_Social_Links();
	$plugin->run();

}
run_the_social_links();
