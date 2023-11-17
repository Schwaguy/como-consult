<?php
/**
 * The view for the single formpage metadata for Location
 */

$questions = maybe_unserialize($meta['como-field-repeater'][0]);
//echo '<pre>'; print_r($questions); echo '</pre>';
$count = count($questions);

if ($count>0) {
	foreach ($questions as $question) {
		if (!empty($question['field-name'])) {
			if ($question['field-required'] == 'yes') {
				$required = 'required="required" aria-required="true"';
				$requiredClass = 'required';
				$requiredMarker = ' <span class="req">*</span>'; 
			} else {
				$required = '';
				$requiredMarker = '';
				$requiredClass = ''; 
			}
			?><div class="question">
				<label><?=$question['field-label']?><?=$requiredMarker?></label>
	
				<?php
					switch ($question['field-type']) {
						case 'email':
							?><input type="email" name="<?=$question['field-name']?>" class="<?=$requiredClass?>" <?=$required?> /><?php
							break;
						case 'phone':
							?><input type="tel" name="<?=$question['field-name']?>" class="phone-field <?=$requiredClass?>" <?=$required?> /><?php
							break;
						case 'number' :
							?><input type="number" name="<?=$question['field-name']?>" min="0" step="1" class="<?=$requiredClass?>" <?=$required?> /><?php
							break;
						case 'radio' :
							$options = explode(PHP_EOL, $question['field-options']);
							$count = count($options);
							?><div class="row"><?php
							for ($i=0;$i<$count;$i++) {
								if (!empty($options[$i])) {
									?><div class="col col-12 col-md-6 pb-2"><input type="radio" name="<?=$question['field-name']?>" value="<?=$options[$i]?>" class="<?=$requiredClass?>" <?=$required?> /> <?=$options[$i]?></div><?php 
								}
							}
							?></div><?php
							break;
						case 'checkboxes' :
							$options = explode(PHP_EOL, $question['field-options']);
							$count = count($options);
							for ($i=0;$i<$count;$i++) {
								if (!empty($options[$i])) {
									?><p class="checkbox-option"><input type="checkbox" name="<?=$question['field-name']?>[]" value="<?=$options[$i]?>" class="<?=$requiredClass?>" <?=$required?>> <?=$options[$i]?></p><?php 
								}
							}
							break;
						case 'select' :
							$options = explode(PHP_EOL, $question['field-options']);
							?><select name="<?=$question['field-name']?>" class="<?=$requiredClass?>" <?=$required?>><?php
							$count = count($options);
							for ($i=0;$i<$count;$i++) {
								if (!empty($options[$i])) {
									?><option value="<?=$options[$i]?>"><?$options[$i]?></option><?php
								}
							}
							?></select><?php
							break;
						case 'textarea' :
							?><textarea name="<?=$question['field-name']?>" class="<?=$requiredClass?>" <?=$required?>></textarea><?php
							break;
						case 'image-upload' :
							
							$img = 'TEST';					
							//$img = ($question['field-sample-image'] ? wp_get_attachment_image($question['field-sample-image'], 'medium', false, array('class'=>'img-responsive img-fluid')) : '');
							?><div class="row">
								<div class="col-12 col-sm-6"><?=$img?></div>	
								<div class="col-12 col-sm-6 img-upload-wrap">
									<img class="img-upload-preview img-responsive img-fluid" src="<?=plugin_dir_url( __FILE__ )?>images/photo-placeholder-min.jpg" />
									<input type="file" id="photoUpload_<?=$question['field-name']?>" name="photoUpload_<?=$question['field-name']?>" class="img-upload <?=$requiredClass?>" accept="image/gif,image/jpeg,image/jpg,image/png,image/x-png" <?=$required?>>
									<input type="hidden" class="img-path" name="consultPhoto_<?=$question['field-name']?>" id="consultPhoto_<?=$question['field-name']?>" />
								</div>
							</div><?php
							break;
						default:
							?><input type="text" id="<?=$question['field-name']?>" name="<?=$question['field-name']?>" class="<?=$requiredClass?>" <?=$required?>><?php
							break;
							
					}
					if ($question['field-required'] == 'yes') { ?><label class="warning" id="<?=$question['field-name']?>-error" for="<?=$question['field-name']?>"></label><?php }	
				?>
	
			</div><?php
		}
	}
}
if ($meta['forminfo-after'][0]) {
	/*?><div class="after-fields"><?=apply_filters('the_content',wp_specialchars_decode($meta['forminfo-after'][0]))?></div><?*/
	?><div class="after-fields"><?=apply_filters('the_content',html_entity_decode($meta['forminfo-after'][0]))?></div><?
}
	
if ($meta['formbutton-type'][0]) {
	?><p class="text-center"><?php
	if ($meta['formbutton-type'][0] == 'submit') {
		?><input type="submit" class="btn btn-primary submit-button <?=$meta['formbutton-class'][0]?>" value="<?=$meta['formbutton-text'][0]?>" /><?php	
	} elseif ($meta['formbutton-type'][0] == 'close') {
		?><button type="button" class="btn btn-primary close-button <?=$meta['formbutton-class'][0]?>" data-dismiss="modal"><?=$meta['formbutton-text'][0]?></button><?php
	} else {
		?><button type="button" class="btn btn-primary next-button <?=$meta['formbutton-class'][0]?>"><?=$meta['formbutton-text'][0]?></button><?php
	}
	?></p><?php
}