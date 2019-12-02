<?php
/**
* ProductCategory
*
* The ProductCategory Class.
*
* @class    ProductCategory
* @parent BaseProduct
* @category Class
* @author   Codingkart
*/  
class ProductCategory extends BaseProduct 
{	
  /**
   * Product Category for the Product Category class
   * Sets up all the appropriate hooks and actions
   * 
   */ 
 
	public function __construct(){

	     //create new subscription hook 
	    add_action( 'woocommerce_checkout_subscription_created', array($this, 'addMoreTrailProductInToSubscriptionItemCallback') , 10, 3 );

	    //create new order hook 
	    //add_action( 'woocommerce_new_order', array( $this, 'addTrailProductInToOrderItemCallback' ), 1, 1 );   
	    
	    add_action( 'woocommerce_checkout_create_order', array( $this, 'addTrailProductAddItemANDShipping'), 20, 1 );

	    add_action('woocommerce_checkout_process', array( $this, 'ChecktrailProductQuantityOnCheckoutprocess' ));

	    add_filter( 'woocommerce_subscriptions_thank_you_message', array($this, 'change_subscriptions_thank_you_message'), 10, 1 );  
	 
	    add_action( 'woocommerce_subscription_renewal_payment_complete', array( $this, 'renewal_subscription_order_status_change_processing_to_on_hold'), 10, 2 );

	   //  add_action( 'woocommercethankyou', array($this, 'orderemailworkaround') );


	    // subscription renewal order payment not capture   
	    //add_filter ('woocommerce_stripe_request_body', array($this, 'set_subscription_renewal_order_payment_not_capture'), 10, 2);

	    add_action( 'woocommerce_order_status_changed', array( $this, 'woocommerce_order_status_change_to_subscription_check'), 99, 3 );

	    add_filter('woocommerce_checkout_fields', array( $this, 'change_billing_fields_address_lable')) ;
 
 	} 


	

	public function change_billing_fields_address_lable($fields)
	{

 		$fields['billing']['billing_address_1']['label'] = 'Adresse';
 		$fields['billing']['billing_address_1']['placeholder'] = 'Adresse';
		$fields['billing']['billing_address_2']['label'] = 'Evt. adresse 2';
		$fields['billing']['billing_address_2']['placeholder'] = 'Evt. adresse 2';
		$fields['shipping']['shipping_address_1']['label'] = 'Adresse';
		$fields['shipping']['shipping_address_1']['placeholder'] = 'Adresse';
		$fields['shipping']['shipping_address_2']['label'] = 'Evt. adresse 2';
		$fields['shipping']['shipping_address_2']['placeholder'] = 'Evt. adresse 2';
		unset($fields['billing']['billing_address_2']['label_class']);
		unset($fields['shipping']['shipping_address_2']['label_class']);
		unset($fields['billing']['billing_state']);
	    unset($fields['shipping']['shipping_state']);

 		return $fields;
 	}


	public function woocommerce_order_status_change_to_subscription_check( $order_id, $old_status, $new_status ){

	    if( $new_status == "completed" ) {

			$subscriptions = array();

			if (wcs_order_contains_subscription($order_id)) {

			    $subscriptions = wcs_get_subscriptions_for_order($order_id);

			}elseif (wcs_order_contains_renewal($order_id)) {

			    $subscriptions = wcs_get_subscriptions_for_renewal_order($order_id);
			}

			if(count($subscriptions) > 0){

				foreach ($subscriptions as $subscription) {

					$sub_hold_key = get_post_meta($subscription->id, 'sub_hold_key', true);

					$subscription_status = $subscription->get_status();

					$allow_status = array('active', 'on-hold'); //

					if(in_array($subscription_status, $allow_status) && $sub_hold_key == 'yes' ){

					    $post_status = 'on-hold'; 
					    
					    $subscription->update_status( $post_status ); 
					}

				}

			}

	    }
	}

