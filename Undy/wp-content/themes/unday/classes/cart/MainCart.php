<?php
/**
* MainCart
*
* The MainCart Class.
*
* @class    MainCart
* @parent BaseProduct
* @category Class
* @author   Codingkart
*/  
class MainCart extends BaseProduct 
{	
 /**
   * Product Category for the Main Cart class
   * Sets up all the appropriate hooks and actions
   * 
   */
 
	public function __construct(){

		//cart action / filter
		add_filter('woocommerce_cart_item_permalink','__return_false');

		//add_filter( 'woocommerce_cart_product_price', array( $this, 'cart_trialproduct_add_price_currency_symbol' ), 10, 2 );

		add_filter( 'woocommerce_cart_ready_to_calc_shipping', array( $this, 'disable_shipping_renewal_subscription_cart_checkout' ), 99 );

		add_filter( 'woocommerce_subscriptions_product_price_string', array( $this, 'subscriptions_trial_product_change_price_string'), 20, 3 );

		add_action( 'woocommerce_before_calculate_totals', array($this, 'woocommerce_trialproduct_price_name_change_to_cart_item' ), 10, 1 );  

		add_action( 'woocommerce_cart_calculate_fees', array( $this, 'addShhpingOnTrailProductCheckout' ) );

		//add_filter( 'woocommerce_package_rates', array($this, 'hide_delivery_shipping_rates_on_cart2'), 10, 2);

		 //only one coupon
		add_action( 'woocommerce_applied_coupon', array( $this, 'woocommerce_applied_coupon_condition'), 10, 1 );
    } 

    /**
    * check one coupon maximum only
    *  if exit then remove the coupon
    **/
    public function woocommerce_applied_coupon_condition($coupon_code){

 		global $wpdb, $woocommerce;
	    if(!empty($coupon_code))
	    {
			    $applied_coupons = $woocommerce->cart->get_applied_coupons();
		  
		    if(count($applied_coupons) > 1)
		    {
		        $woocommerce->cart->remove_coupon($coupon_code);
                wc_clear_notices();
				wc_add_notice( __("You can apply only one coupon!"), 'error');
		    }
		} 

	}

    public function hide_delivery_shipping_rates_on_cart2(  $rates, $packege ){

		global $woocommerce;

		$total_price = 0;

		if(!empty($rates)){

		    $total =  $woocommerce->cart->cart_contents_total;
		 
		    foreach ( $woocommerce->cart->get_cart() as $key => $cart_item) {

		    	$quantity = $cart_item['quantity'];
		    	$product = $cart_item['data'];
		    	$price = $product->get_price();
		        $total_price += $quantity*$price; 
		    }
		   
		    if( $total_price < 300 ) { 

		        unset( $rates['free_shipping:2'] );
		        
		    }elseif( $total_price > 300) { 

		        unset( $rates['flat_rate:1'] ); 
		        
		    }else{

				   unset( $rates['free_shipping:2'] );
		       unset( $rates['flat_rate:1'] );
			}
		}

		return $rates;
    }

    public function subscriptions_trial_product_change_price_string( $price_string, $product, $args ){

	  	$trial_length = get_post_meta( $product->get_id(), '_subscription_sign_up_fee', true );
	     if( $trial_length > 0 )
 	          $price_string = wc_price($trial_length);
 	      
 	    return $price_string;
	}

    public function cart_trialproduct_add_price_currency_symbol( $product_price_html, $product ) {
    	global $woocommerce;
		
		foreach ($woocommerce->cart->get_cart() as $key => $value) {

	         if( isset( $value["subscription_product"] ) && isset( $value["subscription_items"] ) ) {

	         	return wc_price( $product_price_html );
	         	break;
	         }
	    }
	    return $product_price_html;
	    
	}

	public function disable_shipping_renewal_subscription_cart_checkout( $show_shipping ) {

		global $woocommerce;

	 	$remove_active ='';
 		foreach ($woocommerce->cart->get_cart() as $key => $value) {

		 	if( isset( $value["subscription_renewal"] ) ) {
	 	 	 
	 	 		if( array_key_exists( 'subscription_id', $value["subscription_renewal"] ) ){
					$remove_active = 1;
					//unset($subscription_renewal['custom_line_item_meta']);
					
					break;
	 	 		}
			}else if( isset( $value["subscription_product"] ) && isset( $value["subscription_items"] ) ) {
		        $remove_active = 1;
		        break;
		    }
		}

		if(!empty($remove_active)){
			return false;
		}else{
			 return $show_shipping;	
		}
	 
	}

