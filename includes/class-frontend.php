<?php

function the_social_links(){

    $frontend = new The_Social_Links_Frontend;

    $frontend->display();

}

class The_Social_Links_Frontend{

    public function __construct(){

        add_action( 'widgets_init', array( $this, 'init_widget') );


        add_shortcode( 'the-social-links', array( $this, 'shortcode') );

    }

    public static function init_widget(){
         register_widget( 'The_Social_Links_Widget' );
    }

    public static function shortcode( $atts ){
        return self::display( false );
    }

    public static function display( $echo = true ){

        $settings = get_option('the_social_links_settings');

        $tsl = new The_Social_Links;

        $output = '';

        if( !empty( $settings['links'] ) ):

            foreach($settings['links'] as $link):

            	if( !isset( $settings['style_pack'] ) || empty( $settings['style_pack'] ) ) $settings['style_pack'] = 'default';

                foreach($link as $network => $value):
                    $network = $network;
                    $value = $value;
                endforeach;

                $output .= '<a href="' .  $value . '" class="the-social-links tsl-' .   $settings['style'] . ' tsl-' .  $settings['size'] . ' tsl-' . $settings['style_pack'] . ' tsl-' . $network . '" target="' . $settings['target'] .'" alt="' . $tsl->social_networks[$network] . '" title="' . $tsl->social_networks[$network] . '"><i class="fa fa-' . $network . '"></i></a>&nbsp;';

            endforeach;

        endif;

        if($echo)
            echo $output;
        else
            return $output;


    }

}

/**
 * Extension main function
 */
function __tsl_frontend_main() {
    new The_Social_Links_Frontend();
}

// Initialize plugin when plugins are loaded
add_action( 'plugins_loaded', '__tsl_frontend_main' );

class The_Social_Links_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'the_social_links', // Base ID
			__( 'The Social Links', 'the-social-links' ), // Name
			array( 'description' => __( 'Adds your social links to your widgetised area.', 'the-social-links' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$frontend = new The_Social_Links_Frontend;

		$frontend->display();

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '   ';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