	public function set_subscription_renewal_order_payment_not_capture($request, $api){

		if(is_array($request)){

			if(array_key_exists('metadata', $request)){

			    if(array_key_exists('order_id', $request['metadata'])){
			     
			        $order_id = $request['metadata']['order_id'];

			        if(wcs_order_contains_renewal( $order_id )){

			            $request['capture'] = 'false';
			            update_post_meta($order_id, 'capture_renewal_order_payment_hold', 'active');

			        } 
			    }
			}
	    }

	    return $request;
	}



    public function orderemailworkaround ($orderid) {
		global $woocommerce;

		$mailer = $woocommerce->mailer();

		// Email admin with new order email
		$email = $mailer->emails['WCEmailNewOrder'];
		 
		$email->trigger( $orderid );
    }

	public function renewal_subscription_order_status_change_processing_to_on_hold( $subscription , $order ) {

	    global $wpdb; 

	    if( is_array($subscription) || is_object($subscription) ){

	        $items = $subscription->get_items(); 

	        $subscription_vari = get_post_meta( $subscription->get_id(), 'subscription_variation', true );

	        $detele_item =0;

 	        foreach ( $items as $itemID => $item ) {
 			    $product_ids= array();

			    $quantity = $item['quantity'];
			    $variation_id = $item['variation_id'];

			    $variation_obj = new WC_Product_Variation($variation_id);			     

		       	$stock = $variation_obj->get_stock_quantity();

		        if($stock <= 0 || empty($stock)){ 

 			        $this->quantity_increase($variation_id, $quantity);
 			        wc_delete_order_item( $itemID );
 			        $detele_item += $quantity;
 			        $sub_product_id = $variation_obj->post->post_parent;
					$size = $variation_obj->get_data()['attributes']['pa_size'];
					$product_ids_size[$sub_product_id] =  $size;
 			        $product_ids[$sub_product_id] = $quantity;
  			    }
			  }

	 	 	if($detele_item > 0){

	 	 		// $product_cat = $subscription_vari['product_cat_id'];

	 	 		// $size_name = $subscription_vari['size_slug'];

	 	 	 //  $color_array = explode(',', $subscription_vari['color_cat_id']);

      //       	foreach ($color_array as $key => $ids) {
            	 
      //       	    $color = get_term($ids,'color-category');
      //       	    $color_term_id = $color->term_id;

      //       	    $item_data = $this->getProductAccordingToCategory($product_cat, $color_term_id, $size_name, $product_ids, $detele_item);

      //       	    if(count($item_data) >= $detele_item){
      //       	    	break;
      //        	    }
      //       	}

	 	 	    foreach ($product_ids as  $productId => $product_qty) {

	 	 	    	$item_array = array();

	 	 	    	$product = wc_get_product($productId);

 				    $cross_sell_ids = $product->get_cross_sell_ids();

 				    foreach ($cross_sell_ids as  $variationId) {

 				    	$variationObj = new WC_Product_Variation($variationId);

		                $stock_cross = $variationObj->get_stock_quantity();
						$attributes = $variationObj->get_variation_attributes();

						if(array_key_exists('attribute_pa_size', $attributes)){
							$item_array['size'] =  $attributes['attribute_pa_size'];
						} 
		                // if($stock_cross <= 0 || empty($stock_cross)){ 

  		                // }else{  

							if($product_ids_size[$productId]!=$item_array['size']){
								continue;
							}

  		                	$item_array['product_id'] = $variationObj->post->post_parent;
		                	$item_array['variation_id'] = $variationId;

		                	$product_cat_terms = get_the_terms($item_array['product_id'], 'product_cat' );

							foreach($product_cat_terms as $term) 
							{
								if($term->term_id == 78 || $term->term_id == 79 ){
								   $product_cat_term = $term;
								   break;
								}
							}
		                	$item_array['product_cat_id'] = $product_cat_term->term_id;
		                	$item_array['quantity'] = $product_qty;
 		                	$item_data[] =$item_array; 
   		                	break;
 		                //} 				     
 				    }
	 	 	    }
	 	 	 
 	            foreach ($item_data as $key => $item_list) {

 	            	$product_id = $item_list['product_id'];
 	            	$variation_id = $item_list['variation_id'];
  	            	$size = $item_list['size']; 	            
  	            	$qty = $item_list['quantity']; 	            
  	            	$product_cat_id = $item_list['product_cat_id'];

	 	            $varProduct = new WC_Product_Variation($variation_id);
		            $price = '94.50';
	                $product_name = $this->product_tittle_name_change($product_id, array('size_slug'=> $size, 'product_cat_id' => $product_cat_id ) );
 					//change product price
					$varProduct->set_price($price);
					//channge product name
					$varProduct->set_name( $product_name );
					
					$subscription->add_product($varProduct, $qty, $variationsArray);

					$this->quantity_decrease($variation_id, $qty);
			    }
 	 	 	}
 	    }
 
	} 

