<?php

/**

 * My Addresses

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/template-structure/

 * @author  WooThemes

 * @package WooCommerce/Templates

 * @version 2.6.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

}



$customer_id = get_current_user_id();



if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {

	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(

		'billing' => __( 'Billing address', 'woocommerce' ),

		'shipping' => __( 'Shipping address', 'woocommerce' ),

	), $customer_id );

} else {

	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(

		'billing' => __( 'Billing address', 'woocommerce' ),

	), $customer_id );

}



$oldcol = 1;

$col    = 1;

?>

<section class="Oplysninger">

<div class="container">

<div class="Oplysninger-content">

  <h1>Dine oplysninger</h1>

</div>





<div class="item col-md-6 col-sm-6 col-xs-12">

  <div class="Oplysninger-box">

  	<?php $get_addresses = array_reverse($get_addresses,true);
 
        foreach ( $get_addresses as $name => $title ) : ?>

    <div class="Oplysninger-text">

	   <?php
	   
	    if($name == 'shipping'){
	    	echo '<h2>Leveringsadresse </h2>';
	    }elseif($name == 'billing'){
	    	echo '<h2>Faktureringsadress </h2>';
	    }

	   ?>

		<!-- <h2><?php echo $title.$name; ?></h2> -->

			<?php /*?><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php _e( 'Edit', 'woocommerce' ); ?></a><?php */?>

		<p><?php

			$address = wc_get_account_formatted_address( $name );

 			echo $address ? wp_kses_post( $address ) : esc_html_e( 'Det samme som din faktureringsadresse.', 'woocommerce' );

		?></p>

		<button type="button" class="btn" onclick="window.location='<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>'"><?php _e( 'Rediger', 'woocommerce' ); ?></button>

</div>

<?php endforeach; ?>

	

	

  </div>
  <div class="item">

  <div class="Oplysninger-box">

	<div class="Oplysninger-text">

	  <h2>Medlemskab status</h2>


		<br/><p>Se og ret dit medlemskab her</p>

	  <button type="button" class="btn" onclick="window.location='<?php echo site_url().'/my-account/ret-medlemsskab/'; ?>'">Rediger</button>

	</div>

  </div>

</div>

</div>

<?php 

$current_user = wp_get_current_user();

?>

<div class="item col-md-6 col-sm-6 col-xs-12">

  <div class="Oplysninger-box">

	<div class="Oplysninger-text">

	  <h2>Kontooplysninger</h2>

	  <p><?php echo $current_user->user_email;

	  $phone = get_user_meta($current_user_id,'phone_number',true);

	  if(!empty($phone)){

	  	echo "<br>".$phone."<br>";

	  }

	  ?>

		<br/>Kodeord: xxxxxxxxxx</p>

	  <button type="button" class="btn" onclick="window.location='<?php echo esc_url( wc_get_endpoint_url( 'edit-account', $name ) ); ?>'">Rediger</button>

	</div>

  </div>

</div>

<div class="item col-md-6 col-sm-6 col-xs-12">

  <div class="Oplysninger-box">

	<div class="Oplysninger-text">

	  <h2>Betalingsoplysninger</h2>

	  <p>Ret dine betalingsoplysninger her</p>

	  <button type="button" class="btn" onclick="window.location='<?php echo esc_url( wc_get_endpoint_url( 'payment-methods', $name ) ); ?>'">Rediger</button>

	</div>

  </div>

</div>











<?php /*?><p>

	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>

</p><?php */?>



<?php /*?><?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>

	<div class="u-columns woocommerce-Addresses col2-set addresses">

<?php endif; ?>



<?php foreach ( $get_addresses as $name => $title ) : ?>



	<div class="u-column<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> col-<?php echo ( ( $oldcol = $oldcol * -1 ) < 0 ) ? 1 : 2; ?> woocommerce-Address">

		<header class="woocommerce-Address-title title">

			<h3><?php echo $title; ?></h3>

			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php _e( 'Edit', 'woocommerce' ); ?></a>

		</header>

		<address><?php

			$address = wc_get_account_formatted_address( $name );

			echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );

		?></address>

	</div>



<?php endforeach; ?>



<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>

	</div>

<?php endif;<?php */?>



</div>

</section>