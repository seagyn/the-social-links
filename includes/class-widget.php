<?php
/**
 * Widget
 *
 * Widget for The Social Links
 *
 * @package   TheSocialLinks/Includes/TheSocialLinksWidget
 * @category  Class
 * @author    Digital Leap
 */

/**
 * Widget
 *
 * Widget for The Social Links
 *
 * @class     TheSocialLinksWidget
 * @version   1.2
 */
class TheSocialLinksWidget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'the_social_links', // Base ID!
			__( 'The Social Links', 'the-social-links' ), // Name!
			array(
				'description' => __( 'Adds your social links to your widgetised area.', 'the-social-links' ),
			) // Args!
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args Arguments for the widget.
	 * @param array $instance The instance of the widget.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$frontend = new TheSocialLinksFrontend;

		$frontend->display();

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '   ';
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
