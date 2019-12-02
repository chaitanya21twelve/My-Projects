<?php

/**

 * Order details table shown in emails.

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce/Templates/Emails

 * @version 3.3.1

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



$text_align = is_rtl() ? 'right' : 'left';



//do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>



<tr>

  <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #000000; font-weight: 900; padding: 30px 0;">

    Ordredetaljer

  <?php

	if ( $sent_to_admin ) {

		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';

		$after  = '</a>';

	} else {

		$before = '';

		$after  = '';

	}

	/* translators: %s: Order ID. */

	/*echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
*/

  // echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), date("j. F, Y", strtotime( $order->get_date_created())), date("j. F, Y", strtotime( $order->get_date_created() ) ) ) );



	?>

  </td>

</tr>

<tr>

  <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="table-wrapper">

      <tbody>

        <tr>

          <td align="center" valign="top" style="border: 2px solid #eae3e3; padding: 23px 5px 26px 42px; text-align: center; width: 100%; box-sizing: border-box; background-color: #fff; box-shadow: 0 0 15px #aaa; font-size: 14px; "><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tbody>

                <tr>

                  <td>
                    <table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0 !important;" border="0">

                      <?php /*?><thead>

                        <tr>

                          <th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>; border:0; padding:10px;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>

                          <th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;border:0; padding:10px;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>

                          <th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;border:0; padding:10px;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>

                        </tr>

                      </thead><?php */?>

                      <tbody>

                        <tr>
                          <td style=" text-align: left; font-size: 17px; font-weight: 800; color: #000;">Ordre: #<?php echo $order->get_id(); ?></td>
                        </tr>

                        <?php

			echo wc_get_email_order_items( $order, array( // WPCS: XSS ok.

				'show_sku'      => $sent_to_admin,

				'show_image'    => false,

				'image_size'    => array( 32, 32 ),

				'plain_text'    => $plain_text,

				'sent_to_admin' => $sent_to_admin,

			) );

			?>

                      </tbody>

                      <tfoot>

                        <?php

			$totals = $order->get_order_item_totals();



			if ( $totals ) {

				$i = 0;

				foreach ( $totals as $total ) {

					$i++;

					?>

                        <tr>

                          <th class="td" scope="row" style="border:0;text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 0px;' : ''; ?>"><?php echo wp_kses_post( $total['label'] ); ?></th>

                          <td class="td" style="border:0;text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 0px;' : ''; ?>"><?php echo wp_kses_post( $total['value'] ); ?></td>

                        </tr>

                        <?php

				}

			}

			if ( $order->get_customer_note() ) {

				?>

                        <tr>

                          <th class="td" scope="row" colspan="2" style="border:0;text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>

                          <td class="td" style="border:0;text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( wptexturize( $order->get_customer_note() ) ); ?></td>

                        </tr>

                        <?php

			}

      $next_payment = get_post_meta( $order->get_id(), 'subscription_next_payment', true );

      if( !empty($next_payment)){

         $months = array(
                            'January' => 'januar',
                            'February' => 'februar',
                            'March' => 'marts',
                            'April' => 'april',
                            'May' => 'maj',
                            'June' => 'juni',
                            'July' => 'juli',
                            'August' => 'august',
                            'September' => 'september',
                            'October' => 'oktober',
                            'November' => 'november',
                            'December' => 'december', 
                             );

             $month = date('F', strtotime($next_payment));

			?>


                      <tr>
                          <td colspan="3" style="text-align: left;padding: 12px 6px;"><strong>Medlemsskab hver 3 måned </strong>
                            <div><small>Første fornyelse bliver sendt afsted: <?php echo date('j. ', strtotime($next_payment)); echo $months[$month]; echo date(' Y', strtotime($next_payment)); ?></small></div>
                        </td>

                      </tr>

                    <?php } ?>



                      </tfoot>

                    </table></td>

                </tr>

              </tbody>

            </table></td>

        </tr>

      </tbody>

    </table></td>

</tr>
<br>

<?php //do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

