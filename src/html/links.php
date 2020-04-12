<?php
/**
 * Links HTML
 *
 * @package TheSocialLinks
 */

$settings       = get_option( 'the_social_links_settings' );
$social_network = \SeagynDavis\TheSocialLinks\get_social_networks();
?>

<?php if ( ! empty( $settings['links'] ) ) : ?>

	<?php foreach ( $settings['links'] as $social_link ) : ?>
		<?php
		if ( ! isset( $settings['style_pack'] ) || empty( $settings['style_pack'] ) ) :
			$settings['style_pack'] = 'default';
		endif;
		?>

		<?php foreach ( $social_link as $network => $value ) : ?>
			<a
				href="<?php echo esc_attr( $value ); ?>"
				class="the-social-links tsl-<?php echo esc_attr( $settings['style'] ); ?> tsl-<?php echo esc_attr( $settings['size'] ); ?> tsl-<?php echo esc_attr( $settings['style_pack'] ); ?> tsl-<?php echo esc_attr( $network ); ?>"
				target="<?php echo esc_attr( $settings['target'] ); ?>"
				alt="<?php echo esc_attr( $social_network[ $network ] ); ?>"
				title="<?php echo esc_attr( $social_network[ $network ] ); ?>"
			>
				<?php if ( 'rss' === $network ) : ?>
					<i class="fas fa-<?php echo esc_attr( $network ); ?>"></i>
				<?php else : ?>
					<i class="fab fa-<?php echo esc_attr( $network ); ?>"></i>
				<?php endif; ?>
			</a>
		<?php endforeach; ?>

	<?php endforeach; ?>

<?php endif; ?>