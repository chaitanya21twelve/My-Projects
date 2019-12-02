<?php



/**



 * Checkout Form



 *



 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.



 *



 * HOWEVER, on occasion WooCommerce will need to update template files and you



 * (the theme developer) will need to copy the new files to your theme to



 * maintain compatibility. We try to do this as little as possible, but it does



 * happen. When this occurs the version of the template file will be bumped and



 * the readme will list any important changes.



 *



 * @see https://docs.woocommerce.com/document/template-structure/



 * @package WooCommerce/Templates



 * @version 3.5.0



 */







if ( !defined( 'ABSPATH' ) ) {



	exit;



}


do_action( 'woocommerce_before_checkout_form', $checkout );


// If checkout registration is disabled and not logged in, the user cannot checkout.



if ( !$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in() ) {



	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );



	return;



}

?>



<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="col2-set" id="customer_details">

		<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col-1">

			<?php do_action( 'woocommerce_checkout_billing' ); ?>

			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			
			<div class="after_additional_field">
				<p>*Gælder kun alle hverdage og der tages forbehold for udsolgte varer, som kan give længere leveringstid</p>
			</div>

		</div>
		
		

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>

		<div class="col-2">

			<h3 id="order_review_heading">
				<?php esc_html_e( 'Din indkøbskurv', 'woocommerce' ); ?>
			</h3>

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>


			<div id="order_review" class="woocommerce-checkout-review-order">


				<?php do_action( 'woocommerce_checkout_order_review' ); ?>

				<?php 

					$date = date("H");

					if($date <= 14.30){

				?>

				<br><br>

				<div class="timer">

					<b>Vi sender din pakke om: </b><span id='time'></span>

				</div>
				
				<?php }?>

				<br><br>

				<div class="ck_widget" style="border: 1px solid; padding: 15px;">

					<?php dynamic_sidebar("checkout_page_widget"); ?>

				</div>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

		</div>

	</div>

	<?php 

if($date <= 14.30){

?>



	<script>
		( function () {

			var start = new Date;

			//var start = new Date().toLocaleString("en-US", {timeZone: "America/New_York"});

			//alert(start);

			start.setHours( 14.30, 0, 0 ); // 5pm



			function pad( num ) {

				return ( "0" + parseInt( num ) ).substr( -2 );

			}



			function tick() {

				var now = new Date;

				//alert(now);

				if ( now > start ) { // too late, go to tomorrow

					start.setDate( start.getDate() + 1 );

				}

				var remain = ( ( start - now ) / 1000 );

				var hh = pad( ( remain / 60 / 60 ) % 60 );

				var mm = pad( ( remain / 60 ) % 60 );

				var ss = pad( remain % 60 );

				document.getElementById( 'time' ).innerHTML = hh + "t : " + mm + "m : " + ss + "s";



				if ( hh >= 14.30 ) {

					if ( mm > 0 ) {

						$( "#timer" ).remove();

					}

				}





				setTimeout( tick, 1000 );

			}



			document.addEventListener( 'DOMContentLoaded', tick );

		} )();
                
                jQuery(document).ready(function (){
                    jQuery('.mc4wp-checkbox').find('label').addClass('custom_check');
                    jQuery('.mc4wp-checkbox').find('label').append('<span class="checkmark"></span>');

                    if($("#checkout_img_dk").length == 0) {
                        var myVar =   setInterval(frame, 3000);                   
                    }
                   function frame() {
                   	jQuery("#checkout_img_dk").remove();
                   	var url = '<?php echo site_url(); ?>';
                   	jQuery("label[for='payment_method_stripe']").append('<img id="checkout_img_dk" src="'+url+'/wp-content/themes/unday/images/dankort_icon.png" class="stripe-visa-icon stripe-icon" alt="Visa">');
                   	clearInterval(myVar);

                   }

	                });

               
	</script>

	<?php }?>







</form>







<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>