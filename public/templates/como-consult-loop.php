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

/**
 * como-consult-before-loop hook
 *
 * @hooked 		form_wrap_start 		10
 */
do_action( 'como-consult-before-loop' ); ?>
				
<form method="post" class="formpage-form-wrap" id="virtual-consult" enctype="multipart/form-data">
	<span class="hpot"><input type="text" id="hpot" name="hpot" value="" /></span>
	<input type="hidden" id="submitURL" name="submitURL" value="<?=plugin_dir_url( __DIR__ )?>inc/processForm.php" />
	<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
		TEST		
	<?php
		$itemCount = count($items);
		for ($i=0;$i<$itemCount;$i++) {
			$item = $items[$i];
			$meta = get_post_custom( $item->ID );

			/**
			 * como-consult-before-loop-content hook
			 *
			 * @param 		object  	$item 		The post object
			 *
			 * @hooked 		content_wrap_start 		10
			 */
			do_action( 'como-consult-before-loop-content', $item, $meta, $i );

				/**
				 * como-consult-loop-content hook
				 *
				 * @param 		object  	$item 		The post object
				 *
				 * @hooked 		content_formpage_title 		10
				 * @hooked 		content_formpage_location 	15
				 */
				do_action( 'como-consult-loop-content', $item, $meta );

			/**
			* como-consult-after-loop-content hook
			*
			* @param 		object  	$item 		The post object
			*
			* @hooked 		content_link_end 		10
			* @hooked 		content_wrap_end 		90
			*/
			do_action( 'como-consult-after-loop-content', $item, $meta );

		} // foreach
?>
</form>
<?php

/**
 * como-consult-after-loop hook
 *
 * @hooked 		form_wrap_end 			10
 */
do_action( 'como-consult-after-loop' );
