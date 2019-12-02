<?php
/**
 * ProductAjax
 *
 * The ProductAjax Class.
 *
 * @class    ProductAjax
 * @parent BaseProduct
 * @category Class
 * @author   Codingkart
 */  
class ProductAjax extends BaseProduct 
{	
 /**
   * ProductAjax for the ProductAjax class
   * Sets up all the appropriate hooks and actions
   * 
   */ 
	public function __construct(){
      
        // get size category html ajax
        add_action( "wp_ajax_nopriv_getAvailableSizesHtml", array( $this, "getAvailableSizesHtml" ));
        add_action( "wp_ajax_getAvailableSizesHtml", array( $this, "getAvailableSizesHtml" )); 

        // get product by category id
        add_action( "wp_ajax_nopriv_getProductByCategoryId", array( $this, "getProductByCategoryId" ) );
        add_action( "wp_ajax_getProductByCategoryId", array( $this,"getProductByCategoryId" ) );

        // add to cart
        add_action( "wp_ajax_nopriv_trailProductAddToCart", array( $this, "trailProductAddToCart" ) );
        add_action( "wp_ajax_trailProductAddToCart", array( $this,"trailProductAddToCart" ) ); 
 
        // get size category html ajax
        add_action( "wp_ajax_get_subscription_detail", array( $this, "getSubcriptionDetail_Callback" )); 

        add_action( "wp_ajax_getItemList", array( $this, "getSubcriptionItemList" )); 

        add_action( "wp_ajax_update_subscription_details", array( $this, "update_trail_subscription_items" )); 

        add_action( "wp_ajax_change_subscription_status", array( $this, "change_subscription_status" )); 
 

  }



  public function change_subscription_status(){

    $response = array();

    $hold_key = 'no';

    $subscription_id = $_POST['subscription_id'];

    $user_cancel = get_post_meta($subscription_id, 'user_cancel', true);

    $user_id = get_post_meta( $subscription_id, '_customer_user', true );

    $status = $_POST['status'];

    if(!empty($status) || !empty($subscription_id)){

        $subscription = wcs_get_subscription( $subscription_id );

        $subscription_status = $subscription->get_status();  

        $allow_status = array('active', 'on-hold'); 

        if(in_array($subscription_status, $allow_status)){

        if($status == 1 && $user_cancel != 'yes'){

          $post_status = 'active';

        }else if($status == 2 && $user_cancel != 'yes'){

          $post_status = 'on-hold';

          $hold_key = 'yes';

        }elseif($status == 3 && $user_cancel != 'yes'){

          $post_status = 'on-hold'; 

          $hold_key = 'yes';     

          $items = $subscription->get_items(); 

          foreach ( $items as $itemID => $item ) {

            $product_name = $item['name'];
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $variation_id = $item['variation_id'];

            $this->quantity_increase($variation_id, $quantity);
          }
          update_post_meta($subscription_id, 'user_cancel', 'yes');

          $cancel_reason = $_POST['cancel_reason'];

          $cancel_comment = $_POST['cancel_comment'];

          $subscription->add_order_note(sprintf(__('(Cancel Reason: '.$cancel_reason.') (Cancel Comment: '.$cancel_comment.')'), $user_id));

        }elseif($status == 4 && $user_cancel == 'yes'){

          $post_status = 'active';

          $items = $subscription->get_items(); 

          foreach ( $items as $itemID => $item ) {

            $product_name = $item['name'];
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $variation_id = $item['variation_id'];

            $this->quantity_decrease($variation_id, $quantity);
          }
          update_post_meta($subscription_id, 'user_cancel', 'no');

        }else{ 

          $response['status'] = '0';
          echo json_encode($response); die;

        }

        $subscription->update_status( $post_status );
        update_post_meta($subscription_id, 'sub_hold_key', $hold_key);  
        $response['status'] = '1';
        echo json_encode($response); die; 

      }else{

        $response['status'] = '0';

        echo json_encode($response); die; 

      }

    }else{

      $response['status'] = '0';

      echo json_encode($response); die;

    } 

  }


