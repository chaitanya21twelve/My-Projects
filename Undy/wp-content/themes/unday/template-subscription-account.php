<?php 
/*
	Template Name: Subscription Order My Account
*/
$order_id = $_GET['order'];


$checkSubscription = Subscriptio_Order_Handler::contains_subscription($order_id);
if($checkSubscription){
	$subscription = Subscriptio_Subscription::get_by_id(221);
	$order = new WC_Order( $order_id );
	$order_items = $order->get_items();
	
	
	$subscription = Subscriptio_Subscription::get_by_id(221);
	
	$newProducts = array();
	$newProducts[] = array(
		'product_id' => 205,
		'product_name' => 'Sample Product XXL',
		'variation_id' => '',
		'quantity' => 1,
		'total' => 1,
		'tax' => 0,
	);
	$newProducts[] = array(
		'product_id' => 204,
		'product_name' => 'Sample Product XL',
		'variation_id' => '',
		'quantity' => 1,
		'total' => 1,
		'tax' => 0,
	);
	$params['products_multiple'] = $newProducts
	//$subscription->products_multiple = $newProducts;
	$subscription::update_subscription_details($params);
	
	echo "<pre>"; print_r($subscription); exit;
}




if(isset($_POST['product_main']) && !empty($_POST['product_main'])){
	global $woocommerce;
	$woocommerce->cart->empty_cart(); 
	foreach($_POST['product_main'] as $productId){
		$product_id   = $productId;
		$size = get_term($_POST['product_size'],'pa_size');
		$product_variable = new WC_Product_Variable($product_id);
		$product_variations = $product_variable->get_available_variations();
		$displayProduct = true;
		$allAvailableVariations = array();
		foreach($product_variations as $product_variation){
			if($product_variation['attributes']['attribute_pa_size'] == $size->slug){
				$variationId = $product_variation['variation_id'];
			}
		}
		
		
		$quantity     = 1;
		$variation_id = $_POST['product_size'];
		
		$variation    = array(
			//'Color' => 'Blue',
			'Size'  => $size->name,
		);
		WC()->cart->add_to_cart( $product_id, $quantity,$variationId,$variation);
	}
	wp_redirect(get_site_url().'/cart');
	exit;
	
}
get_header();
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<!-- CONTENT -->

<section class="heading-tp">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <?php the_content();?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="product-selector">
  <div class="container">
    <form action="" method="post" id="main_frm">
		<?php 
		$terms = get_terms( 'product_cat', array(
			'hide_empty' => true,
		) );
		if(!empty($terms)){
		?>
      <div class="row selection-1">
        <h3 class="text-center">1. Vælg din type underbukser</h3>
        <?php foreach($terms as $term){
		$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		?>
		<div class="col-md-6">
          <div class="item-box"> 
		  	<img src="<?php echo IMAGES_URL;?>/tick.png" class="tick">
            <h5 class="text-center"><?php echo $term->name;?></h5>
            <img src="<?php echo IMAGES_URL;?>/boxerbriefs.png" class="boxers" />
			<div style="display:none">
				<input type="radio" name="product_cat" class="product_cat" value="<?php echo $term->term_id;?>" />
			</div>
			</div>
        </div>
		<?php }?>
      </div>
	  <?php }?>
      <?php /*?><!-- Selection part 2 -->
      <div class="row selection-2">
        <h3 class="text-center">2. Vælg størrelse</h3>
        <p class="text-center" style="text-decoration: underline;">Størrelsesguide</p>
        <div class="col-md-12 wrapper">
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" />
            <h1 class="text-center">S</h1>
          </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" />
            <h1 class="text-center">M</h1>
          </div>
          <div class="item-box active"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" />
            <h1 class="text-center">L</h1>
          </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" />
            <h1 class="text-center">XL</h1>
          </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" />
            <h1 class="text-center">XXL</h1>
          </div>
        </div>
      </div>
      <!-- Selection part 3 -->
      <div class="row selection-3">
        <h3 class="text-center">3. Vælg design</h3>
        <div class="col-md-6">
          <h3 class="text-center">Ensfarvet</h3>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
          <div class="item-box active"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
        </div>
        <div class="col-md-6">
          <h3 class="text-center">Med print</h3>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
          <div class="item-box"> <img src="<?php echo IMAGES_URL;?>/tick.png" class="tick" /> <img src="<?php echo IMAGES_URL;?>/brief.png" alt=""> </div>
        </div>
      </div><?php */?>
	  <!-- Selection part 4 -->
        
    </form>
	<div class="row selection-4" style="display:none;">
            <h3 class="text-center">4. Bekræftelse</h3>
            <div class="col-md-12">
                <div class="item-box">
                        Prøvepakke: <b>1,00 kr.</b><br/>
                        <br/>
                        Medlemsskab hver 3. måned: <b>179 kr. inkl. fragt</b><br/>
                        Vi sender 2 par lækre underbukser efter dit eget valg<br/>
                        <div class="abonnement-btn">
                            <a href="javascript:void(0);" id="proceed_to_checkout">Gå til checkout</a>
                        </div>
                </div>
            </div>
            
        </div>
  </div>