	public function addShhpingOnTrailProductCheckout(){

		if(2== did_action( 'woocommerce_cart_calculate_fees' )){
        	return false;
		}

		$total_discount_amount = 0;
		$total_coupon_amount = 0;
		$subscription_items = 0; 

	            
  		if(!empty(WC()->cart->get_coupons())){

		 	foreach (WC()->cart->get_coupons() as $coupon => $coupon_obj) {
 		 	 	 
		 		$coupon_id = $coupon_obj->get_id(); 
		 		$coupon_type = $coupon_obj->get_discount_type();  
	            $coupon_amount = $coupon_obj->get_amount();
 	            $free_shipping = $coupon_obj->get_free_shipping();
 		 	}
		}

 		foreach (WC()->cart->get_cart() as $key => $value) {

			if( isset( $value["subscription_product"] ) && isset( $value["subscription_items"] ) ) {
				$subscription_items = 1; 
			}
		}

		if($subscription_items == 1){
 			  $cost = 28.00;
 			if($free_shipping == 1){
 				$discount_amount = $total_discount_amount-$cost;
				$cost = 0.00;
				WC()->cart->add_fee( __('Levering', 'woocommerce'), $cost, true);

  			}else{
 				WC()->cart->add_fee( __('Levering', 'woocommerce'), $cost, true);
 			}
			
		}

	}

	public function woocommerce_trialproduct_price_name_change_to_cart_item( $cart_object ) { 

		global $woocommerce;

		$subscription_product_key = '';

		foreach ($cart_object->get_cart() as $key => $cart_item) {

			if( isset( $cart_item["subscription_product"] ) && isset( $cart_item["subscription_items"] ) ) {

				$subscription_product_key = $key;

			    foreach ($cart_item["subscription_items"] as $k => $ArrayData) {

					if(array_key_exists('trial-product', $ArrayData)){

					  $product_id = $ArrayData['product_id'];
					  break;
					}

				}

				$product = $cart_item['data'];

				$trial_length = get_post_meta( $product->get_id(), '_subscription_sign_up_fee', true );
				 
				if( $trial_length > 0 ){

				    $product->set_price( $trial_length ); 
				}

				//$product_name = $product->get_title();
				$product_name = get_the_title( $product->get_id() );

				$variation = $cart_item["subscription_variation"];

				if(!empty($variation)){

					$cat_term = get_term($variation['product_cat_id'],'product_cat');

					//$color_term = get_term($variation['color_cat_id'],'color-category');

				   //$color_term->name;

					$cat_name = $cat_term->name;

					$color_name =  get_post_meta($product_id, 'wpcf-product-color-title', true); 

					$size_name = $variation['size_slug'];

					$new_name = '<div>'.$product_name.'</div><small>'.ucfirst($cat_name).', '.ucfirst($size_name).', '.ucfirst($color_name).'</small>';      	 

				    $product->set_name( $new_name );
 				    break;  
			    }            

			}elseif( isset( $cart_item["subscription_renewal"] ) ) {

				if( array_key_exists( 'subscription_id', $cart_item["subscription_renewal"] ) ){


					$product = $cart_item['data'];
					$product_id = $cart_item['product_id'];

					//$product_name = $product->get_title();
					$product_name = get_the_title( $product_id );

					$variation = $cart_item["subscription_renewal"]["custom_line_item_meta"];


					$terms = get_the_terms( $product_id, 'product_cat' );

					$array = array(78, 79);
					$cat_name = '';

					foreach ($terms as $key => $term) {

						if(in_array($term->term_id, $array)){
						  $cat_name = $term->name; 
						  break;
						}

					} 
					if(!empty($variation)){

						$color_name =  get_post_meta( $product_id, 'wpcf-product-color-title', true); 

						$size_name = $variation['Size'];

						$new_name = '<div>'.$product_name.'</div><small>'.ucfirst($cat_name).', '.ucfirst($size_name).', '.ucfirst($color_name).'</small>';        

						//if( method_exists( $product, 'set_name' ) )
						$product->set_name( $new_name );
						unset($cart_item["subscription_renewal"]["custom_line_item_meta"]);

					}
				}

			}

		}

		$count = $woocommerce->cart->get_cart_contents_count();
		if($count > 1 && !empty($subscription_product_key)){
 			$woocommerce->cart->remove_cart_item($subscription_product_key);
  		}  
	}


}

new MainCart();
 