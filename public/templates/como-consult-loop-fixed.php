<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the archive loop.
 *
 * @link       https://comocreative.com
 * @since      1.0.0
 *
 * @package    Como_Consult
 * @subpackage Como_Consult/public/partials
 */

global $modal;
$modal = '';

$options = get_option('como-consult-options');
//echo '<pre>'; print_r($options); echo '</pre>';
$formLogo = ((!empty($options['form-logo-image'])) ? wp_get_attachment_image($options['form-logo-image'], 'como-consult-logo', false, array('class'=>'img-responsive img-fluid') ) : '');

$formCircleImg = ((!empty($options['form-circle-image'])) ? '<div class="circle-img-wrap">'. wp_get_attachment_image($options['form-circle-image'], 'como-consult-circle', false, array('class'=>'img-responsive img-fluid') ) .'</div>' : '');

?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary consult-button openModal" data-bs-toggle="modal" data-bs-target="#consultModal"><?=$options['default-button-title']?></button>

<?php
$modal .= '<div id="processing" class="hide"><div id="feedback"><div class="fa-3x icon"><i class="fas fa-spinner fa-pulse"></i></div></div></div>
<!-- Modal -->
<div class="modal fade" id="consultModal" tabindex="-1" role="dialog" aria-labelledby="consultModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div id="modal-top"></div>
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="consultModalLabel">
					<div class="row align-items-center">
						<div class="col-12 col-sm-6 col-md-4 col-lg-4 logo">'. $formLogo .'</div>
						<div class="col-12 col-sm-6 col-md-8 col-lg-8 title">'. $options['default-form-title'] .'</div>
					</div>
				</div>
				<button type="button" class="close reset" aria-label="Reset">
					<span aria-hidden="true"><i class="fal fa-redo"></i></span>
				</button>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fal fa-times"></i></span>
				</button>
			</div>
			<div class="modal-body modal-consult-form">';
				
			$modal .= '<form method="post" class="formpage-form-wrap" id="virtual-consult" enctype="multipart/form-data">
				<span class="hpot"><input type="text" id="hpot" name="hpot" value="" /></span>
				<input type="hidden" id="submitURL" name="submitURL" value="'. plugin_dir_url( __DIR__ ) .'inc/processForm.php" />
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />';
				
				$itemCount = count($items);
				
				for ($it=0;$it<$itemCount;$it++) {
					$item = $items[$it];
					$meta = get_post_custom( $item->ID );
					
					$taxString = '';
					if (get_the_terms($item->ID, 'formpage-type')) {
						$formpageTypes = get_the_terms($item->ID, 'formpage-type');
						//echo '<pre>'; print_r($formpageTypes); echo '</pre>';
						$count = count($formpageTypes);
						for ($i=0;$i<$count;$i++) {
							$taxString .= ' '. $formpageTypes[$i]->slug;
						}
					}
					$modal .= '<div class="hentry formpage hidden '. $taxString .'" id="formPage-'. $it .'">';
					
					$modal .= '<div class="formpage-intro">
						'. $formCircleImg .'
						<h3 class="formpage-list-name" itemprop="name">'. $item->post_title .'</h3>
						'. apply_filters('the_content',$item->post_content) .'
					</div>';
					
					$questions = maybe_unserialize($meta['como-field-repeater'][0]);
					//echo '<pre>'; print_r($questions); echo '</pre>';
					$Qcount = count($questions);

					if ($Qcount>0) {
						foreach ($questions as $question) {
							if (!empty($question['field-name'])) {
								if ($question['field-required'] == 'yes') {
									$required = 'required="required" aria-required="true"';
									$requiredClass = 'required '. (($it == 0) ? '' : 'ignore');
									$requiredMarker = ' <span class="req">*</span>'; 
								} else {
									$required = '';
									$requiredMarker = '';
									$requiredClass = ''; 
								}
								$modal .= '<div class="question">
									<label>'. $question['field-label'] . $requiredMarker .'</label>';

									switch ($question['field-type']) {
										case 'email':
											$modal .= '<input type="email" name="'. $question['field-name'] .'" class="'. $requiredClass .'" '. $required .' />';
											break;
										case 'phone':
											$modal .= '<input type="tel" name="'. $question['field-name'] .'" class="phone-field '. $requiredClass .'" '. $required .' />';
											break;
										case 'number' :
											$modal .= '<input type="number" name="'. $question['field-name'] .'" min="0" step="1" class="'. $requiredClass .'" '. $required .' />';
											break;
										case 'radio' :
											$options = explode(PHP_EOL, $question['field-options']);
											$count = count($options);
											$modal .= '<div class="row">';
											for ($i=0;$i<$count;$i++) {
												if (!empty($options[$i])) {
													$modal .= '<div class="col col-12 col-md-6 pb-2"><input type="radio" name="'. $question['field-name'] .'" value="'. $options[$i] .'" class="'. $requiredClass .'" '. $required .' /> '. $options[$i] .'</div>'; 
												}
											}
											$modal .= '</div>';
											break;
										case 'checkboxes' :
											$options = explode(PHP_EOL, $question['field-options']);
											$count = count($options);
											for ($i=0;$i<$count;$i++) {
												if (!empty($options[$i])) {
													$modal .= '<p class="checkbox-option"><input type="checkbox" name="'. $question['field-name'] .'[]" value="'. $options[$i] .'" class="'. $requiredClass .'" '. $required .'> '. $options[$i] .'</p>'; 
												}
											}
											break;
										case 'select' :
											$options = explode(PHP_EOL, $question['field-options']);
											$modal .= '<select name="'. $question['field-name'] .'" class="'. $requiredClass .'" '. $required .'>';
											$count = count($options);
											for ($i=0;$i<$count;$i++) {
												if (!empty($options[$i])) {
													$modal .= '<option value="'. $options[$i] .'">'. $options[$i] .'</option>';
												}
											}
											$modal .= '</select>';
											break;
										case 'textarea' :
											$modal .= '<textarea name="'. $question['field-name'] .'" class="'. $requiredClass .'" '. $required .'></textarea>';
											break;
										case 'image-upload' :
											//$img = 'TEST'; 
											$img = ($question['field-sample-image'] ? wp_get_attachment_image($question['field-sample-image'], 'medium', false, array('class'=>'img-responsive img-fluid')) : '');
											$modal .= '<div class="row">
												<div class="col-12 col-sm-6">'. $img .'</div>	
												<div class="col-12 col-sm-6 img-upload-wrap">
													<img class="img-upload-preview img-responsive img-fluid" src="'. plugin_dir_url( __FILE__ ) .'images/photo-placeholder-min.jpg" />
													<input type="file" id="photoUpload_'. $question['field-name'] .'" name="photoUpload_'. $question['field-name'] .'" class="img-upload '. $requiredClass .'" accept="image/gif,image/jpeg,image/jpg,image/png,image/x-png" '. $required .'>
													<input type="hidden" class="img-path" name="consultPhoto_'. $question['field-name'] .'" id="consultPhoto_'. $question['field-name'] .'" />
												</div>
											</div>';
											break;
										default:
											$modal .= '<input type="text" id="'. $question['field-name'] .'" name="'. $question['field-name'] .'" class="'. $requiredClass .'" '. $required .'>';
											break;

									}
									if ($question['field-required'] == 'yes') { $modal .= '<label class="warning" id="'. $question['field-name'] .'-error" for="'. $question['field-name'] .'"></label>'; }	
								$modal .= '</div>';
							}
						}
					}
					if ($meta['forminfo-after'][0]) {
						$modal .= '<div class="after-fields">'. apply_filters('the_content',html_entity_decode($meta['forminfo-after'][0])) .'</div>';
					}

					if ($meta['formbutton-type'][0]) {
						$modal .= '<p class="text-center">';
						if ($meta['formbutton-type'][0] == 'submit') {
							$modal .= '<input type="submit" class="btn btn-primary submit-button '. $meta['formbutton-class'][0] .'" value="'. $meta['formbutton-text'][0] .'" />';	
						} elseif ($meta['formbutton-type'][0] == 'close') {
							$modal .= '<button type="button" class="btn btn-primary close-button '. $meta['formbutton-class'][0] .'" data-dismiss="modal">'. $meta['formbutton-text'][0] .'</button>';
						} else {
							$modal .= '<button type="button" class="btn btn-primary next-button '. $meta['formbutton-class'][0] .'">'. $meta['formbutton-text'][0] .'</button>';
						}
						$modal .= '</p>';
					}
					
					$modal .= '</div><!-- .hentry -->';
					
					unset($item);
					unset($meta);

				} // foreach
				
			$modal .= '</form>';

	$modal .= '</div>
			<!--<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>-->
		</div>
	</div>
</div>';
	
$GLOBALS['page-modals'] = $modal;
	
//echo $modal;
