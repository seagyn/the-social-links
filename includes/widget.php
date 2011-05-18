<?php
class TheSocialLinkWidget extends WP_Widget{
	
	function TheSocialLinkWidget() {
		$widget_ops = array( 
			'classname' => 'the-social-link',
			'description' => 'Display your social links in your sidebar.'
		);
		
		parent::WP_Widget('the-social-link-widget', 'The Social Links', $widget_ops);
	}

	function form($instance) {
		$title = esc_attr($instance['title']);
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
	}

	function widget($args, $instance) {
		global $social_networks;
		global $plugin_path;
		$icon_size = get_option( 'tsl_icon_size' );
		extract( $args );
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        ?>
			<?php echo $before_widget; ?>
				<?php if ( $title )
					echo $before_title . $title . $after_title; ?>
                     
				<?php foreach($social_networks as $slug => $name):?>
					<?php $tsl_link = get_option('tsl_'.$slug);?>
					<?php if ( !empty( $tsl_link ) ):?>
						<a href="<?php echo $tsl_link;?>" rel="nofollow"><img src="<?php echo $plugin_path;?>/icons/<?php echo $icon_size.'/'.$slug;?>.png" title="<?php echo $name;?>" alt="<?php echo $name;?>" /></a>
					<?php endif;?>
				<?php endforeach;?>
				<?php if(get_option('tsl_display_credit')):?>
					<br /><a style="font-size: 0.8em;" href="http://www.seagyndavis.com/wordpress/plugin/the-social-links/">Provide by The Social Links</a>
				<?php endif;?>
			<?php echo $after_widget; ?>
        <?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("TheSocialLinkWidget");'));
?>