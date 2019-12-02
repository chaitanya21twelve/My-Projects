<?php

/**

 * Email Addresses

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see 	    https://docs.woocommerce.com/document/template-structure/

 * @author 		WooThemes

 * @package 	WooCommerce/Templates/Emails

 * @version     3.2.1

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



$text_align = is_rtl() ? 'right' : 'left';



?> 

<tr>

  <td align="left" valign="top" style="border: 2px solid #eae3e3;padding-right: 20px; text-align: center; width: 100%; padding: 30px 30px; box-sizing: border-box; background-color: #fff !important; box-shadow:0 0 15px #aaa !important; font-size: 15px;">
    <table width="230" border="0" cellspacing="0" cellpadding="0" align="left" class="table-wrapper">

      <tbody>

        <tr>

          <td align="left" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 14px; line-height: 21px; color: #000000; font-weight: bold;"><?php _e( 'Faktureringsadresse', 'woocommerce' ); ?></td>

        </tr>

        <tr>

          <td align="left" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 14px; line-height: 20px; color: #000000; padding-top: 20px;">

            <?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>

            <?php if ( $order->get_billing_phone() ) : ?>

            <br/>

            <?php echo esc_html( $order->get_billing_phone() ); ?>

            <?php endif; ?>

            <?php if ( $order->get_billing_email() ) : ?>

            <p><?php echo esc_html( $order->get_billing_email() ); ?></p>

            <?php endif; ?></td>

        </tr>

      </tbody>

    </table>

  <!-- </td> -->

 <?php if (  $order->get_formatted_shipping_address() ) { ?>  
 
  <!-- <td align="right" valign="top" style="border: 2px solid #eae3e3;text-align: center; width: 100% !important; padding: 30px 30px; box-sizing: border-box; background-color: #fff; box-shadow:0 0 15px #aaa !important; font-size: 15px;"> -->

    <table width="230" border="0" cellspacing="0" cellpadding="0" align="right" class="table-wrapper">

      <tbody>

        <tr>

          <td align="left" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 14px; line-height: 21px; color: #000000; font-weight: bold;"><?php _e( 'Leveringsadresse', 'woocommerce' ); ?></td>

        </tr>

        <tr>

          <td align="left" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 14px; line-height: 20px; color: #000000; padding-top: 20px;">

            <?php // echo $shipping;

            echo  $shipping = $order->get_formatted_shipping_address() ;  ?>

            <?php if ( $order->get_billing_phone() ) : ?>

            <br/>

            <?php echo esc_html( $order->get_billing_phone() ); ?>

            <?php endif; ?>

            <?php if ( $order->get_billing_email() ) : ?>

            <p><?php echo esc_html( $order->get_billing_email() ); ?></p>

            <?php endif; ?></td>
 
          </td>

        </tr>

      </tbody>

    </table>

    <?php } ?>

  </td>
  
</tr>