  public function getAvailableSizesHtml(){

      $prod_cat = $_POST['prod_cat'];

      if(empty($prod_cat)){

        echo "empty";

      }
      $term = get_term($prod_cat,'product_cat');

      if(empty($term)){

        echo "invalid";

      }

      $taxonomy_obj = get_terms( 'size-category', array(
        'hide_empty' => true,
        'orderby'           => 'term_id', 
        'order'             => 'ASC',
      ) );

      //$taxonomy_obj = $this->getProductSizeColorAttributesCategory($prod_cat, 'size-category');

      // if(empty($taxonomy_obj)){
      //   //"noresult"; exit;
      // }

      $html = '<div class="row selection-2">
          <h3 class="text-center">2. Vælg størrelse</h3>
          <p class="text-center icon-plus-sign" style="text-decoration: underline;">Størrelsesguide</p>
          <div class="col-md-12 wrapper">';

      if(!empty($taxonomy_obj)){

        foreach($taxonomy_obj as $size){  

            $html.= '<div class="item-box"> <img src="'.get_bloginfo('template_url').'/images/tick.png" class="tick" />
                  <h1 class="text-center">'.$size->name.'</h1>
            <div style="display:none">
              <input type="radio" name="product_size" class="product_size" value="'.$size->term_id.'" />
            </div>
                </div>';

        }  

      }else{

            $html.= '<p style="color:red;"> No Product Size available this category..... </p>';
      } 
       
      $html.= '</div></div>';

      echo $html; exit();

  } 

