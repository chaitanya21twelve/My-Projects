<?php

/**

 * Customer invoice email

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.

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



/**

 * Executes the e-mail header.

 *

 * @hooked WC_Emails::email_header() Output the email header

 */

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>



<tr>

  <td align="center" valign="top" style="padding: 0 85px;" class="padding" ><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

      <tbody>

        <tr>

          <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #000000; font-weight:900;"><?php printf( esc_html__( 'Hej %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></td>

        </tr>

		<tr>

          <td align="center" valign="top" style="font-family: 'Poppins',sans-serif;font-size: 14px;line-height: 20px;color: #000000;font-weight: normal;padding: 18px 0;"><?php if ( $order->has_status( 'pending' ) ) { ?>

		<p>

		<?php

		printf( esc_html__( 'Der er oprettet en ordre til dig den %1$s. Din faktura er nedenfor, med et link til betaling, når du er klar:', 'woocommerce' ), esc_html( get_bloginfo( 'name', 'display' ) ));

		?>

		</p>

		<p style="text-align: center;">
			<?php echo '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '" style="font-weight:normal;font: bold 18px Arial;text-decoration:none;background-color:#2B9F30;color:#ffffff;padding: 12px 30px;text-align:center;margin: 25px 0 35px 0;display: inline-block;">' . esc_html__( 'Opdater dine kortoplysninger her', 'woocommerce-subscriptions' ) . '</a>'; 
			?>
		</p>

<?php } else { ?>

	<?php

		/* translators: %s Order date */

		printf( esc_html__( 'Hermed fremsender vi informationer om din ordre foretaget d. %s. %s', 'woocommerce' ), esc_html( wc_format_datetime( $order->get_date_created() ) ) , esc_html('Du vil modtage en email, lige så snart vi har pakket din ordre. Tak for din bestilling.'));

	?>

<?php

}?></td>

        </tr>

      </tbody>

    </table></td>

</tr>

<tr>

  <td height="1" bgcolor="#c5c5c5" style="font-size: 0px; line-height: 0px;">&nbsp;</td>

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



/**

 * Executes the email footer.

 *

 * @hooked WC_Emails::email_footer() Output the email footer

 */

do_action( 'woocommerce_email_footer', $email );

