<?php
/**
 * Frontend
 *
 * Frontend output of social links
 *
 * @class     TheSocialLinksFrontend
 * @version   1.2
 * @package   TheSocialLinks/Includes/TheSocialLinksFrontend
 * @category  Class
 * @author    Digital Leap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output the social links
 */
function the_social_links() {

	$frontend = new TheSocialLinksFrontend;

	$frontend->display();

}

/**
 * Does frontend display stuff
 *
 * @package   TheSocialLinks/Includes/TheSocialLinksFrontend
 */
class TheSocialLinksFrontend {

	/**
	 * Holds an instance of the class
	 *
	 * @var TheSocialLinksFrontend The single instance of the class.
	 * @since 1.2
	 */
	protected static $_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return  TheSocialLinksFrontend A single instance of this class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * The construct of TheSocialLinksFrontend.
	 */
	public function __construct() {

		add_action( 'widgets_init', array( $this, 'init_widget' ) );

		add_shortcode( 'the-social-links', array( $this, 'shortcode' ) );

	}

	/**
	 * Registers the widget.
	 */
	public static function init_widget() {
		register_widget( 'TheSocialLinksWidget' );
	}

	/**
	 * Used to display the social links when the shortcode is called
	 *
	 * @param array $atts Array of attributes for the shortcode.
	 * @return string Returns the social links output
	 */
	public function shortcode( $atts ) {
		return self::display( false );
	}

	/**
	 * Used to display the social links.
	 *
	 * @param boolean $echo Echo or return the HTML. Defaults to echo.
	 */
	public function display( $echo = true ) {

		$settings = get_option( 'the_social_links_settings' );

		$tsl = new TheSocialLinks;

		$output = '';

		if ( ! empty( $settings['links'] ) ) :

			foreach ( $settings['links'] as $link ) :

				if ( ! isset( $settings['style_pack'] ) || empty( $settings['style_pack'] ) ) :
					$settings['style_pack'] = 'default';
				endif;

				foreach ( $link as $network => $value ) :
					$network = $network;
					$value = $value;
				endforeach;

				$output .= '<a href="' . $value . '" class="the-social-links tsl-' . $settings['style'] . ' tsl-' . $settings['size'] . ' tsl-' . $settings['style_pack'] . ' tsl-' . $network . '" target="' . $settings['target'] . '" alt="' . $tsl->social_networks[ $network ] . '" title="' . $tsl->social_networks[ $network ] . '"><i class="fa fa-' . $network . '"></i></a>&nbsp;';

			endforeach;

		endif;

		if ( $echo ) :
			echo $output;
		else :
			return $output;
		endif;

	}
}

/** Initiates an instance of TheSocialLinksFrontend. */
TheSocialLinksFrontend::instance();
