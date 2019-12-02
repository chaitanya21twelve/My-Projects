<?php

/**

 * Variable product add to cart

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce/Templates

 * @version 3.4.1

 */



defined( 'ABSPATH' ) || exit;



global $product;



$attribute_keys = array_keys( $attributes );



do_action( 'woocommerce_before_add_to_cart_form' ); ?>



<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ); // WPCS: XSS ok. ?>">

	<?php do_action( 'woocommerce_before_variations_form' ); ?>



	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php else : ?>

		<div class="storrelse">

		<table class="variations" cellspacing="0">

			<tbody>

				<?php foreach ( $attributes as $attribute_name => $options ) : ?>

					<tr>

						<td class="label">

						

						<h3><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></h3><p  class="icon-plus-sign">Størrelsesguide</p>

						

						</td>

						<td class="value">

							<?php

								wc_dropdown_variation_attribute_options( array(

									'options'   => $options,

									'attribute' => $attribute_name,

									'product'   => $product,

								) );

								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" style="float:left;">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';

							?>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

</div>







<?php 

$upsells = $product->get_upsells();

array_unshift($upsells, get_the_ID());

sort($upsells);

$currentPID = get_the_ID();

$meta_query = WC()->query->get_meta_query();

$args = array(

    'post_type'           => 'product',

    'ignore_sticky_posts' => 1,

    'no_found_rows'       => 1,

    'posts_per_page'      => -1,

    'orderby'             => 'post__in',

    'order'               => 'asc',

    'post__in'            => $upsells,

    //'post__not_in'        => array( $product->get_id() ),

    'meta_query'          => $meta_query

);



$products = new WP_Query( $args );



// $woocommerce_loop['columns'] = $columns;



if ( $products->have_posts() ) : 

	$allSimilarProducts = array();

	$k = 0;

	while ( $products->have_posts() ) : $products->the_post();

		$allSimilarProducts[$k]['id'] = get_the_ID();

		$allSimilarProducts[$k]['color_image'] = types_render_field("product-color-image",array("url"=>true));

		$allSimilarProducts[$k]['title'] = get_the_title();

		$allSimilarProducts[$k]['link'] = get_the_permalink();

	$k++;endwhile;

	$allSimilarProducts = array_chunk($allSimilarProducts,4);

	$metadata = get_post_meta($product->get_id());
	
?>

<div class="farve">

	<h3>Farve: <?php echo $metadata['wpcf-product-color-title'][0]; ?></h3>

	<?php foreach($allSimilarProducts as $allSimilarProduct){?>

	<ul>

<?php foreach($allSimilarProduct as $allSimilarProductt){?>

	<li <?php if($currentPID == $allSimilarProductt['id']){?> class="current"<?php }?> style="display:inline-block;"><a style="background: url('<?php echo $allSimilarProductt['color_image'];?>') center no-repeat;background-size: cover; " href="<?php echo $allSimilarProductt['link'];?>" title="<?php echo $allSimilarProductt['title'];?>"></a></li>

<?php } ?>

<?php }?>

</ul>

</div>

<?php endif;?>			























		<div class="single_variation_wrap">

			<?php

				/**

				 * Hook: woocommerce_before_single_variation.

				 */

				do_action( 'woocommerce_before_single_variation' );



				/**

				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.

				 *

				 * @since 2.4.0

				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.

				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.

				 */

				do_action( 'woocommerce_single_variation' );



				/**

				 * Hook: woocommerce_after_single_variation.

				 */

				do_action( 'woocommerce_after_single_variation' );

			?>

		</div>

	<?php endif; ?>



	<?php do_action( 'woocommerce_after_variations_form' ); ?>

</form>



<?php

do_action( 'woocommerce_after_add_to_cart_form' );

