<?php
/**
 * Admin new renewal order email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<p><?php
	// translators: $1: customer's billing first name and last name
	printf( esc_html_x( 'Du har modtaget en ordrefornyelsesordre fra %1$s. Deres ordre er som følger:', 'Brugt i admin e-mail: ny fornyelsesordre', 'woocommerce-subscriptions' ), esc_html( $order->get_formatted_billing_full_name() ) );
	?>
</p>
<?php

/**
 * @hooked WC_Subscriptions_Email::order_details() Shows the order details table.
 * @since 2.1.0
 */
do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_footer', $email );
?>
