<?php
/**
 * The view for the formpage title used in the loop
 */
$options = get_option('como-consult-options');
//echo '<pre>'; print_r($item); echo '</pre>';
$formCircleImg = ((!empty($options['form-circle-image'])) ? '<div class="circle-img-wrap">'. wp_get_attachment_image($options['form-circle-image'], 'como-consult-circle', false, array('class'=>'img-responsive img-fluid') ) .'</div>' : 'false');
?>
<div class="formpage-intro">
	<?=$formCircleImg?>
	<h3 class="formpage-list-name" itemprop="name"><?php echo $item->post_title; ?></h3>
	<?=apply_filters('the_content',$item->post_content)?>
</div>
