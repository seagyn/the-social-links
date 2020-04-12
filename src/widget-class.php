<?php
/**
 * Displays the banner via a widget.
 *
 * @package TheSocialLinks
 */

namespace SeagynDavis\TheSocialLinks\Widget;

/**
 * Creates a banner widget
 */
class Links extends \WP_Widget {
	/**
	 * Set up widget.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'the_social_links',
			__( 'The Social Links', 'the-social-links' ),
			[
				'description' => __( 'Adds your social links to your widgetised area.', 'the-social-links' ),
			]
		);
	}

	/**
	 * Output of widget.
	 *
	 * @param array $args Array of arguments for the widget.
	 * @param array $instance Array of instance specific data.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		\SeagynDavis\TheSocialLinks\enqueue_public_scripts();

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		require 'html/links.php';

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options.
	 * @return void
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
	 * @return array $instance Instance of widget
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}