	public function change_subscriptions_thank_you_message($thank_you_message){


	    $thank_you_message = __( 'Dit abonnement vil blive aktiveret, lige så snart betalingen er verificeret. Du kan altid se status på dit abonnement ind på <a href="' .site_url(). '/my-account/subscription-box/"> <strong>Min konto</strong> </a>', 'woocommerce-subscriptions' );

	    $thank_you_message = '';

	    return $thank_you_message;
	}

	public function ChecktrailProductQuantityOnCheckoutprocess(){

	    global $woocommerce; 

	    $stockError = '';

	    foreach (wc()->cart->get_cart() as $key => $cart_item) {

	      if( isset( $cart_item["subscription_product"] ) && isset( $cart_item["subscription_items"] ) ) {

	        foreach ($cart_item["subscription_items"] as $k => $subscriptionData) {

	            $subscription_product = 1;

	            $product_id = $subscriptionData['product_id'];

	            $variation_id = $subscriptionData['variation_id'];

	            $variation_obj = new WC_Product_Variation($variation_id);

	            $stock = $variation_obj->get_stock_quantity();
	 
	            if($stock > 0 && !empty($stock)){ 
	 
	            }else{
	              $stockError = 1;
	               break;
	            }           
	        }

	      }
	      if(!empty($stockError)){
	         break;
	      }

	    }
	    if(!empty($stockError)){

	        wc_add_notice( 'Sorry, trail product is out of stock, Please choose a diffrent combination <a href="'.site_url().'/proevepakke" class="wc-backward">Return to trail product</a>', 'error' );
	    }  
	}

	public function addTrailProductAddItemANDShipping( $order ){

	  $total = $order->get_total();

	  $subscription_product = '';

	  foreach (wc()->cart->get_cart() as $key => $cart_item) {

	      if( isset( $cart_item["subscription_product"] ) && isset( $cart_item["subscription_items"] ) ) {
	         
	          foreach ($cart_item["subscription_items"] as $k => $item) {

	            if(array_key_exists('trial-product', $item)){

	              $subscription_product = 1;
	              $product_id = $item['product_id'];
	              $variationID = $item['variation_id'];
	              $variation = $item['variation'];
	              $variationsArray=array();
	              $variationsArray['variation'] = $variation;
	              $varProduct = new WC_Product_Variation($variationID);
	              $price = 0.00;
	              //change product price
	              $varProduct->set_price($price);
	              //add product in order
	              $order->add_product($varProduct, 1);                  
	              break;
	            }

	          }

	        update_post_meta($order_id,'subscription_items', $cart_item["subscription_items"]);
	        update_post_meta($order_id,'subscription_variation', $cart_item["subscription_variation"]);

	      } 
	  } 
	  //$order->calculate_totals();
	}


