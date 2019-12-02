<?php
/**
 * Customer completed subscription change email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>
	<?php
	// translators: placeholder is the name of the site
	printf( esc_html__( 'Hej. Du har ændret dine abonnementselementer med succes %s. Dine nye ordre- og abonnementsoplysninger vises nedenfor til reference:', 'woocommerce-subscriptions' ), esc_html( get_option( 'blogname' ) ) );
	?>
</p>

<?php do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2><?php echo esc_html__( 'Nye abonnementsoplysninger', 'woocommerce-subscriptions' ); ?></h2>
<?php foreach ( $subscriptions as $subscription ) : ?>
	<?php do_action( 'woocommerce_subscriptions_email_order_details', $subscription, $sent_to_admin, $plain_text, $email ); ?>
<?php endforeach; ?>

<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
