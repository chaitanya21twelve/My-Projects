<?php
/**
 * AccountClass
 *
 * The AccountClass Class.
 *
 * @class    AccountClass
 * @parent BaseProduct
 * @category Class
 * @author   Codingkart
 */  
class MainAccount 
{	

 /**
   * Product Category for the Product Category class
   * Sets up all the appropriate hooks and actions
   * 
   */ 
	public function __construct(){

        // create account endpoint
	    add_action( 'init', array($this,'addWineClubWcEndpoint'));

		add_filter( 'woocommerce_account_menu_items', array($this,'WineClubWcAccountMenuItems'));	
	 
		add_action( 'woocommerce_account_subscription-box_endpoint', array($this,'subscription_box_setting_endpoint_callback'));

		add_action( 'woocommerce_account_invite-friend_endpoint', array($this,'invite_friend_setting_endpoint_callback'));
        
   }

	public function has_active_subscription( $user_id=null ) {

	    // if the user_id is not set in function argument we get the current user ID
	    if( null == $user_id )
	        $user_id = get_current_user_id();

	    // Get all active subscrptions for a user ID
	    $active_subscriptions = get_posts( array(
	        'numberposts' => -1,
	        'meta_key'    => '_customer_user',
	        'meta_value'  => $user_id,
	        'post_type'   => 'shop_subscription', // Subscription post type
	        'post_status' => 'wc-active', // Active subscription

	    ) );
	    // if
	    if(!empty($active_subscriptions)) return true;
	    else return false;
	}


   
   public function addWineClubWcEndpoint() {

	    add_rewrite_endpoint( 'subscription-box', EP_ROOT | EP_PAGES );
	    add_rewrite_endpoint( 'invite-friend', EP_ROOT | EP_PAGES );
	 
	}

	/**
	* Insert the new endpoint into the My Account menu.
	*
	* @param array $items
	* @return array
	*/
	public function WineClubWcAccountMenuItems( $items ) {

		$items[ 'dashboard' ] = 'Velkommen';
		$items[ 'orders' ] = 'Ordrehistorik';
		$items[ 'edit-address' ] = 'Oplysninger';
 		$items[ 'customer-logout' ] = 'Log ud';

		unset( $items[ 'edit-account'] );
 	    unset( $items[ 'payment-methods'] );
 	    unset( $items[ 'subscriptions'] );	 

		if($this->has_active_subscription()){

 		    //$items[ 'subscription-box' ] = __( 'Medlemskab', 'wineclube' );
	 	    $items = array_slice( $items, 0, 1, true ) 
			+ array( 'subscription-box' => 'Medlemskab' )
			+ array_slice( $items, 1, NULL, true );
	   }
	   $items = array_slice( $items, 0, 4, true ) 
			+ array( 'invite-friend' => 'inviter venner' )
			+ array_slice( $items, 4, NULL, true );
 
 		return $items;
	}

	public function invite_friend_setting_endpoint_callback( ){

         echo '<div class="page-title"><h2 >Get Ready... Something Really Cool Is Coming Soon.</h2></div>';

    }

 

