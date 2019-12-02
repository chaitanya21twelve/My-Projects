<?php
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus(
        array(
          //'top-menu' => 'Top Menu',
          'header-menu' => 'Header Menu',
		  'header-menu2' => 'Header Menu Right',
		  'footer-menu' => 'Footer Menu',
		  //'footer-menu-2' => 'Footer Menu 2',
        )
    );
}


include_once 'wp-bootstrap-navwalker.php';
include_once('classes/account/AccountClass.php');
include_once('classes/account/membershipEndpointClass.php');
//vijendra  

function autoLoadClassFiles(){
	// product class
	require_once('classes/product/BaseProduct.php');
	require_once('classes/product/ProductCategory.php');
	require_once('classes/product/ProductAjax.php');
	
	//my account class
	require_once('classes/account/BaseAccount.php');
    //cart page
	require_once('classes/cart/MainCart.php');
 }

add_action('init','autoLoadClassFiles');


 

//add_theme_support( 'post-thumbnails' );
function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
} add_filter('tiny_mce_before_init', 'override_mce_options');

function arphabet_widgets_init() {
	register_sidebar( array(
		'name'          => 'Footer Column 1',
		'id'            => 'footer_column_1',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => 'Footer Column 2',
		'id'            => 'footer_column_2',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => 'Checkout Page Widget',
		'id'            => 'checkout_page_widget',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => 'Cart Widget',
		'id'            => 'cart_widget',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );
add_action( 'after_setup_theme', 'setup_woocommerce_support' );


// Our custom post type function
function create_posttype() {
 
    register_post_type( 'faqs',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Faqs' ),
                'singular_name' => __( 'Faq' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'faqs'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );


function setup_woocommerce_support()
{
	add_theme_support('woocommerce');
}
add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');
  
function woo_custom_cart_button_text() {
    return __('LÆG I INDKØBSKURV', 'woocommerce');
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
	unset( $tabs['description'] ); // Remove the description tab
	unset( $tabs['reviews'] ); // Remove the reviews tab
	unset( $tabs['additional_information'] ); // Remove the additional information tab
	return $tabs;
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'woocommerce_after_single_product', '_show_reviews', 15 );
function _show_reviews() {
  comments_template();
}

add_action( "wp_ajax_nopriv_get_available_Sizes", "get_available_Sizes" );
add_action( "wp_ajax_get_available_Sizes", "get_available_Sizes" ); 
function get_available_Sizes( ) {

	$prod_cat = $_POST['prod_cat'];
	if(empty($prod_cat)){
		echo "empty";
	}
	$term = get_term($prod_cat,'product_cat');
	if(empty($term)){
		echo "invalid";
	}
	$sizes = get_terms( 'pa_size', array(
		'hide_empty' => true,
	) );

	// $sizeCategories = get_terms( 'size-category', array(
	// 	'hide_empty' => true,
	// ) );

	foreach($sizes as $s=>$size){
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
				array(
					'taxonomy' => 'pa_size',
					'field'    => 'term_id',
					'terms'    => array($size->term_id),
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
			unset($sizes[$s]);
		}
		wp_reset_query();
	}
	if(empty($sizes)){
		 echo "noresult"; exit;
	}

	$html = '<div class="row selection-2">
        <h3 class="text-center">2. Vælg størrelse</h3>
        <p class="text-center icon-plus-sign" style="text-decoration: underline;">Størrelsesguide</p>
        <div class="col-md-12 wrapper">';

       
		foreach($sizes as $size){	
	          $html.= '<div class="item-box"> <img src="'.get_bloginfo('template_url').'/images/tick.png" class="tick" />
	            <h1 class="text-center">'.$size->name.'</h1>
				<div style="display:none">
					<input type="radio" name="product_size" class="product_size" value="'.$size->term_id.'" />
				</div>
	          </div>';
		}	 		 
        
		
    $html.= '</div></div>';
	echo $html; exit();
} 

add_action( "wp_ajax_nopriv_get_available_products", "get_available_products" );
add_action( "wp_ajax_get_available_products", "get_available_products" ); 
function get_available_products( ) {
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
	$size = get_term($prod_size,'pa_size');
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
				array(
					'taxonomy' => 'pa_size',
					'field'    => 'term_id',
					'terms'    => array($prod_size),
				),
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
				array(
					'key' => '_subscriptio',
					'value' => 'yes',
					'compare' => '=',
				),
				
			)      
		);
		$loop = new WP_Query( $mypost );
		
		$html.='<div class="col-md-6">';
		$html.='<h3 class="text-center">'.$colorCategory->name.'</h3>';
		if($loop->found_posts > 0){
			$totalDisplay = 0;
			$i = 1; while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				$product_variable = new WC_Product_Variable($product->get_id());
				$product_variations = $product_variable->get_available_variations();
				$displayProduct = true;
				$allAvailableVariations = array();
				foreach($product_variations as $product_variation){
					$allAvailableVariations[] = $product_variation['attributes']['attribute_pa_size'];
					if($product_variation['attributes']['attribute_pa_size'] == $size->slug){
						if(!$product_variation['is_in_stock']){
							$displayProduct = false;
						}else{
							$totalDisplay++;
						}
					}
				}
				if(!$displayProduct){
					continue;
				}
				if(!in_array($size->slug,$allAvailableVariations)){
					continue;
				}
				
				$image = get_the_post_thumbnail_url(get_the_ID(),'full');
				$html.='<div class="item-box"><img src="'.get_bloginfo('template_url').'/images/tick.png" class="tick" /><img src="'.$image.'" alt="" style="width:173px; height:132px;" title="'.get_the_title().'"> <div style="display:none">
				<input type="checkbox" name="product_main[]" class="product_main" value="'.get_the_ID().'" />
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

function iconic_add_engraving_text_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
	$checkSubscrption = get_post_meta($product_id,'_subscriptio',true);
	if ( !isset($checkSubscrption) || empty( $checkSubscrption ) || $checkSubscrption !== "yes" ) {
		return $cart_item_data;
	}
	$checkSubscrptions = get_field('linked_products',$product_id);
	if(empty($checkSubscrptions)){
		return $cart_item_data;
	}
	$cart_item_data['subscription-products'] = implode($checkSubscrptions,',');
	return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'iconic_add_engraving_text_to_cart_item', 10, 3 );

// review text

function change_up($fields) { 

$fields['comment_notes_before'] = '<p class="comment-notes">Din email adresse vil ikke være synlig</p>'; 

return $fields; 

} 

add_filter('comment_form_defaults','change_up');

// checkout page 
add_filter('woocommerce_create_account_default_checked' , function ($checked){
    return true;
});

// category desc

add_action("{product_cat}_edit_form_fields", 'add_form_fields_example', 10, 2);

function add_form_fields_example($term, $taxonomy){
    ?>
    <tr valign="top">
        <th scope="row">Description</th>
        <td>
            <?php wp_editor(html_entity_decode($term->description), 'description', array('media_buttons' => false)); ?>
            <script>
                jQuery(window).ready(function(){
                    jQuery('label[for=description]').parent().parent().remove();
                });
            </script>
        </td>
    </tr>
    <?php
} 




/*View Cart*/


//remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
//
//function my_woocommerce_widget_shopping_cart_view_cart() {
//    echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward">'. esc_html__( 'View Bag', 'woocommerce' ) .'</a>';
//}
//
//add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_view_cart', 10 );



add_filter( 'get_comment_date', 'wpsites_change_comment_date_format' );	
function wpsites_change_comment_date_format( $d ) {
    $d = date("j. F, Y");	
    return $d;
} 


// reviews

function get_total_reviews_count(){
    return get_comments(array(
        'status'   => 'approve',
        'post_status' => 'publish',
        'post_type'   => 'product',
        'count' => true
    ));
}

//function get_products_ratings(){
//    global $wpdb;
//
//    return $wpdb->get_results("
//        SELECT t.slug, tt.count
//        FROM {$wpdb->prefix}terms as t
//        JOIN {$wpdb->prefix}term_taxonomy as tt ON tt.term_id = t.term_id
//        WHERE t.slug LIKE 'rated-%' AND tt.taxonomy LIKE 'product_visibility'
//        ORDER BY t.slug
//    ");
//}
//
//function products_count_by_rating_html(){
//	//echo "<pre>"; print_r(get_products_ratings());
//    $star = 1;
//    $html = '';
//    foreach( get_products_ratings() as $values ){
//		//echo "<pre>"; print_r($values);
//        $star_text = '<strong>'.$star.' '._n('Star', 'Stars', $star, 'woocommerce').'<strong>: ';
//       // $html .= '<li class="'.$values->slug.'">'.$star_text.$values->count.'</li>';
//		$html .= '<li class="'.$values->slug.'">'.$values->count.'</li>';
//        $star++;
//    }
//    return '<ul class="products-rating">'.$html.'</ul>';
//}

function products_rating_average_html(){
    $stars = 1;
    $average = 0;
    $total_count = 0;
    if( sizeof(get_products_ratings()) > 0 ) :
        foreach( get_products_ratings() as $values ){
			//echo "<pre>"; print_r($values);
            $average += $stars * $values->count;
			
            $total_count += $values->count;
            $stars++;
        }
	
        //return '<p class="rating-average">'.round($average / $total_count, 1).' / 5 '. __('Stars average').'</p>';
	return '<p class="rating-average">'.round($average / $total_count).' ud af 5'. __(' stjerner').'</p>';
    else :
        return '<p class="rating-average">'. __('No reviews yet', 'woocommerce').'</p>';
    endif;
}

function products_rating_average_rate(){
    $stars = 1;
    $average = 0;
    $total_count = 0;
    if( sizeof(get_products_ratings()) > 0 ) :
        foreach( get_products_ratings() as $values ){
            $average += $stars * $values->count;
            $total_count += $values->count;
            $stars++;
        }
	
        //return '<p class="rating-average">'.round($average / $total_count, 1).' / 5 '. __('Stars average').'</p>';
	return round($average / $total_count);
    else :
        return '<p class="rating-average">'. __('No reviews yet', 'woocommerce').'</p>';
    endif;
}

 


add_filter( 'woocommerce_available_payment_gateways', 'woocommerce_available_payment_gateways' );
function woocommerce_available_payment_gateways( $available_gateways ) {
    if (! is_checkout() ) return $available_gateways;  // stop doing anything if we're not on checkout page.
    if (array_key_exists('paypal',$available_gateways)) {
        // Gateway ID for Paypal is 'paypal'. 
         $available_gateways['paypal']->order_button_text = __( 'Fortsæt til PayPal', 'woocommerce' );
    }
	if (array_key_exists('bacs',$available_gateways)) {
        // Gateway ID for Paypal is 'paypal'. 
         $available_gateways['bacs']->order_button_text = __( 'Gennemfør', 'woocommerce' );
    }
	if (array_key_exists('cheque',$available_gateways)) {
        // Gateway ID for Paypal is 'paypal'. 
         $available_gateways['cheque']->order_button_text = __( 'Gennemfør', 'woocommerce' );
    }
    return $available_gateways;
}


add_filter ( 'wc_add_to_cart_message', 'wc_add_to_cart_message_filter', 10, 2 );
function wc_add_to_cart_message_filter($message, $product_id = null) {
    $titles[] = get_the_title( $product_id );

    $titles = array_filter( $titles );
    $added_text = sprintf( _n( '%s Er tilføjet i indkøbskurven', '%s Er tilføjet i indkøbskurven', sizeof( $titles ), 'woocommerce' ), wc_format_list_of_items( $titles ) );

    $message = sprintf( '%s <a href="%s" class="button">%s</a>',
                    esc_html( $added_text ),
                    esc_url( wc_get_page_permalink( 'cart' ) ),
                    esc_html__( 'Se indkøbskurv', 'woocommerce' ));

    return $message;
}

// To change select product option popup

add_filter( 'gettext', 'customizing_variable_product_message', 97, 3 );
function customizing_variable_product_message( $translated_text, $untranslated_text, $domain )
{
    if ($untranslated_text == 'Please select some product options before adding this product to your cart.') {
        $translated_text = __( 'Vælg venligst en størrelse, før du tilføjer produktet til din indkøbskurv', $domain );
    }
    return $translated_text;
}

//show_admin_bar( false );


/**
 * Remove password strength check.
 */
function iconic_remove_password_strength() {
    wp_dequeue_script( 'wc-password-strength-meter' );
}
add_action( 'wp_print_scripts', 'iconic_remove_password_strength', 10 );
 
  
 
add_filter( 'wcs_renewal_order_created', 'woocommerce_scheduled_subscription_next', 10, 2 );
 
function woocommerce_scheduled_subscription_next( $renewal_order, $subscription){
  
    $items = $renewal_order->get_items(); 

    foreach ( $items as $itemID => $item ) {

     	wc_delete_order_item_meta($itemID, 'Size');
    	wc_delete_order_item_meta($itemID, 'Color');
    }
    return $renewal_order;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');
function wc_refresh_mini_cart_count($fragments){
    ob_start();
    ?>
    <div id="mini-cart-count">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </div>
    <?php
        $fragments['#mini-cart-count'] = ob_get_clean();
    return $fragments;
}
 

 
function hide_delivery_shipping_rates_on_cart( $rates, $packege) {
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


add_filter( 'woocommerce_package_rates', 'hide_delivery_shipping_rates_on_cart', 10, 2);

// Rename the flat rate shipping label when the cost is $0
function woocommerce_shipping_flat_rate_label( $label, $method ) {
	// if($method->id == 'flat_rate:1'){

	// 		 $label = woocommerce_price($method->cost);
	// }
	 $label = str_replace("Levering:"," ",$label);
	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'woocommerce_shipping_flat_rate_label', 10, 2 );
 
add_filter( 'woocommerce_order_button_text', 'woo_checkout_button_text_change' ); 

function woo_checkout_button_text_change() {
    return __( 'Godkend og betal', 'woocommerce' ); 
}


add_filter( 'woocommerce_email_from_address', 'email_from_change', 10, 2 );

	function email_from_change($from_email, $wc_email) {
    
        $from_email = 'hej@undy.dk';
    return $from_email;
}

 add_filter( 'wc_add_to_cart_message', 'my420_add_to_cart_function', 10, 2  ); 

function my420_add_to_cart_function($message, $products) { 


    //$message = str_replace("og firkantet boxerbriefs","", $message); 
     $message = 'Tilføjet til din indskøbskurv <a href="https://undy.dk/cart/" class="button">Se indkøbskurv</a>'; 
    return $message; 
}
 


/*
* Remove product-category in URL
* 
*/
add_filter( 'term_link', 'devvn_product_cat_permalink', 10, 3 );
function devvn_product_cat_permalink( $url, $term, $taxonomy ){
    switch ($taxonomy):
        case 'product_cat':
            $taxonomy_slug = 'product-category'; //Change product-category to your product category slug
            if(strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
    endswitch;
    return $url;
}
// Add our custom product cat rewrite rules
function devvn_product_category_rewrite_rules($flash = false) {
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'post_type' => 'product',
        'hide_empty' => false,
    ));
    if($terms && !is_wp_error($terms)){
        $siteurl = esc_url(home_url('/'));
        foreach ($terms as $term){
            $term_slug = $term->slug;
            $baseterm = str_replace($siteurl,'',get_term_link($term->term_id,'product_cat'));
            add_rewrite_rule($baseterm.'?$','index.php?product_cat='.$term_slug,'top');
            add_rewrite_rule($baseterm.'page/([0-9]{1,})/?$', 'index.php?product_cat='.$term_slug.'&paged=$matches[1]','top');
            add_rewrite_rule($baseterm.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat='.$term_slug.'&feed=$matches[1]','top');
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_product_category_rewrite_rules');
/*Fix 404 when creat new term*/
add_action( 'create_term', 'devvn_new_product_cat_edit_success', 10, 2 );
function devvn_new_product_cat_edit_success( $term_id, $taxonomy ) {
    devvn_product_category_rewrite_rules(true);
}

/* function PREFIX_woocommerce_price_html( $price, $product ){
    return preg_replace('@(<del>.*?</del>).*?(<ins>.*?</ins>)@misx', '$2 $1', $price);
}

add_filter( 'woocommerce_get_price_html', 'PREFIX_woocommerce_price_html', 100, 2 ); */



add_shortcode('page_top_products','page_top_product_shortcode');
function page_top_product_shortcode($cat) {
	$response .= '<div class="productListing"><ul class="products">';
            $args = array('post_type' => 'product','posts_per_page' => 4,'order_by' => 'date','order' => 'desc','product_cat' =>$cat['cat']);

                $loop = new WP_Query( $args );

                while ( $loop->have_posts() ) : $loop->the_post();
                    global $product;

                    $price = get_post_meta( get_the_ID(), '_price', true );
                  
                $response .= '<li class="product"><a href="'.get_permalink().'"><div class="productImage">
                            '.woocommerce_get_product_thumbnail().'
                        </div><div class="productContent"><h3>'.get_the_title().'</h3><span class="priceProduct"> 
                                '.wc_price( $price ).'</p></span></div></a></li>';

               endwhile;
               wp_reset_query();
               $response .= '</ul></div>';

	return $response;
}



add_action('wp_enqueue_scripts', 'remove_extra_js_and_css');
function remove_extra_js_and_css() {
	global $wp_scripts;
	global $wp_styles;

	if( !current_user_can('administrator') )
	{
		wp_dequeue_style('dashicons');
    	wp_deregister_style('dashicons');
    	wp_dequeue_style('admin-bar');
    	wp_deregister_style('admin-bar');
	    wp_dequeue_style('imagify-admin-bar');
    	wp_deregister_style('imagify-admin-bar');
	}


    if( is_front_page() )
    {

    	wp_dequeue_style('wp-block-library');
    	wp_deregister_style('wp-block-library');
    	wp_dequeue_style('wc-block-style');
    	wp_deregister_style('wc-block-style');
    	wp_dequeue_style('contact-form-7');
    	wp_deregister_style('contact-form-7');
    	// wp_dequeue_style('sb_instagram_styles');
    	// wp_deregister_style('sb_instagram_styles');
    	wp_dequeue_style('sb-font-awesome');
    	wp_deregister_style('sb-font-awesome');
    	wp_dequeue_style('woocommerce-layout');
    	wp_deregister_style('woocommerce-layout');
    	wp_dequeue_style('woocommerce-smallscreen');
    	wp_deregister_style('woocommerce-smallscreen');
    	wp_dequeue_style('woocommerce-general');
    	wp_deregister_style('woocommerce-general');
    


    	wp_dequeue_script('widget-bootstrap');
    	wp_deregister_script('widget-bootstrap');
    	// wp_dequeue_script('jquery-core');
    	// wp_deregister_script('jquery-core');
    	// wp_dequeue_script('jquery-migrate');
    	// wp_deregister_script('jquery-migrate');
    	wp_dequeue_script('tp-js');
    	wp_deregister_script('tp-js');
    	// wp_dequeue_script('jquery-blockui');
    	// wp_deregister_script('jquery-blockui');
    	wp_dequeue_script('wc-add-to-cart');
    	wp_deregister_script('wc-add-to-cart');
    	wp_dequeue_script('vc_woocommerce-add-to-cart-js');
    	wp_deregister_script('vc_woocommerce-add-to-cart-js');
    	wp_dequeue_script('admin-bar');
    	wp_deregister_script('admin-bar');
    	wp_dequeue_script('contact-form-7');
    	wp_deregister_script('contact-form-7');
    	// wp_dequeue_script('sb_instagram_scripts');
    	// wp_deregister_script('sb_instagram_scripts');
    	// wp_dequeue_script('js-cookie');
    	// wp_deregister_script('js-cookie');
    	wp_dequeue_script('woocommerce');
    	wp_deregister_script('woocommerce');
    	// wp_dequeue_script('wc-cart-fragments');
    	// wp_deregister_script('wc-cart-fragments');
    	wp_dequeue_script('imagify-admin-bar');
    	wp_deregister_script('imagify-admin-bar');
    	// wp_dequeue_script('mailchimp-woocommerce');
    	// wp_deregister_script('mailchimp-woocommerce');
    	// wp_dequeue_script('mailchimp-woocommerce_connected_site');
    	// wp_deregister_script('mailchimp-woocommerce_connected_site');
    	wp_dequeue_script('wp-embed');
    	wp_deregister_script('wp-embed');
    	wp_dequeue_script('mc4wp-forms-api');
    	wp_deregister_script('mc4wp-forms-api');

    }


    if( is_product() )
    {
    	wp_dequeue_style('wp-block-library');
    	wp_deregister_style('wp-block-library');
    	wp_dequeue_style('wc-block-style');
    	wp_deregister_style('wc-block-style');
    	wp_dequeue_style('contact-form-7');
    	wp_deregister_style('contact-form-7');
    	wp_dequeue_style('sb_instagram_styles');
    	wp_deregister_style('sb_instagram_styles');
    	wp_dequeue_style('sb-font-awesome');
    	wp_deregister_style('sb-font-awesome');
    	// wp_dequeue_style('woocommerce-layout');
    	// wp_deregister_style('woocommerce-layout');
    	// wp_dequeue_style('woocommerce-smallscreen');
    	// wp_deregister_style('woocommerce-smallscreen');
    	// wp_dequeue_style('woocommerce-general');
    	// wp_deregister_style('woocommerce-general');


    	wp_dequeue_script('widget-bootstrap');
    	wp_deregister_script('widget-bootstrap');
    	// wp_dequeue_script('jquery-core');
    	// wp_deregister_script('jquery-core');
    	// wp_dequeue_script('jquery-migrate');
    	// wp_deregister_script('jquery-migrate');
    	wp_dequeue_script('tp-js');
    	wp_deregister_script('tp-js');
    	// wp_dequeue_script('jquery-blockui');
    	// wp_deregister_script('jquery-blockui');
    	wp_dequeue_script('wc-add-to-cart');
    	wp_deregister_script('wc-add-to-cart');
    	wp_dequeue_script('vc_woocommerce-add-to-cart-js');
    	wp_deregister_script('vc_woocommerce-add-to-cart-js');
    	wp_dequeue_script('admin-bar');
    	wp_deregister_script('admin-bar');
    	wp_dequeue_script('wcs-single-product');
    	wp_deregister_script('wcs-single-product');
    	wp_dequeue_script('contact-form-7');
    	wp_deregister_script('contact-form-7');
    	wp_dequeue_script('sb_instagram_scripts');
    	wp_deregister_script('sb_instagram_scripts');
    	// wp_dequeue_script('js-cookie');
    	// wp_deregister_script('js-cookie');
    	wp_dequeue_script('woocommerce');
    	wp_deregister_script('woocommerce');
    	// wp_dequeue_script('wc-cart-fragments');
    	// wp_deregister_script('wc-cart-fragments');
    	wp_dequeue_script('imagify-admin-bar');
    	wp_deregister_script('imagify-admin-bar');
    	// wp_dequeue_script('mailchimp-woocommerce');
    	// wp_deregister_script('mailchimp-woocommerce');
    	// wp_dequeue_script('mailchimp-woocommerce_connected_site');
    	// wp_deregister_script('mailchimp-woocommerce_connected_site');
    	wp_dequeue_script('wp-embed');
    	wp_deregister_script('wp-embed'); 
    	// wp_dequeue_script('underscore');
    	// wp_deregister_script('underscore');  
    	// wp_dequeue_script('wp-util');
    	// wp_deregister_script('wp-util');    
    	// wp_dequeue_script('wc-add-to-cart-variation');
    	// wp_deregister_script('wc-add-to-cart-variation');
    	wp_dequeue_script('mc4wp-forms-api');
    	wp_deregister_script('mc4wp-forms-api');
    }

}

add_filter('woocommerce_subscriptions_email_subject_new_renewal_order', 'change_admin_email_subject', 10, 2);

function change_admin_email_subject( $subject, $order ) {
	global $woocommerce;

	if ( 'failed' == $order->get_status() )
	{
		$subject = sprintf( '%s, du skal opdatere din oplysninger',$order->billing_first_name );
	}

	return $subject;
}


add_filter('woocommerce_subscriptions_email_subject_customer_retry', 'change_subject_of_customer_payment_retry_email', 10, 2);

function change_subject_of_customer_payment_retry_email($subject, $order) {
	global $woocommerce;

	$subject = sprintf( '%s, du skal opdatere din oplysninger',$order->billing_first_name );

	return $subject;
}


function wcbv_variation_is_active( $active, $variation ) {
    if( ! $variation->is_in_stock() ) {
        return false;
    }
    return $active;
}
add_filter( 'woocommerce_variation_is_active', 'wcbv_variation_is_active', 10, 2 );


add_action('wp_footer','hide_out_of_stock_swatch');
function hide_out_of_stock_swatch() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			setTimeout(function(){ 			
		    jQuery("select#pa_size option").each(function() {

		    if( !jQuery(this).hasClass('enabled') )
		    {
		    	var val = jQuery(this).val();
		    	if(val)
		    	{
		    		jQuery('.tawcvs-swatches .swatch').each(function(){
		    			var value = jQuery(this).data('value');
		    			if( val == value )
		    			{
		    				jQuery(this).hide();
		    			}
		    		})
		    	}
		    }
		})
		}, 200);
		})
	</script>
	<?php
}