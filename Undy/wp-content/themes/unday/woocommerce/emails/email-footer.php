<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
</tbody>
<!-- End Body -->
</table>
</td>
</tr>

<tr>
  <td align="center" bgcolor="#0e202d" valign="top"  style="padding: 0 40px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tbody>
        <tr>
          <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #ffffff; font-weight: 900; padding: 42px 0 7px;">Følg med lige her</td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="<?php echo get_bloginfo('template_url');?>/images/down_arrow.png" width="37" height="45" alt="" style="display: block;" border="0"/></td>
        </tr>
        <tr>
          <td align="center" valign="top" style="padding: 12px 0 50px;"><table border="0" cellspacing="0" cellpadding="0" align="center" >
              <tbody>
                <tr>
                  <td align="center" valign="top"><a href="<?php echo of_get_option('fb_url');?>" target="_blank"><img src="<?php echo get_bloginfo('template_url');?>/images/fb_icon.jpg" width="66" height="69" alt="" style="display: block;" border="0"/></a></td>
                  <td width="12">&nbsp;</td>
                  <td align="center" valign="top"><a href="<?php echo of_get_option('insta_url');?>" target="_blank"><img src="<?php echo get_bloginfo('template_url');?>/images/insta_icon.jpg" width="66" height="69" alt="" style="display: block;" border="0"/></a></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 25px; line-height: 28px; color: #ffffff; font-weight: 900; ">Kontakt os</td>
        </tr>
        <tr>
          <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 31px; line-height: 34px; color: #ffffff; font-weight: 900; padding: 38px 0 7px;color: #15c;text-decoration: underline;">42 90 50 40</td>
        </tr>
        <tr>
          <td align="center" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 12px; line-height: 15px; color: #ffffff; font-weight: bold; ">Alle hverdage: 11.00-15.00</td>
        </tr>
        <tr>
          <td align="center" valign="top" style="font-family: 'Poppins', sans-serif; font-size: 31px; line-height: 34px; color: #ffffff; font-weight: 900; padding: 38px 0 7px;">hej@undy.dk</td>
        </tr>
        <tr>
          <td align="center" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 12px; line-height: 15px; color: #ffffff; font-weight: bold; padding-bottom: 40px; ">Alle ugens dage, hele året</td>
        </tr>
        <tr>
          <td height="2" bgcolor="#ffffff" style="font-size: 0px; line-height: 0px;">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top" style="font-family: 'Nunito', sans-serif; font-size: 16px; line-height: 20px; color: #ffffff; font-weight: 400; padding: 30px 0 15px; ">Undy ApS<br>
            CVR: 39843811 </td>
        </tr>
      </tbody>
    </table></td>
</tr>
<?php /*?><tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit">
															<?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr><?php */?>
</td>
</tr>
</table>
</body></html>