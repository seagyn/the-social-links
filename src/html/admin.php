<?php
/**
 * Admin HTML.
 *
 * @package TheSocialLinks
 */

use function SeagynDavis\TheSocialLinks\get_social_networks;

$settings        = get_option( 'the_social_links_settings' );
$social_networks = get_social_networks();

?>
<div class="wrap admin">

	<h2><?php esc_html_e( 'The Social Links', 'the-social-links' ); ?></h2>

	<h3><?php esc_html_e( 'Social Networks and Options', 'the-social-links' ); ?></h3>

	<form method="post" action="options.php">

		<?php settings_fields( 'the_social_links_settings' ); ?>
		<?php do_settings_sections( 'the_social_links_settings' ); ?>

		<table class="form-table">
			<tr valign="top">
				<td style="width:270px;">
					<strong>
						<?php esc_html_e( 'Networks', 'the-social-links' ); ?>
					</strong>
					<br/>
					<?php esc_html_e( 'Select the social networks that you would like to display', 'the-social-links' ); ?>
				</td>
				<td class="social-networks">
					<?php
					$networks = array();
					if ( isset( $settings['networks'] ) ) :
						$networks = $settings['networks'];
					endif;
					?>
					<?php foreach ( $social_networks as $key => $social_network ) : ?>
						<label>
							<input type="checkbox" name="the_social_links_settings[networks][]"
								value="<?php echo esc_attr( $key ); ?>"
								<?php checked( in_array( $key, $networks, true ), true ); ?>
							/> <?php echo esc_html( $social_network ); ?>
						</label>
					<?php endforeach; ?>
				</td>
			</tr>
		</table>

		<?php
		$styles = apply_filters(
			'add_tsl_styles',
			array(
				'square'  => __( 'Square', 'the-social-links' ),
				'rounded' => __( 'Rounded', 'the-social-links' ),
				'circle'  => __( 'Circle', 'the-social-links' ),
			)
		);
		?>

		<table class="form-table">
			<tr valign="top">
				<td style="width:270px;">
					<strong><?php esc_html_e( 'Style', 'the-social-links' ); ?></strong>
					<br/><?php esc_html_e( 'Select the style of the icons.', 'the-social-links' ); ?>
				</td>
				<td>
					<select name="the_social_links_settings[style]">
						<?php foreach ( $styles as $key => $style ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>"
								<?php selected( $key, $settings['style'] ); ?>
							>
								<?php echo esc_html( $style ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td>
					<strong><?php esc_html_e( 'Size', 'the-social-links' ); ?></strong>
					<br/>
					<?php esc_html_e( 'Select the size of the icons', 'the-social-links' ); ?>
				</td>
				<td>
					<select name="the_social_links_settings[size]">
						<option value="24" <?php selected( '24', $settings['size'] ); ?>>24px x 24px</option>
						<option value="32" <?php selected( '32', $settings['size'] ); ?>>32px x 32px</option>
						<option value="48" <?php selected( '48', $settings['size'] ); ?>>48px x 48px</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td>
					<strong><?php esc_html_e( 'Link Target', 'the-social-links' ); ?></strong>
					<br/>
					<?php
					__(
						'Open links in a new window or the current window. A new window is recommended.',
						'the-social-links'
					);
					?>
				</td>
				<td>
					<select name="the_social_links_settings[target]">
						<option value="_blank"
							<?php selected( '_blank', $settings['target'] ); ?>
						><?php esc_html_e( 'New Window', 'the-social-links' ); ?></option>
						<option value="_top"
							<?php selected( '_top', $settings['target'] ); ?>
						><?php esc_html_e( 'Current Window', 'the-social-links' ); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>

		<h3><?php esc_html_e( 'Order and Links', 'the-social-links' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<td style="width:270px;">
					<strong><?php esc_html_e( 'Links and Order', 'the-social-links' ); ?></strong>
					<br/>
					<?php
					__(
						'Enter your network (including http:// or https://) and drag the networks into the order you would like.',
						'the-social-links'
					);
					?>
				</td>
				<td>
					<?php if ( $networks && ! empty( $networks ) ) : ?>
						<?php
						$current_links = array();
						if ( isset( $settings['links'] ) ) :
							$current_links = $settings['links'];
						endif;

						$links = array();

						if ( ! empty( $current_links ) ) :

							foreach ( $current_links as $current_link ) :

								foreach ( $networks as $key => $network ) :

									if ( isset( $current_link[ $network ] ) ) :
										$links[] = $current_link;
										unset( $networks[ $key ] );
									endif;

								endforeach;

							endforeach;

						endif;

						foreach ( $networks as $network ) :

							$links[] = array( $network => '' );

						endforeach;

						?>

						<ul class="sortable tsl-links">

							<?php foreach ( $links as $social_link ) : ?>

								<?php foreach ( $social_link as $network => $value ) : ?>
									<li class="tsl-item">
										<i class="fas fa-arrows-alt-v"></i>&nbsp;
										<a class="the-social-links tsl-<?php echo esc_attr( $settings['style'] ); ?> tsl-<?php echo esc_attr( $settings['size'] ); ?> tsl-default tsl-<?php echo esc_attr( $network ); ?>"
											target="<?php echo esc_attr( $settings['target'] ); ?>"
											alt="<?php echo esc_attr( $social_networks[ $network ] ); ?>"
											title="<?php echo esc_attr( $social_networks[ $network ] ); ?>">
											<?php if ( 'rss' === $network ) : ?>
												<i class="fas fa-<?php echo esc_attr( $network ); ?>"></i>
											<?php else : ?>
												<i class="fab fa-<?php echo esc_attr( $network ); ?>"></i>
											<?php endif; ?>
										</a>
										<input placeholder="<?php echo esc_attr( $social_networks[ $network ] ); ?> <?php esc_html_e( 'URL', 'the-social-links' ); ?>"
											type="text"
											name="the_social_links_settings[links][][<?php echo esc_attr( $network ); ?>]"
											value="<?php echo esc_attr( $value ); ?>"/>
									</li>
								<?php endforeach; ?>

							<?php endforeach; ?>

						</ul>

					<?php else : ?>
						<?php
						esc_html_e(
							'Please select social networks before adding links and sorting them.',
							'the-social-links'
						);
						?>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>

	</form>
</div>

<script>
	jQuery(document).ready(function ($) {
		$('.sortable').sortable();
	});
</script>
