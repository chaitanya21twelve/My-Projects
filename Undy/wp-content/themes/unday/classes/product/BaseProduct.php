<?php
/**
 * BaseProduct
 *
 * The BaseProduct Class.
 *
 * @class    BaseProduct
 * @category Class
 * @author   Codingkart
 */  
class BaseProduct
{

 /**
   * Constructor for the BaseProduct class
   *
   * Sets up all the appropriate hooks and actions
   * 
   */

	public function __construct(){

		add_action('admin_menu',array($this,'create_admin_menu'));

		add_action('wp_ajax_get_product_stock_details',array($this,'get_product_stock_details'));

		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

		add_filter( 'woocommerce_checkout_fields' , array($this,'custom_override_checkout_fields') );

		add_action('woocommerce_checkout_process',array($this,'validate_fields_on_checkout'));

 	}

 	public function get_month(){

 		$months = array(
	   	              'January' => 'januar',
	   	              'February' => 'februar',
	   	              'March' => 'marts',
	   	              'April' => 'april',
	   	              'May' => 'maj',
	   	              'June' => 'juni',
	   	              'July' => 'juli',
	   	              'August' => 'august',
	   	              'September' => 'september',
	   	              'October' => 'oktober',
	   	              'November' => 'november',
	   	              'December' => 'december', 
	                   );

 		return $months;
 	}

 	public function has_active_subscription( $user_id=null ) {

	    // if the user_id is not set in function argument we get the current user ID
	    if( null == $user_id )
	        $user_id = get_current_user_id();

	    // Get all active subscrptions for a user ID
	    $active_subscriptions = get_posts( array(
	        'numberposts' => -1,
	        'meta_key'    => '_customer_user',
	        'meta_value'  => $user_id,
	        'post_type'   => 'shop_subscription', // Subscription post type
	        'post_status' => 'wc-active', // Active subscription

	    ) );
	    // if
	    if(!empty($active_subscriptions)) return $active_subscriptions;
	    else return false;
	}
   
  /**
   * Get product category object according to product main category id
   */
 	public function getProductSizeColorAttributesCategory($product_cat_id, $taxonomy_name){

 		$term = get_term($product_cat_id,'product_cat');
		if(empty($term)){
		    return false;
		}

 		$taxonomy_obj = get_terms( $taxonomy_name, array(
		    'hide_empty' => true,
		) );

		foreach($taxonomy_obj as $s=>$value){
			$mypost = array(
			  'post_type' => 'product',
			  'posts_per_page'=>-1,
			  'tax_query' => array(
			    'relation' => 'AND',
			    array(
			      'taxonomy' => 'product_cat',
			      'field'    => 'term_id',
			      'terms'    => array($product_cat_id),
			    ),
			    array(
			      'taxonomy' => $taxonomy_name,
			      'field'    => 'term_id',
			      'terms'    => array($value->term_id),
			    )
			  ),
			 'meta_query' => array(
			    array(
			      'key' => '_stock_status',
			      'value' => 'instock',
			      'compare' => '=',
			    )
			  )      
			);
			$loop = new WP_Query( $mypost );
			if($loop->found_posts > 0){
			  
			}else{
			  unset($taxonomy_obj[$s]);
			}
			wp_reset_query();
		}

		return $taxonomy_obj;
        // end 
 	}

   /*
    * increase a product's stock .
    */
 	public function quantity_increase($product_id, $qty, $type=''){

 		if(!empty($type)){
 			$product = wc_get_product( $product_id );
 		}else{
 			$product = new WC_Product_Variation( $product_id );
 		} 		 		 
	    $totalQty = wc_update_product_stock( $product, $qty, 'increase' );
	    return $totalQty;
 	}	

   /*
    * decrease a product's stock .
    */
 	public function quantity_decrease($product_id, $qty, $type=''){

 		if(!empty($type)){
 			$product = wc_get_product( $product_id );
 		}else{
 			$product = new WC_Product_Variation( $product_id );
 		} 		 
 	    $totalQty = wc_update_product_stock( $product, $qty, 'decrease' );
	    return $totalQty;
 	}

