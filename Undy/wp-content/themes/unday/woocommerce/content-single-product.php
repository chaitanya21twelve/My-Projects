<?php

/**

 * The template for displaying product content in the single-product.php template

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce/Templates

 * @version 3.4.0

 */



defined( 'ABSPATH' ) || exit;



/**

 * Hook: woocommerce_before_single_product.

 *

 * @hooked wc_print_notices - 10

 */

do_action( 'woocommerce_before_single_product' );



if ( post_password_required() ) {

	echo get_the_password_form(); // WPCS: XSS ok.

	return;

}

global $product;

?>



<section class="product_detail">

  <div class="container">

    <div class="row">

      <div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

        <div class="col-md-6 col-sm-6 col-xs-12">

          <?php

		/**

		 * Hook: woocommerce_before_single_product_summary.

		 *

		 * @hooked woocommerce_show_product_sale_flash - 10

		 * @hooked woocommerce_show_product_images - 20

		 */

		do_action( 'woocommerce_before_single_product_summary' );

	?>

        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">

          <div class="products-details">

            <div class="summary entry-summary">

              <?php

			/**

			 * Hook: woocommerce_single_product_summary.

			 *

			 * @hooked woocommerce_template_single_title - 5

			 * @hooked woocommerce_template_single_rating - 10

			 * @hooked woocommerce_template_single_price - 10

			 * @hooked woocommerce_template_single_excerpt - 20

			 * @hooked woocommerce_template_single_add_to_cart - 30

			 * @hooked woocommerce_template_single_meta - 40

			 * @hooked woocommerce_template_single_sharing - 50

			 * @hooked WC_Structured_Data::generate_product_data() - 60

			 */

			do_action( 'woocommerce_single_product_summary' );

		?>

            </div>

          </div>

        </div>
		  
      </div>

    </div>

  </div>

</section>


<?php $descImage = types_render_field("product-description-image",array("url"=>true));?>
<?php $metadata = get_post_meta($product->get_id()); 
	//echo "<pre>"; print_r($metadata['wpcf-product-description-image']);
?>
<?php $desc_image = $metadata['wpcf-product-description-image'][0]; ?>
<section class="beskrivelse">

    <div class="container">

        <div class="beskrivelse-box">

            <div class="row">

                <div class="<?php if(!empty($desc_image)){?>col-md-6 col-sm-6 <?php }?>col-xs-12 item">
<?php //echo $product->get_id(); ?>
                    <div class="beskrivelse-left">

                        <h3>Beskrivelse</h3>

                        <?php echo $product->get_description(); ?>

                        <p></p>

                    </div>

                </div>

				<?php if(!empty($desc_image)){?>

                <div class="col-md-6 col-sm-6 col-xs-12 item">

                    <div class="beskrivelse-right">

                        <img src="<?php echo $desc_image;?>" alt=""/>

                    </div>

                </div>

				<?php }?>

            </div>

        </div>

    </div>

</section>

<?php do_action( 'woocommerce_after_single_product' ); ?>