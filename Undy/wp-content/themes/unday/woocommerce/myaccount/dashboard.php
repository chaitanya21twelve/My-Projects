<?php

/**

 * My Account Dashboard

 *

 * Shows the first intro screen on the account dashboard.

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see         https://docs.woocommerce.com/document/template-structure/

 * @author      WooThemes

 * @package     WooCommerce/Templates

 * @version     2.6.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

}

?>

<!-- 
<section class="Velkommen" style="background-image: url(<?php echo site_url();?>/wp-content/uploads/2019/01/forside_undy_sektion.png); background-repeat: no-repeat;background-size: cover; padding: 25px;"> -->

<section class="Velkommen">

  <div class="container-fluid">

    <div class="row">

      <div class="item col-md-6 col-sm-6 col-xs-12">

        <div class="Velkommen-left"> <img src="<?php echo site_url();?>/wp-content/uploads/2019/01/forside_undy_sektion.png" alt="Product" /> </div>

      </div>

      <div class="item  col-md-6 col-sm-6 col-xs-12">

        <div class="Velkommen-right">

          <div class="Velkommen-text">

          	<?php 
          	$username = $current_user->display_name;

          	 if(!empty($current_user->user_firstname)){

          	 	$username = $current_user->user_firstname;
           	 }


          	?>

            <h2>Hej <?php echo '<strong>' . esc_html( $username ) . '</strong>';?></h2>

            <p>Velkommen til din konto. Her har du mulighed for at ændre i dit medlemskab, vælge hvilke underbukser du ønsker ved din næste forsendelse, rette i dine oplysninger samt se alle dine tidligere ordrer.</p>

            <?php 
            if(is_user_logged_in()){
  
            $subscriptions = get_posts( array(
                'numberposts' => -1,
                'post_type'   => 'shop_subscription', // Subscription post type
                'post_status' => 'wc-active', // Active subscription
                'order' => 'ASC',
                'meta_key'    => '_customer_user',
                'meta_value'  => get_current_user_id(),
            ) );

            if($subscriptions){

                echo '<h3> Medlemskab </h3>';
 
                $next_date= array();        

                foreach ($subscriptions as $key => $subscriptions_obj) {
   
                  $next_date[$subscriptions_obj->ID] = get_post_meta( $subscriptions_obj->ID, '_schedule_next_payment', true );
                }
                
                if(count($next_date) > 0){

                  $mostRecent= 0;

                  $now = strtotime(date('Y-m-d H:i:s'));
                 

                  foreach($next_date as $idd => $date){

                    if($mostRecent == 0){

                      $mostRecent = strtotime($date);
                      $subscription_id = $idd;
                    }
                    if( $mostRecent > strtotime($date)){

                       $mostRecent = strtotime($date);

                       $subscription_id = $idd;
                    }

                  }

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

                  $month = date('F', $mostRecent);

                  echo '<p>Næste levering bliver sendt d. '.date('d ', $mostRecent) . $months[$month];'</p>';

                  if(!empty($subscription_id)){
                     $subscription = wcs_get_subscription( $subscription_id );
                     $items = $subscription->get_items();
                     echo '<div class="my_account_item"><h4>Din næste Undy-boks</h4><ul>';

                     foreach ( $items as $itemID => $item ) {

                        $product_name = $item['name'];
                        $product_id = $item['product_id'];
                        $quantity = $item['quantity'];
                        $variation_id = $item['variation_id'];

                        $color_name =  get_post_meta( $product_id, 'wpcf-product-color-title', true);
                        $image = get_the_post_thumbnail_url($product_id,'full');

                        echo '<li>
                                <div class="item-box">
                                  <input type="text" class="form-control input-number" value="'.$quantity.'" min="1" max="100">
                                   <img src="'.$image.'" alt="" style="width: 100px;height:132px;" title="Marineblå boxershorts"><div class="item-tittle" style="margin-top: -15px;">'.$color_name.'</div>
                               </div>
                            </li>';
 
                     }
                     echo '</ul></div>';
                     echo '<a class="button" href="'.site_url().'/my-account/subscription-box/" style="padding: 10px 50px; margin-top: 5px; ">Rediger din Undy-boks</a>';
                  } 
                }else{
                  echo  '<p>Næste levering på vent</p>';
                }             
              }

            }else{

              echo '<h3>Bruger</h3>';

            }

            ?>
            

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<style>
@media screen and (max-width: 900px){
  .my_account_item ul li {
      margin: 0;
  }
}
.item-box {
    width: 118px;
    height: 168px;
    margin: 10px;
    padding: 0 0 0 0;
    text-align: center;
    display: inline-block;
    box-sizing: border-box;
    background-color: #fff;
    box-shadow: 0 0 15px #aaa;
    border: 8px solid transparent;
}
input.input-number {
    position: absolute;
    background: #0e202d;
    color: #ffffff;
    font-weight: 700;
    width: 25px;
    height: 25px;
    text-align: center;
    line-height: 50px;
    padding: 0;
    border-radius: 100%;
    -webkit-appearance: none;
    top: 6px;
    right: 6px;
    border: 0;
    font-size: 17px;
}
.quantity_box {
    display: inline-block;
    width: 100%;
    text-align: center;
    position: absolute;
    left: 0;
    bottom: -10px;
}
.my_account_item .item-tittle {
    font-family: "Nunito", sans-serif;
    font-size: 16px;
    line-height: 25px;
    color: #000000;
    font-weight: 400;
}
</style>