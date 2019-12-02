<?php

/**

 * Single Product Image

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce/Templates

 * @version 3.5.1

 */



defined( 'ABSPATH' ) || exit;



// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {

	return;

}



global $product;



$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );

$post_thumbnail_id = $product->get_image_id();

$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(

	'woocommerce-product-gallery',

	'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),

	'woocommerce-product-gallery--columns-' . absint( $columns ),

	'images',

) );

?>

<?php /*?><div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

	<figure class="woocommerce-product-gallery__wrapper">

		<?php

		if ( $product->get_image_id() ) {

			$html = wc_get_gallery_image_html( $post_thumbnail_id, true );

		} else {

			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';

			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );

			$html .= '</div>';

		}



		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped



		do_action( 'woocommerce_product_thumbnails' );

		?>

	</figure>

</div><?php */?>

<div class="products-slider">

	<div class="w3-content">

		<div class="col-md-3 col-sm-3 col-xs-12 item">

			<div class="w3-row-padding">

				<?php 

				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );
				

				$imagesrc = $image[0];

				//$imagesrc = THEME_URL."/timthumb.php?src=".$imagesrc."&h=71&w=100&zc=1";
				

				?>

				<div class="slid-img">

				<img src="<?php echo $imagesrc;?>" alt="" class="demo w3-opacity w3-hover-opacity-off"  style="width:100%;cursor:pointer" onClick="currentDiv(1)"/>

				</div>

				<?php

				

				

				$attachment_ids = $product->get_gallery_attachment_ids();

				foreach( $attachment_ids as $i=>$attachment_id ) { 

				$imagesrc = wp_get_attachment_url( $attachment_id );
				
				//$imagesrc = THEME_URL."/timthumb.php?src=".$imagesrc."&h=71&w=100&zc=1";
					

				?>

				<div class="slid-img">
					
				
				<img src="<?php echo $imagesrc;?>" data-src="<?php echo wp_get_attachment_url( $attachment_id );?>" alt="" class="demo w3-opacity w3-hover-opacity-off"  style="width:100%;cursor:pointer" onClick="currentDiv(<?php echo ($i+2);?>)"/>

				</div>

				<?php }

				?>

				

				

			</div>

		</div>

		<div class="col-md-9 col-sm-9 col-xs-12 item">

				<img class="mySlides" src="<?php echo $image[0];?>" alt=""  style="width:100%;" />

			<?php 

			$attachment_ids = $product->get_gallery_attachment_ids();

			foreach( $attachment_ids as $i=>$attachment_id ) { 

			?>

			<img class="mySlides" src="<?php echo wp_get_attachment_url( $attachment_id );?>" alt=""  style="width:100%; display:none;" />

			<?php }

			?>

		</div>

	</div>

</div>

