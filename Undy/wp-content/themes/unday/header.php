<?php



define( 'THEME_URL', get_template_directory_uri() );



define( 'CSS_URL', get_template_directory_uri() . '/css' );



define( 'JS_URL', get_template_directory_uri() . '/js' );



define( 'IMAGES_URL', get_template_directory_uri() . '/images' );



?>

<!DOCTYPE html>

<html lang="en">

<head>

	
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128293577-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128293577-1');
</script>
	
	
<!-- Global site tag (gtag.js) - Google Ads: 769386382 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-769386382"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-769386382');
</script>




	<script>
  window.intercomSettings = {
    app_id: "vf7orqvl"
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/vf7orqvl';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
	
	<!-- TrustBox script -->
	<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
	<!-- End TrustBox script -->


	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<title><?php wp_title(''); ?></title>


	<?php wp_head();?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style_1.css" type="text/css" media="screen"/>

	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800|Poppins:300,400,400i,500,600,700|Roboto:300,400,400i,500,700" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL;?>/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL;?>/style.css">

	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL;?>/style1.css">

	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL;?>/responsive.css">

	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL;?>/responsive1.css">

	<?php 



$favicon = of_get_option('favicon_logo');



if(isset($favicon) && !empty($favicon)){ ?>

	<link href='<?php echo $favicon;?>' type='image/x-icon' rel='shortcut icon'/>

	<?php }



?>

        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri();?>">

</head>


	
<body <?php body_Class();?>>


	<?php

	$logo = of_get_option( 'site_logo' );

	if ( !$logo || empty( $logo ) ) {
		$logo = IMAGES_URL . '/logo.png';
	}

	?>

	<header class="header">

		<?php $header_info = of_get_option('header_info');
		if(!empty($header_info)){
	?>

		<div class="header-top hidden-xs">
			<?php echo $header_info;?> </div>

		<?php }?>
		<?php $count = WC()->cart->get_cart_contents_count(); ?>
		<div class="header-menu">

			<div class="">

				<div class="responsive-logo"> <a href="<?php echo get_site_url();?>"><img class="width" src="<?php echo $logo;?>" alt="<?php echo get_bloginfo('name');?>"></a> </div>

				<div class="fa-cart">
					<a href="https://undy.dk/cart/" class="responsive-cart-btn">
			<img src="<?php echo IMAGES_URL;?>/cart-button.png" alt="Cart" />
			<span class="cnt"><?php echo $count; ?></span>
		</a>
				
				</div>
				<div class="right-sidebar">

					<div class="top-menu">

						<nav class="navbar navbar-inverse">

							<div class="navbar-header">

								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
							</div>

							<div class="navbar-collapse collapse" id="myNavbar" aria-expanded="false" style="height: 2px;">

								<?php
								wp_nav_menu( array(

										'theme_location' => 'header-menu',

										'container' => false,

										'menu_class' => 'nav navbar-nav left-menu',

										'walker' => new WP_Bootstrap_Navwalker()

									)

								);

								?>


								<div class="logo"> <a href="<?php echo get_site_url();?>"><img src="<?php echo $logo;?>" alt="<?php echo get_bloginfo('name');?>"></a> </div>


								<?php

								$cart = '<li class="crt"><a href="https://undy.dk/cart/" class="cart-btn"><img src="' . IMAGES_URL . '/cart-button.png" alt="Cart" /><span class="cnt">' . $count . '</span></a></li>';

								wp_nav_menu( array(

									'theme_location' => 'header-menu2',

									'container' => false,

									'menu_class' => 'nav navbar-nav right-menu',

									'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $cart . '</ul>'

									//'walker'            => new WP_Bootstrap_Navwalker()

								) );

								?>


							</div>


						</nav>


					</div>

				</div>
				<div class="cartz">
					<?php dynamic_sidebar( 'cart_widget' ); ?>
				</div>
			</div>

		</div>

		<?php

		global $wp;

		$request = explode( '/', $wp->request );

		// If NOT in My account dashboard page

		if ( ( end( $request ) == 'my-account' || is_account_page() ) ) {

			?>



		<?php do_action( 'woocommerce_account_navigation' );?>

		<?php 

		} 

	?>
		
		

	</header>



	<script>
		
//		jQuery( document ).ready( function ( $ ) {
//		
//		
//				jQuery( ".subcats" ).hover( function () {
//				
//					jQuery( ".dropdown-menu" ).show();
//					
//				} );
//				jQuery( ".dropdown-menu" ).mouseout( function () {
//					
//					//jQuery( ".dropdown-menu" ).hide();
//					jQuery( ".dropdown-menu" ).css( "display", "none", "!important" );
//					
//				} );
//			
//
//
//		} );
		
		
		
		
		
		jQuery( document ).ready( function ( $ ) {
			var deviceAgent = navigator.userAgent.toLowerCase();
			var agentID = deviceAgent.match( /(iPad|iPod)/i );
			if ( agentID ) {
				jQuery( ".responsive-cart-btn" ).css( "display", "none" );
				jQuery( ".cart-btn" ).css( "display", "block" );

				jQuery( ".cart-btn" ).click( function () {

					jQuery( ".cartz" ).css( {
						"position": "absolute",
						"right": 0,
						"top": "20%"
					} );
					jQuery( ".cartz" ).slideToggle();

				} );
			} else {
				jQuery( ".cart-btn" ).hover( function () {
					jQuery( ".cartz" ).show();
					//jQuery(".cartz").css("visibility", "visible !important");

				} );
				jQuery( ".cartz" ).mouseleave( function () {

					jQuery( ".cartz" ).css( "display", "none" );
				} );
			}


			jQuery( ".responsive-cart-btn" ).click( function () {
				jQuery( ".cartz" ).slideToggle();
			} );

		} );
	</script>