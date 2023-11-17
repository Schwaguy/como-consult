<?php

/**
 * Provides the markup for any textarea field
 *
 * @link       https://comocreative.com
 * @since      1.0.0
 *
 * @package    Como_Consult
 * @subpackage Como_Consult/admin/partials
 */

?><span class="como-field-wrap"><?php

if ( ! empty( $atts['label'] ) ) {
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>" class="comometa-row-title"><?php esc_html_e( $atts['label'], 'como-consult' ); ?>: </label><?php
}
?><span class="comometa-row-content"><?php
?><textarea
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	cols="<?php echo esc_attr( $atts['cols'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	rows="<?php echo esc_attr( $atts['rows'] ); ?>"><?php

	echo esc_textarea( $atts['value'] );

?></textarea><?php
if ( ! empty( $atts['description'] ) ) {
	?><span class="description"><?php esc_html_e( $atts['description'], 'como-consult' ); ?></span><?php
}
	?>
</span></span>