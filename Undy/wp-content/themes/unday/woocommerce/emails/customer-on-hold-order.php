<?php

/**

 * Customer on-hold order email

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce/Templates/Emails

 * @version 3.5.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



/*

 * @hooked WC_Emails::email_header() Output the email header

 */

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>







<tr>

  <td align="center" valign="top" style="padding: 0 85px;" class="padding" ><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

      <tbody>

        <tr>

        <!--   <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #000000; font-weight:900;"><?php printf( esc_html__( 'Hej %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></td> -->

          <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #000000; font-weight:900;">Tusind tak for din bestilling</td>

        </tr>

		<tr>

          <td align="center" valign="top" style="font-family: 'Poppins',sans-serif;font-size: 14px;line-height: 20px;color: #000000;font-weight: normal;padding: 18px 0;"><?php printf( esc_html__( 'Vi bekræfter hermed, at vi har modtaget din ordre. Lige så snart vi har ekspederet din bestilling, sender vi dig en mail, hvor du har mulighed for at spore din pakke. Vi forventer, at du modtager din Undy-boks inden for 1-2 dage.', 'woocommerce' ), esc_html( $order->get_order_number() ) ); ?></td>

        </tr>

      </tbody>

    </table></td>

</tr>

<tr>

  <td height="1" bgcolor="#c5c5c5" style="font-size: 0px; line-height: 0px;">&nbsp;</td>

</tr>

<tr>

  <?php if (wcs_order_contains_subscription($order->get_id())) { ?>

  <td style="padding: 30px 52px 55px;" class="padding">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tbody>

              <tr>

                <td align="center" valign="top"><img src="<?php echo get_bloginfo('template_url');?>/images/email_icon.png" width="314" height="221" alt="" style="display: block;width: 145px;" border="0"/></td>

              </tr>

              <tr>

                <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #000000; font-weight: 900;">Første medlemsperiode starter om 10 dage</td>

              </tr>

              <tr>

                <td align="center" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 14px; line-height: 19px; color: #000000; padding: 30px 0 20px;">Du kan allerede nu tilpasse din Undy-boks. Ved at logge ind på din profil, har du mulighed for vælge dine fortrukne par underbukser, der kommer i mere end 16 forskellige farver og print. </td>

              </tr> 

            </tbody>

          </table>  

       </td>

     <?php }else{ ?>

     <?php } ?>

</tr>

<?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?> 



<tr>

  <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >

	  <tbody>

	  	<?php 

		do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

		/*

		 * @hooked WC_Emails::order_meta() Shows order meta data.

		 */

		do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

		?>

		

		

		<tr>

		  <td height="20" >&nbsp;</td>

		</tr>

		<tr>

      <!-- style="/*border: 1px solid #e1e1e1; padding: 36px 45px 40px 34px;*/ box-shadow: 1px 4px 18px 6px #e7e7e7;" -->
		  <td align="center" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">

			  <tbody>

			  	<?php 

				/*

				 * @hooked WC_Emails::customer_details() Shows customer details

				 * @hooked WC_Emails::email_address() Shows email address

				 */

				do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );



				?>

				

			  </tbody>

			</table></td>

		</tr>

	  </tbody>

	</table></td>

</tr>



<?php



/*

 * @hooked WC_Emails::email_footer() Output the email footer

 */

do_action( 'woocommerce_email_footer', $email );

