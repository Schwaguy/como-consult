<?php

/**
 * Provides the markup for a radio field
 *
 * @link       https://comocreative.com
 * @since      1.0.0
 *
 * @package    Como_Consult
 * @subpackage Como_Consult/admin/partials
 */

?><span class="como-field-wrap"><?php
if ( ! empty( $atts['label'] ) ) {
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>" class="comometa-row-title"><?php esc_html_e( $atts['label'], 'employees' ); ?>: </label><?php
}

?><span class="comometa-row-content"><?php	
	
foreach ( $atts['options'] as $selection ) {
	if ( is_array( $selection ) ) {
		$label = $selection['label'];
		$value = $selection['value'];
	} else {
		$label = strtolower( $selection );
		$value = strtolower( $selection );
	}
	?><span class="radio-wrap" style="display: inline-block; padding: 0 0.5em"><input type="radio" id="<?=esc_attr($atts['id'])?>" class="<?php echo esc_attr( $atts['class'] ); ?>" name="<?=esc_attr($atts['name']) ?>" value="<?=$value?>" <?php
		checked($atts['value'], $value); ?> style="width: auto"> <label for="<?=esc_attr($atts['name']) ?>"> <?=$label?> </label></span>
	<?php
} // foreach
if ( ! empty( $atts['description'] ) ) {
	?><br><span class="description"><?php esc_html_e( $atts['description'], 'como-consult' ); ?></span><?php
}
?></span></span>