    public function subscription_box_setting_endpoint_callback( ){

    	// Get all of their subscriptions
	    $subscriptions = get_posts( array(
	        'numberposts' => -1,
	        'post_type'   => 'shop_subscription', // Subscription post type
	        'post_status' => 'wc-active', // Active subscription
	        'order' => 'ASC',
	        'meta_key'    => '_customer_user',
	        'meta_value'  => get_current_user_id(),
	    ) );
 
	   
	     
	    if($subscriptions){

	        $BaseProduct = new BaseProduct(); 
	        
	        ?>

		    <section class="product-selector">

		        <div class="container">

		        	<form action="" method="post" id="FormUpdate">

		        		<input type="hidden" name="action" value="update_subscription_details">	        		

			        	<div class="row selection-5">

				        	<div class="Velkommen-text">

			                   <h2 class="text-center" style="font-weight: 800;">Vælg din næste levering</h2>
			                  
			                  
		 	                   <p class="text-center">Sammensæt din næste undy-boks ved at vælge hvilke underbukser vi skal sende afsted til dig næste gang.</p>
		 	                   <br>
		                        <div class="form-group b-select-wrap center">
								 
								    <select name="subcrition_array" id="subcrition_array" class="form-control b-select">
								    	<?php 

								    	$i = 1; 

								    	$subscription_id = '';

								    	if(!empty($subscriptions)){

								    	foreach ($subscriptions as $key => $obj) {

								    		if($i == 1){

								    			$subscription_id = $obj->ID;

								    		}

								    		echo '<option value="'.$obj->ID.'">#'.$obj->ID.' - Subscription</option>';
								    		$i++;
								    	}
								        }else{
								        	echo '<option value="">No subscription available.</option>';
								        }
								    	?> 
							        </select>
								 
								</div>

			                </div>

							<div class="page-title">

							    <h2 class="text-center" style="font-weight: 800;">Din Undy-boks</h2><br><br>

						    </div>
		 
					    </div>

			            <?php 
			                if(!empty($subscription_id)){

			                    
			                    if(!empty(get_post_meta( $subscription_id, '_schedule_next_payment', true ))){

			                    	$date = get_post_meta( $subscription_id, '_schedule_next_payment', true );
			                        $schedule_next = date('d F', strtotime($date));

			                    }else{
			                    	$schedule_next = 'Subscription is on Hold';
			                    }
			                     
			                    $subscription_vari = get_post_meta( $subscription_id, 'subscription_variation', true );
			                    
			                    if(!empty($subscription_vari)){


			                       $term = get_term($subscription_vari['product_cat_id'],'product_cat');


			                       if(!empty($subscription_vari)){
	 		                            
			                            $cat_name = $term->name;

			                        }else{

			                        	$cat_name = 'No Category';
			                        }

			                      

			                        if(!empty($subscription_vari['color_cat_id'])){ 

			                        	$color_array = explode(',', $subscription_vari['color_cat_id']);
			                        	$i = 0; 
			                        	$color_name = '';
			                        	foreach ($color_array as $key => $ids) {
			                        		if($i>0){
			                        	    	$color_name .=', ';
			                        	    }
			                        	    $color = get_term($ids,'color-category');
			                        	    $color_name .= $color->name;
			                        	    
			                        	    $i++;
			                        	}
	 		                        }else{

		 	                        	$color_name = 'No Color';
			                        }

			                        if($subscription_vari['size_slug'] == 's'){
			                        	$size_name = 'Small';
			                        }else if($subscription_vari['size_slug'] == 'm'){
			                        	$size_name = 'Medium';
			                        }else if($subscription_vari['size_slug'] == 'l'){
			                        	$size_name = 'Large';
			                        }else if($subscription_vari['size_slug'] == 'xl'){
			                        	$size_name = 'Extra Large';
			                        }else if($subscription_vari['size_slug'] == 'xxl'){
			                        	$size_name = 'Double Extra Large';
			                        }else{
			                        	$size_name = 'No Size';
			                        } 
							    }
			                }

			            ?> 
					    <div class="row selection-4">

					    	<div class="col-md-12">

					    	    <div class="item-box">

		                            <h4 class="text-center" style="font-weight: 600;">Informationer</h4>
		                            </br>
				                  
			 	                    Underbukse Type: <b><span class="subcat_name"> <? echo $cat_name; ?></span></b><br>

			 	                    Design: <b> <span class="subcolor_name"><? echo $color_name; ?></span></b><br>

			 	                    Størrelse: <b> <span class="subsize_name"><? echo $size_name; ?></span></b><br>

			 	                   </br>

			 	                   <div class="abonnement-btn" style="margin-top: 0;">

		                        	    <a href="javascript:void(0);" id="product_look" style="background-color: #848490a3;" >Rediger</a>
		                           
		                            </div>
			 	                </div>

			                </div>

					    </div>



					    <div class="row selection-2" style="display:none">

				          <h3 class="text-center">Vælg størrelse</h3>

				          <p class="text-center icon-plus-sign" style="text-decoration: underline;">Størrelsesguide</p> 
				    
							<div class="col-md-12 wrapper">

								<?php 

								$taxonomy_obj = get_terms( 'size-category', array(
								        'hide_empty' => true,
								      ) );

								foreach($taxonomy_obj as $size){ 
									    $active = '';
									    $checked = '';
								        if($size->slug == $subscription_vari['size_slug']) {
									       $checked = ' checked="checked"';
								        	$active = ' active';
								        }

							            echo  '<div class="item-box box-'.$size->slug.$active.'" > <img src="'.get_bloginfo('template_url').'/images/tick.png" class="tick" />
							                  <h1 class="text-center">'.$size->name.'</h1>
							            <div style="display:none">
							              <input type="radio" name="product_size"'.$checked.' data-slug="'.$size->slug.'" class="product_size" value="'.$size->term_id.'" />
							            </div>
							                </div>';
							      }  

								?>
							</div> 
					    
					    </div>

					    <div class="row selection-3" style="display:none">
							<?php
							    if(!empty($subscription_id)){
							       echo $BaseProduct->getSubcriptionItemsAndCategoryHtml($subscription_id);
							    }
							?>
		 			    
		 			    </div>
		 			  
		        	</form>

		        </div>

		    </section> 

			<section class="product-selector">
			 
			    <div class="col-md-12">

			        <div class="row selection-4">

						<div class="col-md-12">

						    <div class="item-box">

						    	<div class="Velkommen-text">

		                   			<h3 class="text-center" style="font-weight: 800;">Medlemskab</h3><br>

		                         	<b>Aktivt</b><br><br>

		                         	Næste afsendelse: <b> <span class="subpayment_date"><? echo $schedule_next; ?></span></b><br>

		                         	<p class="text-center">Du har altid mulighed for at sætte dit medlemskab hos Undy i bero. Der er nemlig ingen opsigelsesperiode</p><br>	 

			 	                   <div class="abonnement-btn"  style="margin-top: 0;">

									    <a href="javascript:void(0);"  style="background-color: #848490a3;">Sæt i bero </a>

									</div>

									<p class="text-center" style="text-decoration: underline;padding-top: 0;font-weight: 700;color: #848181;">Opsig permanent</p>	

				                </div>

						    </div>

						</div>

				    </div>
				</div>
			</section> 

			<script>

				jQuery(document).ready(function(){
					 
					jQuery(document).on('click',"#product_look",function(){ 

						jQuery('.row.selection-1').toggle();
						jQuery('.row.selection-2').toggle();
						jQuery('.row.selection-3').toggle();

					});

					jQuery(document).on('click',".selection-1 .item-box",function(){
	 
	                   jQuery(".selection-1 .item-box.active").removeClass("active"); 

	                   jQuery(this).addClass("active");

	                   jQuery(this).find(".product_cat").prop("checked",true);
   	                    
	                   var size_slug = jQuery('input[name="product_size"]:checked').attr('data-slug');

	                   alert(size_slug);
	                   
	                   jQuery('.selection-2 .box-'+size_slug).click();

	                    //var product_cat = jQuery('input[name="product_size"]:checked').val();
	 
					});

				    jQuery(document).on('click',".selection-2 .item-box",function(){

				    	jQuery('.error').remove();

				    	jQuery("#FormUpdate").addClass('ajax-loader');

	                    jQuery(".selection-2 .item-box.active").removeClass("active");

	                    jQuery(this).addClass("active");

	                    jQuery(".row.selection-3").html(' ');

			            jQuery(this).find(".product_size").prop("checked",true);

			            var size_id = jQuery(this).find(".product_size").val();

			            var product_cat = jQuery('input[name="product_cat"]:checked').val();

			            var sub_id = jQuery("#subcrition_array").val();

			            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

						var form_data = 'action=getItemList&subscription_id='+sub_id+'&product_cat='+product_cat+'&size_id='+size_id;

						jQuery.ajax({
	                        url:ajaxurl,
	                        type:'POST',
	                        dataType: 'json',
	                        data: form_data,
	                        success:function(response){
	 
		                        if(response.status == '1'){
	 	                        	if(response.item_list != ''){
		                        		jQuery(".row.selection-3").html(response.item_list);
		                        	} 
	 							}else{
									alert("Something went wrong. Please try after some time");
								}

								jQuery("#FormUpdate").removeClass('ajax-loader');	
							}				 

						});
	 
					});
					

					jQuery("#subcrition_array").on('change',function(){ 

						jQuery('.row.selection-2').hide();

						jQuery('.row.selection-3').hide();

						jQuery('.error').remove();

						var sub_id = jQuery(this).val();

						if(sub_id == ''){

							alert("invalid subcrition details ");

							return false;
						}
						 
						jQuery("#FormUpdate").addClass('ajax-loader');
	 
						var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

						var form_data = 'action=get_subscription_detail&subscription_id='+sub_id;

						jQuery.ajax({
	                        url:ajaxurl,
	                        type:'POST',
	                        dataType: 'json',
	                        data: form_data,
	                        success:function(response){

		                        if(response.status == '1'){

		                        	jQuery('.subpayment_date').html(response.payment_date);
		                        	jQuery('.subcat_name').html(response.cat_name);
		                        	jQuery('.subcolor_name').html(response.color_name);
		                        	jQuery('.subsize_name').html(response.size_name);
		                        	//jQuery('#color_cat_id').val(response.color_id);
		                        	var size_slug = response.size_slug;

		                         	if( size_slug != ''){
		                         		jQuery('.item-box').removeClass('active');
		                        		jQuery('.box-'+size_slug).addClass('active');
		                        		jQuery('.item-box.box-'+size_slug).find(".product_size").prop("checked",true);
		                        	}
		                        	if(response.item_list != ''){
		                        		jQuery(".row.selection-3").html(response.item_list);
		                        	} 
		 
								}else{
									alert("Something went wrong. Please try after some time");
								}
							   jQuery("#FormUpdate").removeClass('ajax-loader');	
							}				 

						  }); 
	 
						return false;

					})

				    jQuery("#FormUpdate").on('submit',function(e){ 

	                    e.preventDefault();

			            jQuery('.error').remove();

				    	var sum = 0;
	 
						jQuery(".input-number").each(function (){

			               sum += Number( jQuery(this).val());

			            });

						if( sum < 2 ){

			                //jQuery(this).after('<span class="error" style="color:red;"> Please select minimum  2 quantity.</span>');

			                jQuery(this).after('<div class="alert alert-danger error"><strong>Error!</strong> Please select minimum 2 quantity.</div>');

			                return false;
			            }else if( sum > 2 ){

			                //jQuery(this).after('<span class="error" style="color:red;"> Please select maximum 2 quantity.</span>');

			                jQuery(this).after('<div class="alert alert-danger error"><strong>Error!</strong> Please select maximum 2 quantity.</div>');

			                return false;

			            }else{ 

			            	jQuery("#FormUpdate").addClass('ajax-loader');
	 
							var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

							var form_data = jQuery('#FormUpdate').serialize();

							jQuery.ajax({
		                        url:ajaxurl,
		                        type:'POST',
		                        dataType: 'json',
		                        data: form_data,
		                        success:function(response){

			                        if(response.status == '1'){
			                        	location.reload();
									}else if(response.status == '0'){

										jQuery('.row.selection-3').before(response.msg);

									}else{

										alert("Something went wrong. Please try after some time");
									}

									jQuery("#FormUpdate").removeClass('ajax-loader');	
								}				 

							});

	 					}
							return false;

					})
	                                
				});
	                        
	            /* Quantity Function */
	            jQuery(document).ready(function(){

	                var quantitiy=1;

	                //jQuery(".quantity-right-plus").on('click',function(e){
	                jQuery(document).on('click',".quantity-right-plus",function(e){
	                    // Stop acting like a button
	                 
	                    e.preventDefault();
	                    // Get the field name
	                     jQuery('.error').remove();

	                     jQuery('.quantity-right-plus').attr("style","");
	 
	                    var vari_id = parseInt(jQuery(this).attr('data-variation_id'));

	                    var col_id = parseInt(jQuery(this).attr('data-color-id'));

	                    var quantity = parseInt($('#quantity_'+vari_id+'.color_cat_'+col_id).val());
	                    // If is not undefined
	                 
				    	var sum = 1;
	 
						jQuery(".input-number").each(function (){
			               sum += Number( jQuery(this).val());
			            });

			            if( sum > 2 ){

			                // jQuery('.row.selection-3').before('<span class="error" style="color:red;"> Please select maximum 2 quantity.</span>');
			                jQuery('.row.selection-3').before('<div class="alert alert-danger error"><strong>Error!</strong> Please select maximum 2 quantity.</div>');


			                jQuery(this).css('color', 'red');

			                return false;

			            }else{

		                    $('#quantity_'+vari_id+'.color_cat_'+col_id).show();

		                    $('#quantity_'+vari_id+'.color_cat_'+col_id).val(quantity + 1);
		                    // Increment
	                    }
	                });

	                ///jQuery(".quantity-left-minus").on('click',function(e){
	                jQuery(document).on('click',".quantity-left-minus",function(e){
	                	 
	                    // Stop acting like a button
	                    e.preventDefault();

	                    jQuery('.error').remove();

	                    jQuery('.quantity-right-plus').attr("style","");
	                    // Get the field name
	                    var vari_id = parseInt(jQuery(this).attr('data-variation_id'));

	                    var col_id = parseInt(jQuery(this).attr('data-color-id'));

	                    var quantity = parseInt($('#quantity_'+vari_id+'.color_cat_'+col_id).val());
	 
	                     // If is not undefined
	                        // Increment
	                    if(quantity>1){

	                        $('#quantity_'+vari_id+'.color_cat_'+col_id).val(quantity - 1);

	                    }else{

	                    	$('#quantity_'+vari_id+'.color_cat_'+col_id).val(0);
	                    	$('#quantity_'+vari_id+'.color_cat_'+col_id).hide();
	                    }
	                });
	            });          
			</script>

     <?php     

       }else{

       	echo '<div class="text-center"><h3 >No subscrition available.</h3></div>';

       }

    }	

    


}

 new MainAccount();