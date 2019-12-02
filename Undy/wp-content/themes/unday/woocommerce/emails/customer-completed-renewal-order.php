<?php
/**
 * Customer completed renewal order email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); 

$custom = get_post_meta( $order->get_id() );
$package_number = $custom['package_number'][0];

?>

<div style="width: 100%;">
        <h1 align="center" valign="top" style="font-family:'Poppins',sans-serif;font-size:25px;line-height:28px;color:#000000;font-weight:900;text-align: center;">Din pakke er nu på vej</h1>
<p align="center" valign="top" style="font-family:'Poppins',sans-serif;font-size:14px;line-height:20px;color:#000000;font-weight:normal;padding:18px 0;text-align: center;">Vi bekræfter hermed, at din forsendelse er på vej. Du kan følge din <br> pakke lige <a data-id="<?php echo $order->get_id(); ?>" href="http://www.dao.as/?stregkode=<?php echo $package_number; ?>#trackandtrace">her</a></p>
    <hr>
<img src="<?php echo site_url(); ?>/wp-content/uploads/2019/01/abonnement_tab.png" width="314" height="221" alt="" border="0" style="border:none;display:block;font-size:14px;font-weight:bold;height:auto;outline:none;text-decoration:none;text-transform:capitalize;vertical-align:middle;padding: 24px 24%;" class="CToWUd a6T" tabindex="0">
     <h1 align="center" valign="top" style="font-family:'Poppins',sans-serif;font-size:25px;line-height:28px;color:#000000;font-weight:900;text-align: center;">Tilpas din næste Undy box</h1>
<p align="center" valign="top" style="font-family:'Poppins',sans-serif;font-size:14px;line-height:20px;color:#000000;font-weight:normal;padding:18px 0;text-align: center;">Husk at du til enhver tid har mulighed for at logge ind på din konto og <br> tilpasse din næste levering. Her kan du både ændre underbukse model,<br> størrelse og design.</p>

    <hr>      
 </div>
<p>
	<?php
	// translators: placeholder is the name of the site
	/*printf( esc_html__( 'Hi there. Your subscription renewal order with %s has been completed. Your order details are shown below for your reference:', 'woocommerce-subscriptions' ), esc_html( get_option( 'blogname' ) ) );*/
	?>
</p>

<?php do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
