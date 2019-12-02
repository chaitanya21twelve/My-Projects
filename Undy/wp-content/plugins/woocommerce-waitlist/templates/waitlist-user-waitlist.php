<?php
/**
 * The template for displaying the current users list of products they are on the waitlist for
 * By default, this is displayed on the "Your Waitlists" tab within the "My Account" section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/waitlist-user-waitlist.php.
 *
 * HOWEVER, on occasion WooCommerce Waitlist will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @version 1.9.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wc_print_notices();
?>
<noscript>
	<p><?php printf(  __( 'It appears you have disabled Javascript. To use the waitlist features you must %senable Javascript in your browser%s' ), '<a href="https://www.enable-javascript.com/">', '</a>' ); ?></p>
</noscript>
<h2 class="my_account_titles wcwl_nojs" id="wcwl_my_waitlist"><?php echo apply_filters( 'wcwl_shortcode_title', $title ); ?> </h2>
<div class="waitlist-user-waitlist-wrapper wcwl_nojs">
	<?php if ( is_array( $products ) && ! empty( $products ) ) { ?>
		<p><?php echo apply_filters( 'wcwl_shortcode_intro_text', __( 'You are currently on the waitlist for the following products.', 'woocommerce-waitlist' ) ); ?></p>
		<div class="waitlist-products">
			<?php foreach ( $products as $product ) { ?>
				<?php $title = apply_filters( 'wcwl_shortcode_product_title', esc_html( $product->get_name() ), $product ); ?>
				<div class="waitlist-single-product">
					<a href="<?php echo $product->get_permalink(); ?>">
						<h4 class="waitlist-title-link"><?php echo $title; ?></h4>
						<span class="waitlist-thumbnail"><?php echo apply_filters( 'wcwl_shortcode_thumbnail', $product->get_image(), $product ); ?></span>
					</a>
					<p style="text-align: center">
						<a href="#" rel="nofollow" class="wcwl_remove_product" data-nonce="<?php echo wp_create_nonce( 'wcwl-ajax-remove-user-nonce' ); ?>" data-product-id="<?php echo $product->get_id(); ?>" data-url="<?php echo Pie_WCWL_Frontend_User_Waitlist::get_remove_link( $product ); ?>">
							<?php echo apply_filters( 'wcwl_shortcode_remove_text', __( 'Remove me from this waitlist', 'woocommerce-waitlist' ) ); ?>
						</a>
					</p>
					<div class="spinner"></div>
					<hr>
				</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<p><?php echo apply_filters( 'wcwl_shortcode_no_waitlists_text', __( 'You have not yet joined the waitlist for any products.', 'woocommerce-waitlist' ) ); ?></p>
		<p><?php echo apply_filters( 'wcwl_shortcode_visit_shop_text', sprintf( __( '%sVisit shop now!%s', 'woocommerce-waitlist' ), '<a href="' . wc_get_page_permalink( 'shop' ) . '">', '</a>' ) ); ?></p>
		<hr>
	<?php } ?>
</div>

<?php if ( is_array( $archives ) && ! empty( $archives ) ) { ?>
	<div class="waitlist-user-waitlist-archive-wrapper">
		<p><?php echo apply_filters( 'wcwl_shortcode_archive_intro_text', __( 'Your email address is also stored on an archived waitlist for the following products:', 'woocommerce-waitlist' ) ); ?></p>
		<ul class="waitlist-archives">
			<?php foreach ( $archives as $archive ) { ?>
				<?php $product = wc_get_product( $archive->post_id ); ?>
				<li><?php echo apply_filters( 'wcwl_shortcode_archive_product_title', $product->get_name(), $product ); ?></li>
			<?php } ?>
		</ul>
		<p>
			<a href="#" rel="nofollow" id="wcwl_remove_archives" data-nonce="<?php echo wp_create_nonce( 'wcwl-ajax-remove-user-archive-nonce' ); ?>" data-url="<?php echo Pie_WCWL_Frontend_User_Waitlist::get_unarchive_link(); ?>">
				<?php echo apply_filters( 'wcwl_shortcode_archive_remove_text', __( 'Remove my email from all waitlist archives', 'woocommerce-waitlist' ) ); ?>
			</a>
		</p>
	</div>
<?php } ?>