 	public function userLogin($user_email, $password){

 		$login_email = $user_email;

        $login_upass = $password;

        wp_cache_delete($user_exist->ID, 'users');

        $creds = array();

        $user= get_user_by('email',$login_email);    
        
        $creds['user_login']    = $user->user_login;

        $creds['user_password'] = $login_upass;

        $user_in = wp_signon( $creds, false );


        if ( !is_wp_error($user_in) ){

          $user_id = $user_in->ID; 

          wp_set_current_user( $user->ID, $user->user_login);

          wp_set_auth_cookie( $user->ID);

          do_action( 'wp_login', $user->user_login );

          return 2; 

        }else{

          return 3;

        }  
 	}

 	public function userRegister($user_data=array()){

 	}

	public function getProductAccordingToCategory($category_id, $color_cate_id='', $size_slug, $product_id='', $limit=0){

		if(is_array($product_id)){
			$products_data = $product_id;
		}else{
			$products_data = array($product_id);
		} 
 
		$mypost = array(
		
		'post_type' => 'product',
		'posts_per_page'=>-1,
 		'post__not_in' => $products_data,
		'tax_query' => array(
		  'relation' => 'AND',
		  array(
		    'taxonomy' => 'product_cat',
		    'field'    => 'term_id',
		    'terms'    => array($category_id),
		  ) 
		),
		'meta_query' => array(
		  array(
		    'key' => '_stock_status',
		    'value' => 'instock',
		    'compare' => '=',
		  ),
		) 

		);

		if(!empty($color_cate_id)){

			$color_data = array(
			    'taxonomy' => 'color-category',
			    'field'    => 'term_id',
			    'terms'    => array($color_cate_id),
			  );
			$mypost['tax_query'][] = $color_data;
 		
		}
 
		$loop = new WP_Query( $mypost );
 
		$allProductArray = array();
		$postCount = 1;

		$count = $loop->post_count; 

		while ( $loop->have_posts() ) : $loop->the_post();
		  
		  global $product;
		  $product_variable = new WC_Product_Variable($product->get_id());
		  $product_variations = $product_variable->get_available_variations();
		 
 		  $displayProduct = true;
          
		  $allAvailableVariations = array();
		  
		  $variation_id = '';
		  $price = 0;
		  foreach($product_variations as $product_variation){


		    if($product_variation['attributes']['attribute_pa_size'] == $size_slug){

		      $variation_id = $product_variation['variation_id'];

		      $variation_obj = new WC_Product_Variation($variation_id);

		      $stock = $variation_obj->get_stock_quantity();
		      
		      $price = $product_variation['display_regular_price'];

		      $allAvailableVariations[$variation_id] = $product_variation['attributes']['attribute_pa_size'];
		     
		      if(!$product_variation['is_in_stock']){
		        $displayProduct = false;
 		      }else{
 
   		       	if($stock <= 0 || empty($stock)){ 
 		       	   $displayProduct = false; 	
                }
               }
		    }
		  }

		//print_r($allAvailableVariations);
		if(!$displayProduct){
		continue;
		}
		if(!in_array($size_slug,$allAvailableVariations)){
		continue;
		}
		if(!in_array($size_slug,$allAvailableVariations)){
		continue;
		} 
 
		if(!empty($color_cate_id)){

		    $color_term = get_term($color_cate_id, 'color-category');

		}else{

			$color_terms = get_the_terms($product->get_id(), 'color-category' );

			foreach($color_terms as $term) 
			{
				$color_term = $term;
			}
		}
		 
		if (is_array($color_term) || is_object($color_term))
		{
			$variation   = array(
		         'Size'  => $size_slug,
		         'Color' => $color_term->slug,
		      );           
	    }else{
	    	$variation   = '';
	    }

		  $item_data = array();
		  $item_data['product_id'] = get_the_ID();
		  $item_data['variation_id'] = $variation_id;
		  $item_data['size'] = $size_slug;
		  $item_data['color_id'] = $color_term->term_id;
		  $item_data['price'] = $price;
		  $item_data['quantity'] = 1;
		  $item_data['variation'] =  $variation;          
		  $allProductArray[] = $item_data;

		  if($postCount >= $limit && !empty($product_id) && $limit != 0){
		    break;
		  }else{
		    $postCount++;             
		  } 
		endwhile;

		return $allProductArray;

	}

