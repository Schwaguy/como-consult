<?php
/**
 * The view for the modal form wrap start used in the loop
 */

$options = get_option('como-consult-options');
//echo '<pre>'; print_r($options); echo '</pre>';
$formLogo = ((!empty($options['form-logo-image'])) ? wp_get_attachment_image($options['form-logo-image'], 'como-consult-logo', false, array('class'=>'img-responsive img-fluid') ) : '');
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary consult-button openModal" data-toggle="modal" data-target="#consultModal"><?=$options['default-button-title']?></button>

<div id="processing" class="hide"><div id="feedback"><div class="fa-3x icon"><i class="fas fa-spinner fa-pulse"></i></div></div></div>

<!-- Modal -->
<div class="modal fade" id="consultModal" tabindex="-1" role="dialog" aria-labelledby="consultModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div id="modal-top"></div>
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="consultModalLabel">
					<div class="row align-items-center">
						<div class="col-12 col-sm-6 col-md-4 col-lg-4 logo"><?=$formLogo?></div>
						<div class="col-12 col-sm-6 col-md-8 col-lg-8 title"><?=$options['default-form-title']?></div>
					</div>
				</div>
				<button type="button" class="close reset" aria-label="Reset">
					<span aria-hidden="true"><i class="fal fa-redo"></i></span>
				</button>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fal fa-times"></i></span>
				</button>
			</div>
			<div class="modal-body modal-consult-form">