<?php

/**
 * Provides the markup for an upload field
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

if (!empty($atts['value'])) {
	// Get the image src
	$img_src = wp_get_attachment_image_src($atts['value'], 'medium');
	$have_header_img = is_array( $img_src );
	$uploadClass = 'hide';
	$removeClass = ''; 
} else {
	$have_header_img = false;
	$uploadClass = '';
	$removeClass = 'hide';
}

?>
<!-- Your image container, which can be manipulated with js -->
<span class="img-container img-preview">
	<?php if ( $have_header_img ) : ?>
		<img src="<?php echo $img_src[0] ?>" alt="" style="max-width:100%;" /><br>
	<?php endif; ?>
</span>

<input
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	data-id="url-file"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" />
<span><a href="#" class="<?=$uploadClass?> upload-image"><?php esc_html_e( $atts['label-upload'], 'como-consult' ); ?></a>
<br><a href="#" class="<?=$removeClass?> remove-image"><?php esc_html_e( $atts['label-remove'], 'como-consult' ); ?></a></span>
</span></span>