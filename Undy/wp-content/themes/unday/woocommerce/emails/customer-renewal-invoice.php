<?php
/**
 * Customer renewal invoice email
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

<?php if ( 'pending' == $order->get_status() ) : ?>
	<p style="font-family: 'Nunito', sans-serif;text-align: center;font-size:18px;">
		<?php
			echo wp_kses( sprintf( _x( 'Der er oprettet en faktura for at fornye dit abonnement med %1$s. For at betale for denne faktura skal du bruge følgende link:', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ))); ?>
	</p>
	<p style="text-align: center;">
		<?php echo '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '" style="font-weight:normal;font: bold 18px Arial;text-decoration:none;background-color:#2B9F30;color:#ffffff;padding: 12px 30px;text-align:center;margin: 25px 0 35px 0;display: inline-block;">' . esc_html__( 'Opdater dine kortoplysninger her', 'woocommerce-subscriptions' ) . '</a>'; 
		?>
	</p>
<?php elseif ( 'failed' == $order->get_status() ) : ?>
	<div style="text-align: center;">
	<p style="font-family: 'Nunito', sans-serif;text-align: center;font-size:18px;">
		<?php printf( esc_html__( 'Hej %s', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?>
	</p>
	<p style="font-family: 'Nunito', sans-serif;text-align: center;font-size:18px;">
		<?php
		// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
		echo wp_kses( sprintf( _x( "Vi har forsøgt at forny dit medlemskab hos Undy.dk, så du kan få nogle friske Undy's tilsendt!", 'woocommerce-subscriptions' ))); ?></p>
		<p style="font-family: 'Nunito', sans-serif;text-align: center;font-size:18px;"><?php echo wp_kses( sprintf( _x( "Desværre gik der noget galt :(", 'woocommerce-subscriptions' )));?></p>
		<?php echo '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '" style="font-weight:normal;font: bold 18px Arial;text-decoration:none;background-color:#2B9F30;color:#ffffff;padding: 12px 30px;text-align:center;margin: 25px 0 10px 0;display: inline-block;">' . esc_html__( 'Opdater dine kortoplysninger her', 'woocommerce-subscriptions' ) . '</a>'; ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
