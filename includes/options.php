<?php 

add_action('admin_menu', 'the_social_link_options');

function the_social_link_options(){
	if( function_exists( 'add_theme_page' ) ):
		add_theme_page( 'The Social Link Options', 'The Social Link Options', 'manage_options', 'the-social-link', 'the_social_link_html');
	endif;
}

function the_social_link_html(){
	global $social_networks;
		//must check that the user has the required capability 
    if ( !current_user_can('manage_options') ):
		wp_die( __('You do not have sufficient permissions to access this page.') );
    endif;

	// variables for the field and option names 
	$tsl_hidden = 'tsl_hidden';
	$tsl_icon_size = get_option( 'tsl_icon_size' );
	
	$values = array();
    // Read in existing option value from database
    foreach($social_networks as $slug => $name):
    	$values[ $slug ] = get_option( 'tsl_' . $slug );
	endforeach;

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $tsl_hidden ]) && $_POST[ $tsl_hidden ] == 'Y' ):
    	// Get value from posted data and save data
	    foreach($social_networks as $slug => $name):
	    	$values[$slug] = $_POST[ 'tsl_' . $slug ];
        	update_option( 'tsl_' . $slug, $values[ $slug ] );
		endforeach;
		
	$tsl_icon_size = $_POST[ 'tsl_icon_size' ];
	update_option( 'tsl_icon_size' , $tsl_icon_size );

        // Put an settings updated message on the screen
	?>
		<div class="updated"><p><strong><?php _e('Settings saved.', 'menu-test' ); ?></strong></p></div>
	
	<?php endif; ?>
    
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2><?php _e( 'The Social Link Options', 'the-social-link' );?></h2>
		
		<form name="form1" method="post" action="">
		<input type="hidden" name="<?php echo $tsl_hidden; ?>" value="Y">
		
		<h3>Icon Options</h3>
		
		<p><?php _e('Icon Size', 'menu-test' ); ?> 
			<select name="tsl_icon_size">
				<option value="16x16" <?php if($tsl_icon_size == "16x16") echo 'selected="selected"'?>>16x16</option>
				<option value="24x24" <?php if($tsl_icon_size == "24x24") echo 'selected="selected"'?>>24x24</option>
				<option value="32x32" <?php if($tsl_icon_size == "32x32") echo 'selected="selected"'?>>32x32</option>
				<option value="48x48" <?php if($tsl_icon_size == "48x48") echo 'selected="selected"'?>>48x48</option>
				<option value="64x64" <?php if($tsl_icon_size == "64x64") echo 'selected="selected"'?>>64x64</option>		
			</select>
		</p>
		
		<h3>Social Networks</h3>
		
		<p><?php _e( 'Please enter the full URL to your social profile on the respective network. I am in the process of updating the plugin to allow you to add usernames only.', 'the-social-link' );?></p>

		
		<?php foreach($social_networks as $slug => $name):?>
			<p><?php _e($name, 'menu-test' ); ?> 
			<input type="text" name="tsl_<?php echo $slug?>" value="<?php echo $values[$slug]; ?>" size="20">
			</p>
		<?php endforeach;?>
	
		<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
		</p>
	
		</form>
	</div>
	<?php
}
?>