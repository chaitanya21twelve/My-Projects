<?php
/**
 * The template for the waitlist in stock notification email (HTML)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/waitlist-mailout.php.
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
do_action( 'woocommerce_email_header', $email_heading, $user->user_email ); ?>

<p><?php echo _x( "Hi There,", 'Email salutation', 'woocommerce-waitlist' ); ?></p>

<p>
	<?php printf( __( '%s is now back in stock at %s. ', 'woocommerce-waitlist' ), $product_title, get_bloginfo( 'name' ) );
	_e( 'You have been sent this email because your email address was registered on a waitlist for this product.', 'woocommerce-waitlist' ); ?>
</p>
<p>
	<?php printf( __( 'If you would like to purchase %s please visit the following link: %s', 'woocommerce-waitlist' ), $product_title, '<a href="' . $product_link . '">' . $product_link . '<a>' ); ?>
</p>

<?php if ( WooCommerce_Waitlist_Plugin::persistent_waitlists_are_disabled( $product_id ) && ! $triggered_manually ) {
	echo '<p>' . __( 'You have been removed from the waitlist for this product', 'woocommerce-waitlist' ) . '</p>';
}
do_action( 'woocommerce_email_footer', $user->user_email ); ?>