  public function getProductByCategoryId( ) {

    $prod_cat = $_POST['prod_cat'];

    if(empty($prod_cat)){

      echo "empty";

    }

    $prod_size = $_POST['product_size'];

    if(empty($prod_size)){

      echo "empty";

    }

    $cat = get_term($prod_cat,'product_cat');

    if(empty($cat)){

      echo "invalid";

    }

    $size = get_term($prod_size,'size-category');


    if(empty($size)){

      echo "invalid";

    }

    $colorCategories = get_terms( 'color-category', array(
      'hide_empty' => true,
    ) );
    $html = '';

    $html.='<div class="row selection-3"><h3 class="text-center">3. Vælg design</h3>';

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
            if($product_variation['attributes']['attribute_pa_size'] == $size->slug){

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
          if(!in_array($size->slug,$allAvailableVariations)){

            continue;

          }
          
          $image = get_the_post_thumbnail_url(get_the_ID(),'full');

          $color_name =  get_post_meta(get_the_ID(), 'wpcf-product-color-title', true);

          $html.='<div class="item-box"><img src="'.get_bloginfo('template_url').'/images/tick.png" class="tick" /><img src="'.$image.'" alt="" style="width:173px; height:132px;" title="'.get_the_title().'"><p class="item-tittle">'.$color_name.'</p> <div style="display:none">
          <input type="checkbox" name="product_main[]" class="product_main" data-variation_id="'.$variation_id.'" value="'.get_the_ID().'" /> 
          <input type="hidden" name="variation_id_'.get_the_ID().'" value="'.$variation_id.'" />
          <input type="hidden" name="color_category_id_'.get_the_ID().'" value="'.$colorCategory->term_id.'" />
        </div></div>';

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

    $html.='</div>';

    echo $html; exit();

  } 

   

  public function trailProductAddToCart(){

  		global $woocommerce;    

  		$woocommerce->cart->empty_cart(); 

  		$product_cat = $_POST['product_cat'];   

  		foreach($_POST['product_main'] as $productId){

  		  $product_id   = $productId;

  		  $variation_id   = $_POST['variation_id_'.$product_id];

  		  $color_category_id   = $_POST['color_category_id_'.$product_id];

  		  //$size = get_term($_POST['product_size'],'pa_size');

  		  $product_variable = new WC_Product_Variable($product_id);

  		  $product_variations = $product_variable->get_available_variations();

  		  $displayProduct = true;

  		  $size_name = '';

  		  $allAvailableVariations = array();

  		  foreach($product_variations as $product_variation){

  		    if($variation_id == $product_variation['variation_id']){

  		      $variationId = $product_variation['variation_id'];

  		      $size_name = $product_variation['attributes']['attribute_pa_size'];

  		      $price = $product_variation['display_regular_price'];

  		    }
  		  } 

  		  $colorterm = get_term($color_category_id,'color-category');

  		  $variation    = array(
  		     'Size'  => $size_name,
  		     'Color' => $colorterm->slug,
  		  );

  		  $subscription_variation    = array(
  		     'product_cat_id'  => $product_cat,
  		     'color_cat_id'  => $color_category_id,
  		     'size_slug'  => $size_name,
  		  );

  		  $quantity = 1;
  		  $trail_product_id = 557;

  		  $cart_item_data = array();
   		  $item_data = array();

  		  $item = array();
  		  $item['product_id'] = $product_id;
  		  $item['variation_id'] = $variationId;
  		  $item['size'] = $size_name;
  		  $item['price'] = $price;
  		  $item['quantity'] = 1;
  		  $item['trial-product'] = 1;
  		  $item['variation'] = $variation;

        $item_data = $this->getProductAccordingToCategory($product_cat, $color_category_id, $size_name, $product_id, 2);

        if(count($item_data) < 2){
          
            if(count($item_data) == 1){
              $add_item_data = $this->getProductAccordingToCategory($product_cat, '', $size_name, $product_id, 1);
              $item_data = array_merge($item_data, $add_item_data);
            }else{
              $item_data = $this->getProductAccordingToCategory($product_cat, '', $size_name, $product_id, 2);
            }
        }       
 
        foreach ($item_data as $key => $color_data) {
          $color_id = $color_data['color_id'];
          if($subscription_variation['color_cat_id'] != $color_id){
            $add_color =  $subscription_variation['color_cat_id'].','.$color_id;
            $subscription_variation['color_cat_id'] = $add_color;
          }
        }

        $item_data[] = $item;  
        // add extra data
        $cart_item_data['subscription_product'] = 1; 
        $cart_item_data['subscription_variation'] = $subscription_variation;    
        $cart_item_data['subscription_items'] = $item_data;   

   		  $cart_item_data['subscription_items'] = $item_data;          

  		  $cart_key = $woocommerce->cart->add_to_cart( $trail_product_id, $quantity,'','', $cart_item_data );
        
  		} 

       if(isset($_POST['coupon_code']) && !empty($_POST['coupon_code']) ){
         $coupon_code = $_POST['coupon_code'];
         if (!$woocommerce->cart->has_discount( $coupon_code ) ){
             $woocommerce->cart->add_discount( $coupon_code );
         }
      }  
      echo 1; exit();
  
  }

  public function getSubcriptionDetail_Callback(){

	    $subscription_id = $_POST['subscription_id']; 

	    $response = array();

        if(!empty($subscription_id)){

          if(!empty(get_post_meta( $subscription_id, '_schedule_next_payment', true ))){
           
            $months = $this->get_month();

            $date = get_post_meta( $subscription_id, '_schedule_next_payment', true );

            $month = date('F', strtotime($date));

            $schedule_next =  date('j. ', strtotime($date)) . $months[$month] . date(' Y', strtotime($date));

          }else{

            $schedule_next = '';

          }                   

          $subscription_vari = get_post_meta( $subscription_id, 'subscription_variation', true );
           
          if(!empty($subscription_vari)){

             $term = get_term($subscription_vari['product_cat_id'],'product_cat');

             if(!empty($subscription_vari)){

                  $cat_name = $term->name;

                  $cat_id = $term->term_id;

              }else{

                $cat_name = 'No Category';
              }

             if(!empty($subscription_vari['color_cat_id'])){ 

                $color_array = explode(',', $subscription_vari['color_cat_id']);
                $i = 0; 
                $color_name = '';
                foreach ($color_array as $key => $ids) {
                  if($i>0){
                      $color_name .=', ';
                    }
                    $color = get_term($ids,'color-category');
                    $color_name .= $color->name;
                    $i++;
                }
              }else{

                $color_name = 'No Color';
              }

              if($subscription_vari['size_slug'] == 's'){
                $size_name = 'Small';
              }else if($subscription_vari['size_slug'] == 'm'){
                $size_name = 'Medium';
              }else if($subscription_vari['size_slug'] == 'l'){
                $size_name = 'Large';
              }else if($subscription_vari['size_slug'] == 'xl'){
                $size_name = 'Extra Large';
              }else if($subscription_vari['size_slug'] == 'xxl'){
                $size_name = 'Double Extra Large';
              }else{
                $size_name = 'No Size';
              } 

              $subscription = wcs_get_subscription( $subscription_id );

              $user_cancel = get_post_meta($subscription_id, 'user_cancel', true);

              $post_status = $subscription->get_status();   

              if($post_status == 'active'){

                $show_status = 'Aktivt';
                $action = '2';
                $buttton = 'Sæt i bero';

              }else if($post_status == 'on-hold'){  

                if($user_cancel != 'yes'){

                  $show_status = 'Sat i bero';
                  $action = '1';
                  $buttton = 'Aktiver her';
                  $schedule_next = '';

                }else{

                  $show_status = 'Annulleret'; 
                  $action = '4';
                  $buttton = 'Annulleret'; 
                  $schedule_next = '';

                }

              }else if($post_status == 'cancelled'){

                  $show_status = 'Annulleret'; 
                  $action = '3';
                  $buttton = 'Annulleret';
                  $schedule_next = '';

              }else{

                  $show_status = 'Annulleret'; 
                  $action = '3';
                  $buttton = 'Annulleret';
                  $schedule_next = '';

              } 

              $response['status'] = '1';
              $response['cat_name'] = $cat_name;
              $response['cat_id'] = $cat_id;
              $response['color_name'] = $color_name;
              $response['size_name'] = $size_name;
              $response['size_slug'] = $subscription_vari['size_slug'];
              $response['sub_status'] = $show_status;
              $response['sub_action'] = $action;
              $response['button_text'] = $buttton;
              $response['payment_date'] = $schedule_next;
              //$response['color_id'] = $subscription_vari['color_cat_id'];
               $productHtml = $this->getSubcriptionItemsAndCategoryHtml($subscription_id);
               $response['item_list'] = $productHtml;

        }else{

          $response['status'] = '0';
        }

      }else{
        $response['status'] = '0';
      }

       echo json_encode($response); die;
  
  }

  public function getSubcriptionItemList(){
    
    $subscription_id = $_POST['subscription_id'];

    $size_id = $_POST['size_id'];

    $product_cat = $_POST['product_cat'];

    $response = array();

    $size_term = get_term($size_id,'size-category');

    $productHtml = $this->getSubcriptionItemsAndCategoryHtml($subscription_id, $product_cat, $size_term->slug);

    if(!empty($productHtml)){

      $response['status'] = '1';

      $response['item_list'] = $productHtml;

    }else{
        $response['status'] = '0';
    }

    echo json_encode($response); die;
  
   }

  
  public function update_trail_subscription_items(){

    $response = array();
  
    $subscription_id = $_POST['subcrition_array'];

    $product_cat = $_POST['product_cat'];

    //$color_cat_id = $_POST['color_cat_id'];

    $product_size = $_POST['product_size'];

    $product_list = $_POST['product_main'];

    $cat_product_list = array();

    $subscription = wcs_get_subscription( $subscription_id );

    $post_status = $subscription->get_status();  

    $allow_status = array('active', 'on-hold'); 

    if(in_array($post_status, $allow_status))
    {

      foreach ($product_list as $key => $value) {

          $productData = array_filter($value); 
          if(!empty( $productData )){

            $cat_product_list[$key] = $productData;

            }
      }

      $getItme = $this->getSubcriptionItem($subscription_id);

      $error_title = '';
      // check product stock
      // foreach ($cat_product_list as $key => $producArray) {

      //    foreach ($producArray as $variation_id => $qty) {

      //       $variation_obj = new WC_Product_Variation($variation_id);

      //       $stock = $variation_obj->get_stock_quantity();

      //       if( $qty > $stock && !array_key_exists( $variation_id, $getItme ) ){

      //           $error_title = $variation_obj->get_title();

      //           break;
      //       }
      //    }

      //     if(!empty($error_title)){
      //       break;
      //     }

      // }
       
       //error check
    if(!empty($error_title)){

        $msg = '<div class="alert alert-danger error"><strong>Error</strong> No quantity available on '.$error_title.'.</div>';

        $response['status'] = '0';

        $response['msg'] = $msg;

        echo json_encode($response); die; 

      }

      $color_cat_array = array_keys($cat_product_list);

      $size_term = get_term($product_size,'size-category');

      $subscription_variation = get_post_meta( $subscription_id, 'subscription_variation', true );
      
      $subscription_variation['product_cat_id'] = $product_cat;
      
      $subscription_variation['color_cat_id'] = implode(',', $color_cat_array);

      $subscription_variation['size_slug'] = $size_term->slug;

      $items = $subscription->get_items(); 

      foreach ( $items as $item ) {

          $product_id = $item['product_id'];

          $quantity = $item['quantity'];

          $variation_id = $item['variation_id'];

          $this->quantity_increase($variation_id, $quantity);
      }

      $subscription->remove_order_items();

      $variationsArray=array();

      foreach ($cat_product_list as $colorID => $producData) {

         $color_term = get_term($colorID,'color-category');

         $variation    = array(
           'Size'  => $size_term->slug,
           'Color'  => $color_term->slug,
          );
          $variationsArray['variation'] = $variation;

          foreach ($producData as $variation_id => $qty) {

              $varProduct = new WC_Product_Variation($variation_id);
              $product_id = $varProduct->post->post_parent;             
              $price = '94.50';
              $product_name = $this->product_tittle_name_change($product_id, array('size_slug'=> $size_term->slug, 'product_cat_id' => $product_cat ) );

              //change product price
              $varProduct->set_price($price);
              //channge product name
              $varProduct->set_name( $product_name );

              $subscription->add_product($varProduct, $qty, $variationsArray);
              $this->quantity_decrease($variation_id, $qty);
          }
      }

      update_post_meta($subscription_id,'subscription_variation', $subscription_variation);
      $subscription->calculate_totals();
       
      $response['status'] = '1';
      $response['item_list'] = 'success';

      echo json_encode($response); die;          

    }else{

        $msg = '<div class="alert alert-danger error"><strong> Hov. </strong> Something went wrong. please try again.</div>';

        $response['status'] = '0';

        $response['msg'] = $msg;

        echo json_encode($response); die; 

    }

  }

}

new ProductAjax();