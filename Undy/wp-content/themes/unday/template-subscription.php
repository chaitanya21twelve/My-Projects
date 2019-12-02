<?php 

/*

	Template Name: Subscription Order

*/

/*if(isset($_POST['product_main']) && !empty($_POST['product_main'])){

	global $woocommerce;

	$woocommerce->cart->empty_cart(); 

	foreach($_POST['product_main'] as $productId){

		$product_id   = $productId;

		$variation_id   = $_POST['variation_id_'.$product_id];

		//$size = get_term($_POST['product_size'],'pa_size');

		$product_variable = new WC_Product_Variable($product_id);

		$product_variations = $product_variable->get_available_variations();

		$displayProduct = true;

		$size_name = '';

		$allAvailableVariations = array();

		foreach($product_variations as $product_variation){

			// if($product_variation['attributes']['attribute_pa_size'] == $size->slug){

			// 	$variationId = $product_variation['variation_id'];
			// }

			if($variation_id == $product_variation['variation_id']){

				$variationId = $product_variation['variation_id'];

				$size_name = $product_variation['attributes']['attribute_pa_size'];

				$price = $product_variation['display_regular_price'];
			}
		}	

		$quantity     = 1;

 		$trail_product_id = 557;
 
 		$variation    = array(
			//'Color' => 'Blue',
			'Size'  => $size_name,
		);
 		$cart_item_data = array();
 		$cart_item_data['subscription_product'] = 1; 

		$item_data = array();
		$item_data['product_id'] = $product_id;
		$item_data['variation_id'] = $variationId;
		$item_data['size'] = $size_name;
		$item_data['price'] = $price;
		$item_data['variation'] = $variation;

		$cart_item_data['product_data'] = $item_data; 

		$cart_key = WC()->cart->add_to_cart( $trail_product_id, $quantity,'','', $cart_item_data );
 
	}

	wp_redirect(get_site_url().'/cart');
 	exit;
 
}*/

get_header();

?>
<style>
	.page-template-template-subscription section.form-row {
    display: none;
}
</style>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- CONTENT -->

<section class="heading-tp">

  <div class="container">

    <div class="row">

      <div class="col-xs-12">

        <div class="page-title">

          <?php the_content();?>
 
        </div>

        <div class="page-title">
			<p><br><br>Vælg dit første par underbukser fra Undy. I prøvepakken modtager du ét par til kun 19 kr.  Med et medlemskab hos Undy, kan du fremover modtage 2 par underbukser hver 3. måned. Husk at du kun er forpligtet til at modtage prøvepakken  </p>
		</div>

      </div>

    </div>

  </div>

</section>



<section class="product-selector">

  <div class="container">

    <form action="" method="post" id="main_frm">

    	<input type="hidden" name="action" value="trailProductAddToCart">

		<?php 

		if(isset($_GET['coupon_code']) && !empty($_GET['coupon_code']) ){
			echo '<input type="hidden" name="coupon_code" value="'.$_GET['coupon_code'].'">';
		}

		$terms = get_terms( 'product_cat', array(

			'hide_empty' => true,
 		) );

		if(!empty($terms)){

			$exists_term = array(78, 79);

		?>

      <div class="row selection-1">

        <h3 class="text-center">1. Vælg din type underbukser</h3>

    

        <?php foreach($terms as $term){

        if(in_array($term->term_id, $exists_term)){

			$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );

			$image = wp_get_attachment_url( $thumbnail_id );

		   ?>

			<div class="col-md-6">

	          <div class="item-box"> 

			  	<img src="<?php echo IMAGES_URL;?>/tick.png" class="tick">


	            <?php if($term->term_id == '78'){  

	               echo '<h5 class="text-center"> Tætte boxerbriefs </h5>';
	               
	                echo '<img src="'.get_template_directory_uri().'/classes/product/assets/images/boxerbriefs_icon.png" class="boxers" />';

	                $text = 'Tætsiddende boxerbriefs med mellemlange ben.';

	            }elseif ($term->term_id == '79') {

	                 echo '<h5 class="text-center">Løse boxershorts</h5>';
	            	 echo '<img src="'.get_template_directory_uri().'/classes/product/assets/images/boxershorts_icon.png" class="boxers" />';
	            	 $text = 'Klassiske boxershorts i et løst fit.';
	            }


	            ?>

				<div style="display:none">

					<input type="radio" name="product_cat" class="product_cat" value="<?php echo $term->term_id;?>" />

				</div>

				<div class="text-center" style="padding-top: 25px;">
                   <p> <?php echo $text; ?></p> <br>
		        </div>

				</div>

	        </div>

		<?php } }?>

      </div>

	  <?php }?>

      <?php 

 

      /*?><!-- Selection part 2 -->

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

                        Prøvepakke: <b>19,00 kr.</b><br/>

                        <br/> 
						2 par underbukser hver <b>3. måned: 189 kr. inkl. fragt</b><br/><br/>
					<b> Første fornyelse om 10 dage</b> <br/> <br/>
						Du betaler kun for de underbukser vi sender til dig.
						Husk du <br/>kan opsige øjeblikkeligt fra dag til dag. Hos Undy er der intet med småt <br/>
					
                        <div class="abonnement-btn"> 
 
                            <a href="javascript:void(0);" data-id="1" class="proceed_to_checkout" id="proceed_to_checkout">Gå til checkout</a>
                            
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

			/*action: 'get_available_Sizes',*/
			action: 'getAvailableSizesHtml',

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

	jQuery(document).on('click touchstart',".selection-2 .item-box",function(){
		

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

			//action: 'get_available_products',
			action: 'getProductByCategoryId',

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

		jQuery(".selection-3 .item-box").removeClass("active");

		

		jQuery(this).addClass("active");

		jQuery(".selection-3 .item-box .product_main").prop("checked",false);

		jQuery(".selection-3 .item-box.active .product_main").prop("checked",true);

		jQuery(this).find(".product_main").prop("checked",true);

		

		

		jQuery(".selection-4").show();

		

	  return false;

	})

	jQuery("#proceed_to_checkout").on('click',function(){

		if(jQuery(".selection-3 .item-box.active").length == 1){
  			 
		    var currentProductCat = jQuery(".selection-1 .item-box.active").find(".product_cat").val();

		    var formdata = jQuery("#main_frm").serialize();

			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

			jQuery.post( ajaxurl, formdata, function( response ) {

				var res = parseInt(response);

 				if(res == 1){

					var baseUrl = document.location.origin;

					window.location.href = "<?php echo site_url(); ?>/checkout";

				}else{
 

				}
			});

		}

	})

	

})

</script>

<!--End Page design-->

<?php endwhile; endif;?>

<?php get_footer();?>

