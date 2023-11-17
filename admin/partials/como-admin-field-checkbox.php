<?php

/**
 * Provides the markup for any checkbox field
 *
 * @link       https://comocreative.com
 * @since      1.0.0
 *
 * @package    Como_Consult
 * @subpackage Como_Consult/admin/partials
 */

?><label for="<?php echo esc_attr( $atts['id'] ); ?>">
	<input aria-role="checkbox"
		<?php checked( 1, $atts['value'], true ); ?>
		class="<?php echo esc_attr( $atts['class'] ); ?>"
		id="<?php echo esc_attr( $atts['id'] ); ?>"
		name="<?php echo esc_attr( $atts['name'] ); ?>"
		type="checkbox"
		value="1" />
	<span class="description"><?php esc_html_e( $atts['description'], 'como-consult' ); ?></span>
</label>