 	public function getSubcriptionItem($subscription_id, $condition=''){

 		$subscription = wcs_get_subscription( $subscription_id );

 		$sub_color_category = get_post_meta( $subscription_id, 'sub_color_category', true );


 		$items = $subscription->get_items(); 

 		$product_list = array();
		foreach ( $items as $itemID => $item ) {

            $list =array();

		    $list['product_name'] = $item['name'];
			$list['product_id'] = $item['product_id'];
		    $list['quantity'] = $item['quantity'];
		    $list['variation_id'] = $item['variation_id'];

		    $color_slug = wc_get_order_item_meta($itemID, 'Color', true);

		    $list['color_slug'] = $color_slug;

		    if(!empty($condition)){

		    	$product_list[] = $list;

		    }else{

		       $product_list[$item['variation_id']] = $list;
		    }
 	 	}
 		return $product_list;
 	}

 	public function getSubcriptionItemsAndCategoryHtml($subscription_id, $prod_cat='', $size_slug=''){

 		//$subscription = wcs_get_subscription( $subscription_id );
        $subscription_data = get_post_meta( $subscription_id, 'subscription_variation', true );
 
        if(empty($prod_cat)){

            $prod_cat  = $subscription_data['product_cat_id'];
        }

        $color_array  = explode(',', $subscription_data['color_cat_id']);

        if(empty($size_slug)){

            $size_slug  = $subscription_data['size_slug'];
        } 

        $items = $this->getSubcriptionItem($subscription_id, 1);

		$colorCategories = get_terms( 'color-category', array(
		  'hide_empty' => true,
		) );

		$html = '';

		//$html.='<h3 class="text-center">3. Vælg design</h3>';

		foreach($colorCategories as $s=>$colorCategory){

		 $mypost = array(
		        'post_type' => 'product',
		        'posts_per_page'=>-1,
		        'tax_query' => array(
		          'relation' => 'AND',
		          array(
		            'taxonomy' => 'product_cat',
		            'field'    => 'term_id',
		            'terms'    => array($prod_cat),
		          ),
		          /*array(
		            'taxonomy' => 'size-category',
		            'field'    => 'term_id',
		            'terms'    => array($prod_size),
		          ),*/
		          array(
		            'taxonomy' => 'color-category',
		            'field'    => 'term_id',
		            'terms'    => array($colorCategory->term_id),
		          )
		        ),
		       'meta_query' => array(
		          array(
		            'key' => '_stock_status',
		            'value' => 'instock',
		            'compare' => '=',
		          ),
		        
		        )      
		      );
            $loop = new WP_Query( $mypost );

			$html.='<div class="col-md-6">';

			$html.='<h3 class="text-center">'.$colorCategory->name.'</h3>';

			if($loop->found_posts > 0){

			$totalDisplay = 0;
			$i = 1; 

			while ( $loop->have_posts() ) : $loop->the_post();

			  global $product;

			  $product_variable = new WC_Product_Variable($product->get_id());

			  $product_variations = $product_variable->get_available_variations();

			  //print_r($product_variations);
			  $displayProduct = true;

			  $allAvailableVariations = array();
			  $variation_id = '';

			  foreach($product_variations as $product_variation){

			    $allAvailableVariations[$product_variation['variation_id']] = $product_variation['attributes']['attribute_pa_size'];
			    
			    if($product_variation['attributes']['attribute_pa_size'] == $size_slug){

			      $variation_id = $product_variation['variation_id'];

			      if(!$product_variation['is_in_stock']){

			        $displayProduct = false;

			      }else{

			        $totalDisplay++;

			      }

			    }

			  }

			  //print_r($allAvailableVariations);

			  if(!$displayProduct){
 			    continue;
 			  }
			  if(!in_array($size_slug,$allAvailableVariations)){

			    continue;

			  }
			  
			$image = get_the_post_thumbnail_url(get_the_ID(),'full');
			$qtyhtml = '';
			$sub_qty = 0;

			foreach ($items as $key => $itemArray) {

				//if($variation_id == $itemArray['variation_id'] && in_array($colorCategory->term_id, $color_array) && $colorCategory->slug == $itemArray['color_slug']){

				if($variation_id == $itemArray['variation_id'] ){
 					$sub_qty = $itemArray['quantity'];
				}
			}


			if($sub_qty > 0){

                $qtyhtml = '<input type="text" id="quantity_'.$variation_id.'"  name="product_main['.$colorCategory->term_id.']['.$variation_id.']" class="form-control input-number color_cat_'.$colorCategory->term_id.'" value="'.$sub_qty.'" min="1" max="100">';
			}else{

				$qtyhtml = '<input type="text" id="quantity_'.$variation_id.'"  name="product_main['.$colorCategory->term_id.']['.$variation_id.']" class="form-control input-number color_cat_'.$colorCategory->term_id.' tick" value="0" min="1" max="100">';
			}

			$color_name =  get_post_meta( get_the_ID(), 'wpcf-product-color-title', true);
 
			$html.='<div class="item-box">'.$qtyhtml.'<img src="'.get_bloginfo('template_url').'/images/tick.png" class="tick" /><img src="'.$image.'" alt="" style="width:173px; height:132px;" title="'.get_the_title().'"><p class="item-tittle" style="margin-top: -15px;">'.$color_name.'</p><div class="quantity_box"><button type="button" data-color-id="'.$colorCategory->term_id.'" data-variation_id="'.$variation_id.'" class="quantity-right-plus btn-number" data-type="plus" data-field="">+</button><button type="button" data-color-id="'.$colorCategory->term_id.'" data-variation_id="'.$variation_id.'" class="quantity-left-minus btn-number"  data-type="minus" data-field="">-</button></div></div>';

			endwhile;

			if($totalDisplay == 0){

			  $html.='<p class="text-center">No Products Found</p>';

			}

			}else{

			$html.='<p class="text-center">No Products Found</p>';

			}

		    wp_reset_query();

		    $html.='</div>';

        }

       
        //$html .='<div class="form-btn text-center" style="padding-top: 55px;"> <button style="width: 37%;"  id="product_update" class="button" type="submit">Opdater</button></div>';
 
        return $html;
   
 	}