	public function addMoreTrailProductInToSubscriptionItemCallback( $subscription, $order, $recurring_cart ){

	  $subscription_product = ''; 

	  foreach (wc()->cart->get_cart() as $key => $cart_item) {

	      if( isset( $cart_item["subscription_product"] ) && isset( $cart_item["subscription_items"] ) ) {

	          $subscription->remove_order_items();

	          $subscription_product = 1;
	          $cart_key = $key;
	          $variations = $cart_item["subscription_variation"];

	          foreach ($cart_item["subscription_items"] as $k => $item) {
	            if(array_key_exists('trial-product', $item)){

	               $product_id = $item['product_id'];
	               $variationID = $item['variation_id'];
	               $variation = $item['variation'];
	               $quantity = 2;//$item['quantity'];

	               $variationsArray=array();
	               $variationsArray['variation'] = $variation;
	               $varProduct = new WC_Product_Variation($variationID);
	               $price = '94.5';
	               $product_name = $this->product_tittle_name_change($product_id, $variations );
	               //change product price
	                $varProduct->set_price($price);
	                //channge product name
	                $varProduct->set_name( $product_name );

	               $subscription->add_product($varProduct, $quantity, $variationsArray);

	               $this->quantity_decrease($variationID, $quantity);
	            }
	          }
	          $cost = 0;
	          
	          $shipping = (object)array(
	                  'name'      => 'Levering',
	                  'amount'     => number_format(($cost),2),
	                  'tax' => 0,
	              );            
	         // $subscription->remove_all_fees($shipping); 
	          $subscription->add_fee($shipping); 

	          //update meta 
	          update_post_meta($subscription->id,'subscription_items', $cart_item["subscription_items"]);
	          update_post_meta($subscription->id,'subscription_variation', $cart_item["subscription_variation"]);
	          update_post_meta($subscription->id, 'user_cancel', 'no');
	          //get parent order id
	          $order_id = method_exists( $subscription, 'get_parent_id' ) ? $subscription->get_parent_id() : $subscription->order->id;
	          $next_payment = get_post_meta( $subscription->id, '_schedule_next_payment', true );
	          update_post_meta($order_id,'subscription_next_payment', $next_payment);
	          break;
	      }
	  }
	  if(!empty($subscription_product)){
	     
	      $user_id = intval(get_post_meta( $subscription->id, '_customer_user', true ));
	    
	       $args = array('user_id'=> $user_id, 'cart_key'=> $cart_key);
	      // unset action schedule
	       wc_unschedule_action( 'remove_trail_product_and_manage_stock', $args);

	       //update_user_meta( $user_id, 'active_trail', 0);

	       $subscription->calculate_totals();

	  }

	}

   //move code to 
	public function addTrailProductInToOrderItemCallback($order_id){

	      $order = new WC_Order( $order_id );      
	      $subscription_product = '';
	      foreach (wc()->cart->get_cart() as $key => $value) {
	          if( isset( $value["subscription_product"] ) && isset( $value["subscription_items"] ) ) {
	              $variations = $value["subscription_variation"];
	              foreach ($value["subscription_items"] as $k => $ArrayData) {
	                if(array_key_exists('trial-product', $ArrayData)){

	                  $subscription_product = 1;
	                  $product_id = $ArrayData['product_id'];
	                  $variationID = $ArrayData['variation_id'];
	                  $variation = $ArrayData['variation'];
	                  $variationsArray=array();
	                  $variationsArray['variation'] = $variation;
	                  $varProduct = new WC_Product_Variation($variationID);
	                  $price = 0.00;

	                  $product_name = $this->product_tittle_name_change($product_id, $variations );
	                 //change product price
	                  $varProduct->set_price($price);
	                  //channge product name
	                  $varProduct->set_name( $product_name );
	 
	                  $order->add_product($varProduct, 1, $variationsArray);
	                  $cost = 39;
	                  $shipping = (object)array(
	                          'name'      => 'Shipping Charges',
	                          'amount'     => number_format(($cost),2),
	                          'tax' => 0,
	                      );
	              
	                 $order->add_fee($shipping);  
	                 $order->calculate_totals();
	                 $this->quantity_increase($variationID, 1);
	                  break;
	                }
	              }
	            update_post_meta($order_id,'subscription_items', $value["subscription_items"]);
	            update_post_meta($order_id,'subscription_variation', $value["subscription_variation"]);
	          }
	      }   
	}

}

new ProductCategory();