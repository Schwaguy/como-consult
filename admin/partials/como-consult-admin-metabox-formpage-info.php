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
<div class="consult-details">
	<?php
		wp_nonce_field( $this->plugin_name, 'formpage_additional_info' );
		$setatts 					= array();
		$setatts['class'] 			= 'repeater';
		$setatts['id'] 				= 'como-field-repeater';
		$setatts['label-add'] 		= 'Add Field';
		$setatts['label-edit'] 		= 'Edit Field';
		$setatts['label-header'] 	= 'Form Page Fields';
		$setatts['label-remove'] 	= 'Remove Field';
		$setatts['title-field'] 	= 'label-file'; // which field provides the title for each fieldset?
		$i = 0;
	
		$setatts['fields'][$i]['text']['class'] 				= 'widefat repeater-label';
		$setatts['fields'][$i]['text']['description'] 			= '';
		$setatts['fields'][$i]['text']['id'] 					= 'field-label';
		$setatts['fields'][$i]['text']['label'] 				= 'Field Label';
		$setatts['fields'][$i]['text']['name'] 					= 'field-label';
		$setatts['fields'][$i]['text']['placeholder'] 			= 'Field label';
		$setatts['fields'][$i]['text']['type'] 					= 'text';
		$setatts['fields'][$i]['text']['value'] 				= '';
		$i++;

		$setatts['fields'][$i]['text']['class'] 				= 'widefat';
		$setatts['fields'][$i]['text']['description'] 			= '';
		$setatts['fields'][$i]['text']['id'] 					= 'field-name';
		$setatts['fields'][$i]['text']['label'] 				= 'Field Name';
		$setatts['fields'][$i]['text']['name'] 					= 'field-name';
		$setatts['fields'][$i]['text']['placeholder'] 			= 'Field Name';
		$setatts['fields'][$i]['text']['type'] 					= 'text';
		$setatts['fields'][$i]['text']['value'] 				= '';
		$i++;
	
		$fieldTypeArray = array('text','email','phone','number','select','radio','checkbox','checkboxes','image-upload');
		$atts['blank'] 			= '';
		$setatts['fields'][$i]['select']['class']		= 'widefat field-type-select';
		$setatts['fields'][$i]['select']['description']	= '';
		$setatts['fields'][$i]['select']['id']			= 'field-type';
		$setatts['fields'][$i]['select']['label'] 		= 'Field Type';
		$setatts['fields'][$i]['select']['name'] 		= 'field-type';
		$setatts['fields'][$i]['select']['type'] 		= 'select';
		$setatts['fields'][$i]['select']['selections'] 	= $fieldTypeArray;
		$setatts['fields'][$i]['select']['value'] 		= '';
		$setatts['fields'][$i]['select']['blank'] 		= '< select >';
		if ( ! empty( $this->meta[$setatts['fields'][$i]['select']['id']][0] ) ) {
			$setatts['fields'][$i]['text']['value']  = $this->meta[$setatts['fields'][$i]['select']['id']][0];
		}
		$i++;
	
		$setatts['fields'][$i]['textarea']['class'] 		= 'widefat field-options';
		$setatts['fields'][$i]['textarea']['description'] 	= '';
		$setatts['fields'][$i]['textarea']['id'] 			= 'field-options';
		$setatts['fields'][$i]['textarea']['label'] 		= 'Field Options';
		$setatts['fields'][$i]['textarea']['name'] 			= 'field-options';
		$setatts['fields'][$i]['textarea']['placeholder'] 	= 'Field Options';
		$setatts['fields'][$i]['textarea']['textarea']		= 'textarea';
		$setatts['fields'][$i]['textarea']['value'] 		= '';
		$i++;
	
		$setatts['fields'][$i]['image-upload']['class'] 		= 'widefat url-file field-sample-image';
		$setatts['fields'][$i]['image-upload']['description'] 	= '';
		$setatts['fields'][$i]['image-upload']['id'] 			= 'field-sample-image';
		$setatts['fields'][$i]['image-upload']['label'] 		= 'Sample Image';
		$setatts['fields'][$i]['image-upload']['label-add'] 	= 'Add Image';
		$setatts['fields'][$i]['image-upload']['label-remove'] 	= 'Remove Image';
		$setatts['fields'][$i]['image-upload']['label-edit'] 	= 'Edit Image';
		$setatts['fields'][$i]['image-upload']['label-upload'] 	= 'Choose/Upload Image';
		$setatts['fields'][$i]['image-upload']['name'] 			= 'field-sample-image';
		$setatts['fields'][$i]['image-upload']['placeholder'] 	= '';
		$setatts['fields'][$i]['image-upload']['type'] 			= 'hidden';
		$setatts['fields'][$i]['image-upload']['value'] 		= '';
		if ( ! empty( $this->meta[$setatts['fields'][$i]['image-upload']['id']][0] ) ) {
			$setatts['fields'][$i]['image-upload']['value']  = $this->meta[$setatts['fields'][$i]['image-upload']['id']][0];
		}
		$i++;
	
		$fieldRequiredArray = array('Yes','No');
		$atts['blank'] 			= '';
		$setatts['fields'][$i]['select']['class']		= 'widefat';
		$setatts['fields'][$i]['select']['description']	= '';
		$setatts['fields'][$i]['select']['id']			= 'field-required';
		$setatts['fields'][$i]['select']['label'] 		= 'Required Field';
		$setatts['fields'][$i]['select']['name'] 		= 'field-required';
		$setatts['fields'][$i]['select']['type'] 		= 'select';
		$setatts['fields'][$i]['select']['selections'] 	= $fieldRequiredArray;
		$setatts['fields'][$i]['select']['value'] 		= '';
		$setatts['fields'][$i]['select']['blank'] 		= '< select >';
		if ( ! empty( $this->meta[$setatts['fields'][$i]['select']['id']][0] ) ) {
			$setatts['fields'][$i]['text']['value']  = $this->meta[$setatts['fields'][$i]['select']['id']][0];
		}
		$i++;
	
		/*$fieldRequiredArray = array(array('label'=>'Yes','value'=>'required'),array('label'=>'No','value'=>'not-required'));	
		$setatts['fields'][$i]['radio']['id']			= 'field-required';
		$setatts['fields'][$i]['radio']['class'] 		= 'radio-button';
		$setatts['fields'][$i]['radio']['description'] 	= '';
		$setatts['fields'][$i]['radio']['label'] 		= 'Required Field';
		$setatts['fields'][$i]['radio']['name'] 		= 'field-required';
		$setatts['fields'][$i]['radio']['value']		= '';
		$setatts['fields'][$i]['radio']['options'] 		= $fieldRequiredArray ;
		if ( ! empty( $this->meta[$setatts['fields'][$i]['radio']['id']][0] ) ) {
			$setatts['fields'][$i]['radio']['value']  = $this->meta[$setatts['fields'][$i]['radio']['id']][0];
		}
		$i++;*/
	
		//apply_filters( $this->plugin_name . '-field-repeater-formpage-fields', $setatts );

		$count 		= 1;
		$repeater 	= array();

		if ( ! empty( $this->meta[$setatts['id']] ) ) {
			$repeater = maybe_unserialize( $this->meta[$setatts['id']][0] );
		}
	
		if ( ! empty( $repeater ) ) {
			$count = count( $repeater );
		}
		include( plugin_dir_path( __FILE__ ) . 'como-admin-field-repeater.php' );
	
	?>
</div><!-- consult-details -->