 	public function product_tittle_name_change($product_id, $variation){

 		$new_name = '';

 		$product_name = get_the_title( $product_id );

 		if(!empty($product_name)){

 			$new_name .= '<div>'.$product_name.'</div><small>';
 		}

 		$cat_term = get_term($variation['product_cat_id'],'product_cat');

 		if(!empty($cat_term)){

 			$cat_name = $cat_term->name;

 			$new_name .= $cat_name;
 		}

 		if(!empty($variation['size_slug'])){

 			$size_name = $variation['size_slug'];

 			$new_name .= ' ,'.$size_name;
 		}

 		$color_name =  get_post_meta($product_id, 'wpcf-product-color-title', true);

 		if(!empty($color_name)){
 			 
 			$new_name .= ' ,'.$color_name;
 		} 

 		$new_name .= '</small>';

 		return $new_name;
 	}


 	public function create_admin_menu() {

	add_menu_page( 'check_product_stock','Product Stock','manage_options','check-product-stock',array($this,'check_product_stock'),'',30);
	}


 	public function check_product_stock() {

	    echo '<h3>Check Product Stock</h3>';

	    $args = array(
	        'post_type'      => 'product',
	        'posts_per_page' => -1
	    );

	    $loop = new WP_Query( $args ); 

	    echo '<select id="product_dropdown" name="product_dropdown"><option value="">Select Product</option>';

	    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;

        $type = $product->get_type();

        if( $type == 'variable' )
        {
        	echo '<option value="'.$product->get_id().'">'.$product->get_name().'</option>';
        }

        endwhile;

        wp_reset_query();

        echo '<select name="product_dropdown"><div class="loader_div"><div class="loader"></div></div></br><div id="product_details"></div>';
        ?>
        <script type="text/javascript">
        	jQuery(document).ready(function(){
        		jQuery('#product_dropdown').change(function() {
        			jQuery('#product_details').html('');
        			var product_id = jQuery(this).val();
        			var baseUrl = document.location.origin;
        			var ajax_url = baseUrl+'/wp-admin/admin-ajax.php';
        			var final_data = 'action=get_product_stock_details&product_id='+product_id;

        			jQuery.ajax({
        				type:'post',
        				url: ajax_url,
        				dataType: 'json',
        				data: final_data,
        				beforeSend:function(){
        					jQuery('.loader_div').show();
        				},
        				success:function(res){
        					if(res.status == 'success')
        					{
        						jQuery('#product_details').html(res.html);
        					}
        					jQuery('.loader_div').hide();
        				}

        			})

        		})
        	});
        </script>
        <style type="text/css">
	    	.customer_list table, .customer_list th, .customer_list td {
	    		border: 1px solid black
	    	}
	    	#product_details {
	    	    margin: 20px 0 0 0;
	    	}

            /* loader css */
            .loader {

			   border: 3px solid #f3f3f3;

			   border-radius: 50%;

			   border-top: 3px solid #ff6600;

			   width: 20px;

			   height: 20px;

			   -webkit-animation: spin 2s linear infinite;

			   animation: spin 2s linear infinite;

			   display: inline-block;

			   top: 50%;

			   position: relative;

			}
			.loader_div {
			    display: none;
			    position: absolute;
			    top: 20.1%;
			    left: 30%;
			}

