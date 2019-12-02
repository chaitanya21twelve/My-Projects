<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Undy</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800|Poppins:300,400,400i,500,600,700|Roboto:300,400,400i,500,700" rel="stylesheet">
	<style>
	@media screen and (min-width:481px) and (max-width:799px) {
	.main-wrapper {
		width: 100% !important;
	}
	.table-wrapper {
		width: 100% !important;
	}
	.padding {
		padding: 20px !important;
	}
	.padding-T {
		padding-top: 20px !important;
	}
	.padding-B {
		padding-bottom: 20px !important;
	}
	}
	
	@media screen and (max-width:480px) {
	.main-wrapper {
		width: 100% !important;
	}
	.table-wrapper {
		width: 100% !important;
	}
	.padding {
		padding: 20px !important;
	}
	.padding-T {
		padding-top: 20px !important;
	}
	.padding-B {
		padding-bottom: 20px !important;
	}
	}
	</style>
	</head>

	
	
	
	
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="main-wrapper">
				<tr>
					<td align="center" valign="top"><table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="table-wrapper">
						<?php if ( $img = get_option( 'woocommerce_email_header_image' ) ) {?>
						<tr>
						  <td align="center" valign="middle" style="background-repeat: no-repeat; background-position: top center;">
						  	<img src="<?php echo esc_url( $img );?>"/></td>
						</tr>
						<?php }?>
							
							<tr>
								<td align="center" valign="top" style="padding: 50px;" class="padding"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
									<!-- Body -->
									<tbody>
										