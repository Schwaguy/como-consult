<?php

/**
 * Provide the view for a metabox
 *
 * @link 		https://comocreative.com
 * @since 		1.0.0
 *
 * @package 	Como_Consult
 * @subpackage 	Como_Consult/admin/partials
 */

?>
<div class="consult-after-fields">
	<?php
		wp_nonce_field( $this->plugin_name, 'formpage_after_fields' );
		// Additional Content after Form Fields
		$atts 					= array();
		$atts['class'] 			= 'widefat';
		$atts['description'] 	= '';
		$atts['id'] 			= 'forminfo-after';
		$atts['label'] 			= 'Content after Fields';
		$atts['name'] 			= 'forminfo-after';
		$atts['placeholder'] 	= '';
		$atts['type'] 			= 'editor';
		$atts['value'] 			= '';
		if ( ! empty( $this->meta[$atts['id']][0] ) ) {
			$atts['value'] = $this->meta[$atts['id']][0];
		}
		apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
		include( plugin_dir_path( __FILE__ ) . 'como-admin-field-editor.php' );
	?>
	
	<div class="row" style="margin-top: 1em;">
		<div class="col-12 col-md-4">
			<?php
				// Botton
				$atts 					= array();
				$atts['class'] 			= 'widefat';
				$atts['description'] 	= '';
				$atts['id'] 			= 'formbutton-type';
				$atts['label'] 			= 'Form Button Type';
				$atts['name'] 			= 'formbutton-type';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'select';
				$atts['selections'] 	= array('Next','Submit','Close');
				$atts['blank'] 			= '< select >';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
				include( plugin_dir_path( __FILE__ ) . 'como-admin-field-select.php' );
			?>
		</div>
		<div class="col-12 col-md-4">
			<?php
				// Botton
				$atts 					= array();
				$atts['class'] 			= 'widefat';
				$atts['description'] 	= '';
				$atts['id'] 			= 'formbutton-text';
				$atts['label'] 			= 'Form Button Text';
				$atts['name'] 			= 'formbutton-text';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
				include( plugin_dir_path( __FILE__ ) . 'como-admin-field-text.php' );
			?>
		</div>
		<div class="col-12 col-md-4">
			<?php
				// Botton
				$atts 					= array();
				$atts['class'] 			= 'widefat';
				$atts['description'] 	= '';
				$atts['id'] 			= 'formbutton-class';
				$atts['label'] 			= 'Form Button Class';
				$atts['name'] 			= 'formbutton-class';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
				include( plugin_dir_path( __FILE__ ) . 'como-admin-field-text.php' );
			?>
		</div>
	</div>
</div><!-- consult-after-fields -->