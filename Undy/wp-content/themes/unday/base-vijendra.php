<?php
//add_action( 'wp-footer', 'check_code_on_footer');
 function check_code_on_footer(){
 	$sizeCategories = get_terms( 'size-category', array(
		'hide_empty' => true,
	) );
	print_r($sizeCategories);
 }