</section>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".selection-1 .item-box").on('click',function(){
		jQuery(".selection-1 .item-box.active").removeClass("active");
		
		jQuery(".product-selector form .selection-2").remove();
		jQuery(".product-selector form .selection-3").remove();
		jQuery(".selection-4").hide();
		
		jQuery(".product-selector form").css("opacity","0.5");
		jQuery(".product-selector form").css("pointer-events","none");
		jQuery(this).addClass("active");
		jQuery(this).find(".product_cat").prop("checked",true);
		var currentProductCat = jQuery(this).find(".product_cat").val();
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		 jQuery.post( ajaxurl, 
		  { 
			action: 'get_available_Sizes',
			prod_cat: currentProductCat,  
		  }, function( response ) {
				if(response == "empty"){
					alert("Something went wrong. Please try after some time");
					
				}else if(response == "invalid"){
					alert("Invalid Category");
					
				}else if(response == "noresult"){
					alert("No Products Found. Please try some other criteria.");
					
				}else{
					jQuery(".product-selector form").append(response);
				}
				jQuery(".product-selector form").attr("style","");
				//location.href =  jQuery('.navbar-header .logo a').attr("href");
		  });
		  return false;
	})
	
	jQuery(document).on('click',".selection-2 .item-box",function(){
		
		jQuery(".selection-2 .item-box.active").removeClass("active");
		jQuery(".product-selector form .selection-3").remove();
		jQuery(".selection-4").hide();
		jQuery(".product-selector form").css("opacity","0.5");
		jQuery(".product-selector form").css("pointer-events","none");
		jQuery(this).addClass("active");
		jQuery(this).find(".product_size").prop("checked",true);
		var currentProductCat = jQuery(".selection-1 .item-box.active").find(".product_cat").val();
		var currentProductSize = jQuery(this).find(".product_size").val();
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		 jQuery.post( ajaxurl, 
		  { 
			action: 'get_available_products',
			prod_cat: currentProductCat,  
			product_size: currentProductSize,  
		  }, function( response ) {
				if(response == "empty"){
					alert("Something went wrong. Please try after some time");
					
				}else if(response == "invalid"){
					alert("Invalid Category");
					
				}else if(response == "noresult"){
					alert("No Products Found. Please try some other criteria.");
					
				}else{
					jQuery(".product-selector form").append(response);
				}
				jQuery(".product-selector form").attr("style","");
				//jQuery(".selection-4").show();
				//location.href =  jQuery('.navbar-header .logo a').attr("href");
		  });
		  return false;
	})
	
	jQuery(document).on('click',".selection-3 .item-box",function(){
		if(jQuery(this).hasClass("active")){
			jQuery(this).removeClass("active");
			jQuery(".selection-4").hide();
			return;
		}
		jQuery(".selection-3 .item-box.active").removeClass("active");
		
		jQuery(this).addClass("active");
		jQuery(".selection-3 .item-box .product_main").prop("checked",false);
		jQuery(".selection-3 .item-box.active .product_main").prop("checked",true);
		jQuery(this).find(".product_main").prop("checked",true);
		
		
		jQuery(".selection-4").show();
		
	  return false;
	})
	
	jQuery("#proceed_to_checkout").on('click',function(){
		if(jQuery(".selection-3 .item-box.active").length == 1){
			jQuery("#main_frm").submit();
		}
	})
	
})
</script>
<!--End Page design-->
<?php endwhile; endif;?>
<?php get_footer();?>