			/* Safari  */

			@-webkit-keyframes spin {

			  0% { -webkit-transform: rotate(0deg); }

			  100% { -webkit-transform: rotate(360deg); }

			}



			@keyframes spin {

			  0% { transform: rotate(0deg); }

			  100% { transform: rotate(360deg); }

			}
			/* loader css */
	    </style>
        <?php
    }



    public function get_product_stock_details() {

    	$p_id = $_POST['product_id']; $html = '';$response = array();

    	if( !empty($p_id) )
    	{

	    	$productStock = $allcustomers = array();
	    	// Get all customer orders
		    $subscriptions = get_posts( array(
		        'numberposts' => -1,
		        'post_type'   => 'shop_subscription', // Subscription post type
		        'post_status' => array('wc-active'), // Active subscription
		        'orderby' => 'post_date', // ordered by date
		        'order' => 'DESC',

		    ) );

	        $html .= '<table class="customer_list"><tr><th>No</th><th>customer Email</th><th>Color</th><th>Size</th><th>product qty</th></tr>';

		    $i = 1; $size_array = array();

	  		foreach ( $subscriptions as $subscription ) {
		    	$subscription_id = $subscription->ID;
		    	$subscr_meta_data = get_post_meta($subscription->ID);
		    	$customer_id = $subscr_meta_data['_customer_user'][0];

		    	$subscription = wcs_get_subscription( $subscription_id );

		    	$items = $subscription->get_items();   

		    	foreach ( $items as $itemID => $item ) {

		            $product_id = $item['product_id'];
		            $quantity = $item['quantity'];
		            $variation_id = $item['variation_id'];

		            if( $p_id == $product_id)
		            {
			            $color = wc_get_order_item_meta($itemID, 'Color', true);
			            $size = wc_get_order_item_meta($itemID, 'Size', true);

			           	if( empty($size) )
			            {
			            	$size = wc_get_order_item_meta($itemID, 'pa_size', true);
			            }

			            if(array_key_exists($size,$size_array))
			            {
			            	$previous_qty = $size_array[$size];

			            	$size_array[$size] = $quantity+$previous_qty;
			            }
			            else{

			            	$size_array[$size] = $quantity;
			            }


			           	$total_qty = $quantity+$productStock[$product_id];
			            $productStock[$product_id] = $total_qty;

			            $user = get_user_by( 'id', $customer_id);
		    			$user_email = $user->user_email;

		           		$html .= '<tr><td>'.$i.'</td><td>'.$user_email.'</td><td>'.$color.'</td><td>'.$size.'</td><td>'.$quantity.'</td></tr>';

		           		array_push($allcustomers, $customer_id);

		           		$i++;
		            }
		    	
		    	}

		    }

		    $html .=  '<table></br>';

		    foreach ($size_array as $key => $value) {
		    	 $html .= '<b>'.ucwords($key).'</b> : '.$value.'</br>';
		    }

		    if( empty($total_qty) )
		    {
		    	$total_qty = 0;
		    }

		    $html .= '</br><b>Total Customers:</b> '.count($allcustomers).'</br>';
		    $html .= '<b>Total Quantity:</b> '.$total_qty;
		}

		$response['status'] = 'success';
		$response['html'] = $html;

		echo json_encode($response);
		die;
    }


    public function custom_override_checkout_fields($fields) {

    	foreach ( WC()->cart->get_cart() as $cart_item ) {
    		$product_id = $cart_item['product_id']; 
    		$product = wc_get_product($product_id);
    		if( $product->get_type() !='subscription' )
    		{
    			$fields['account']['account_password']['required'] = false;
				break;
    		}
	    }
	    return $fields;
    }


    public function validate_fields_on_checkout() {

    	$new_payment  = $_POST['wc-stripe-new-payment-method'];

    	$password = $_POST['account_password'];
    	
    	foreach ( WC()->cart->get_cart() as $cart_item ) {
    		$product_id = $cart_item['product_id']; 
    		$product = wc_get_product($product_id);
    		if( $product->get_type() !='subscription' && 'true' != $new_payment && empty($password) )
    		{
    			unset($_POST['createaccount']);
				break;
    		}
	    }
    }

}

new BaseProduct();