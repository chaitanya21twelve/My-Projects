<?php

$request_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

$is_admin = strpos( $request_uri, '/wp-admin/' );

if( false === $is_admin ){
	add_filter( 'option_active_plugins', function( $plugins ){
		global $request_uri;

		$home_url = get_home_url().'/';

	    $current_url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


	    $page = explode("/",$_SERVER['REQUEST_URI']);

		if( $home_url === $current_url ){
			$myplugins = array('variation-swatches-for-woocommerce/variation-swatches-for-woocommerce.php','woocommerce-product-bundles/woocommerce-product-bundles.php','woocommerce-subscriptions/woocommerce-subscriptions.php','woocommerce-url-coupons/woocommerce-url-coupons.php','woocommerce-waitlist/woocommerce-waitlist.php','js_composer/js_composer.php','redirection/redirection.php');

	        $plugins      = array_diff( $plugins, $myplugins );
		}
		else if( 'vare' == $page[2] )
		{
			$myplugins = array('js_composer/js_composer.php','redirection/redirection.php');

	        $plugins      = array_diff( $plugins, $myplugins );
		}


		return $plugins;

	} );
}