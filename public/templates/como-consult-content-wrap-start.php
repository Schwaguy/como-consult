<?php
/**
 * The view for the content wrap start used in the loop
 */
$taxString = '';
if (get_the_terms($item->ID, 'formpage-type')) {
	$formpageTypes = get_the_terms($item->ID, 'formpage-type');
	//echo '<pre>'; print_r($formpageTypes); echo '</pre>';
	$count = count($formpageTypes);
	for ($i=0;$i<$count;$i++) {
		$taxString .= ' '. $formpageTypes[$i]->slug;
	}
}
?><div class="hentry formpage hidden <?=$taxString?>">