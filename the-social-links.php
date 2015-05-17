<?php
/*
	Plugin Name: The Social Links
	Plugin URI: http://digitalleap.co.za/wordpress/plugin/the-social-links/
	Description: The Social Links plugin adds a widget and shortcode to your WordPress website allowing you to display icons linking to your social profiles.
	Version: 0.9
	Author: Digital Leap
	Author URI: http://digitalleap.co.za/
	License: GPL2

	Copyright 2015 Digital Leap (email : info@digitalleap.co.za)

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

include_once 'includes/frontend.php';

register_activation_hook( __FILE__, array( 'The_Social_Links', 'activate' ) );

function the_social_links_update_db_check() {

    $the_social_links_version = The_Social_Links::$the_social_links_version;

	$installed_version = get_site_option( 'the_social_links_version' );
    if ( !$installed_version  ) :
        The_Social_Links::legacy_update();
	elseif($installed_version != $the_social_links_version ):
        // The_Social_Links::update(); // Not required yet
    endif;

}
add_action( 'plugins_loaded', 'the_social_links_update_db_check' );

class The_Social_Links{

	public static $social_networks = array(
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

	public static $the_social_links_version = 0.9;

	public static function init(){

		// do stuff here

		add_action('admin_menu', __CLASS__ . '::admin_menu');

		add_action( 'admin_init', __CLASS__ . '::register_settings' );

		add_action( 'admin_init', __CLASS__ . '::enqueue_scripts' );
		add_action( 'init', __CLASS__ . '::enqueue_scripts' );

		add_filter( 'plugin_action_links', __CLASS__ . '::action_links', 10, 2 );

	}

	public static function activate(){

		$the_social_links_version = self::$the_social_links_version;

		if( !get_option( 'the_social_links_settings' ) )
			update_option('the_social_links_settings',array(
				'style' => 'square',
				'size' => 32,
				'target' => '_blank',
				'networks' => array(),
				'links' => array(),
			));

	}

	public static function legacy_update(){

		$the_social_links_version = self::$the_social_links_version;

		$settings = get_option('the_social_links_settings');

		if(!$settings)
			$settings = array(
				'style' => 'square',
				'size' => 32,
				'target' => '_blank',
				'networks' => array(),
				'links' => array(),
			);

		foreach(self::$social_networks as $social_network => $network_name):

			$old_network = get_option('tsl_'.$social_network);

			if( $old_network && !empty($old_network) ):

				$settings['networks'][] = $social_network;
				$settings['links'][] = array($social_network => $old_network);

			endif;

		endforeach;

		$size = get_option( 'tsl_icon_size' );

		if($size == '16x16' || $size == '24x24')
			$settings['size'] = '24';
		elseif($size == '32x32')
			$settings['size'] = '32';
		elseif($size == '48x48' || $size == '64x64')
			$settings['size'] = '48';

		$target = get_option( 'tsl_link_target' );

		if($target == '_parent')
			$settings['target'] = '_top';
		else
			$settings['target'] = '_blank';

		update_option( 'the_social_links_settings', $settings);
		update_option( 'the_social_links_version', $the_social_links_version );

	}

	public static function enqueue_scripts(){

		wp_enqueue_script( 'jquery-ui-sortable', null, array('jquery') );

		wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'the-social-links-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );

	}

	public static function admin_menu(){

		add_menu_page('The Social Links', 'The Social Links', 'administrator', 'the-social-links', __CLASS__ . '::settings_page', 'dashicons-share');

	}

	public static function settings_page() {

		?>

		<div class="wrap">
		<h2><?php _e( 'The Social Links', 'the-social-links-plugin' ) ?></h2>

		<?php $settings = get_option('the_social_links_settings');?>

		<h3>General</h3>

		<form method="post" action="options.php">
		<?php settings_fields( 'the_social_links_settings' ); ?>
		<?php do_settings_sections( 'the_social_links_settings' ); ?>
		<table class="form-table">
		<tr valign="top">
		<td scope="row" style="width:250px;"><strong>Style</strong><br />Select the style of the icons.</td>
		<td>
			<select name="the_social_links_settings[style]">
				<option value="square" <?php selected('square', $settings['style'] )?>>Square</option>
				<option value="rounded" <?php selected('rounded', $settings['style'] )?>>Rounded</option>
				<option value="circle" <?php selected('circle', $settings['style'] )?>>Circle</option>
			</select>
		</td>
		</tr>
		<tr valign="top">
		<td scope="row"><strong>Size</strong><br />Select the size of the icons</td>
		<td>
			<select name="the_social_links_settings[size]">
				<option value="24" <?php selected('24', $settings['size'] )?>>24px x 24px</option>
				<option value="32" <?php selected('32', $settings['size'] )?>>32px x 32px</option>
				<option value="48" <?php selected('48', $settings['size'] )?>>48px x 48px</option>
			</select>
		</td>
		</tr>
		<tr valign="top">
		<td scope="row"><strong>Link Target</strong><br />Open links in a new window or the current window. New recommended.</td>
		<td>
			<select name="the_social_links_settings[target]">
				<option value="_blank" <?php selected('_blank', $settings['target'] )?>>New Window</option>
				<option value="_top" <?php selected('_top', $settings['target'] )?>>Current Window</option>
			</select>
		</td>
		</tr>
		</table>
		<?php submit_button(); ?>

		<h3>Networks</h3>

		<table class="form-table">
		<tr valign="top">
		<td scope="row" style="width:250px;"><strong>Networks</strong><br />Selects the networks that you would like to display</td>
		<td>
			<?php
				$networks = $settings['networks'];
				if(!$networks)
					$networks = array();
			?>
			<?php foreach(self::$social_networks as $key => $social_network):?>
				<label><input type="checkbox" name="the_social_links_settings[networks][]" value="<?php echo $key;?>" <?php checked( in_array( $key, $networks ) , true);?> /> <?php echo $social_network;?></label><br>
			<?php endforeach;?>
		</td>
		</tr>
		<tr valign="top">
		<td scope="row"><strong>Links and Order</strong><br />Enter your network (incl. http:// or https://) and drag the networks in the order you would like.</td>
		<td>
			<?php if($networks && !empty($networks)):?>

				<?php

					$current_links = $settings['links'];
					if(!$current_links)
						$current_links = array();

					$links = array();

					if(!empty($current_links)):

						foreach($current_links as $current_link):

							foreach($networks as $key => $network):

								if( isset( $current_link[$network] ) ):
									$links[] = $current_link;
									unset($networks[$key]);
								endif;

							endforeach;

						endforeach;

					endif;

					foreach($networks as $network):

						$links[] = array($network => '');

					endforeach;

				?>

				<ul class="sortable tsl-links">

				<?php foreach($links as $link):?>

					<?php
					foreach($link as $network => $value):
						$network = $network;
						$value = $value;
					endforeach;
					?>

					<li class="tsl-item">
						<i class="fa fa-arrows-v"></i>&nbsp;
						<a class="the-social-links tsl-<?php echo $style;?> tsl-<?php echo $size ;?> tsl-default tsl-<?php echo $network;?>" target="<?php echo $target ;?>" alt="<?php echo self::$social_networks[$network];?>" title="<?php echo self::$social_networks[$network];?>"><i class="fa fa-<?php echo $network;?>"></i></a>
						<input type="text" name="the_social_links_settings[links][][<?php echo $network;?>]" value="<?php echo $value;?>" />
					</li>

				<?php endforeach;?>

				</ul>

			<?php else:?>
				Please select networks before adding links and sorting them.
			<?php endif;?>
		</td>
		</tr>
		</table>
		<?php submit_button(); ?>

		</form>
		</div>

		<script>
		jQuery(document).ready(function($){
			$('.sortable').sortable();
		});
		</script>

		<?php

	}

	public static function register_settings() {

		register_setting( 'the_social_links_settings', 'style' );
		register_setting( 'the_social_links_settings', 'size' );
		register_setting( 'the_social_links_settings', 'target' );
		register_setting( 'the_social_links_settings', 'networks' );
		register_setting( 'the_social_links_settings', 'links' );

	}

	public static function action_links( $links, $file ) {
		if ( $file == plugin_basename( dirname(__FILE__).'/the-social-links.php' ) ) {
			$links[] = '<a href="' . admin_url('admin.php?page=the-social-links') . '">'.__('Settings').'</a>';
		}

		return $links;
	}

}
The_Social_Links::init();

?>
