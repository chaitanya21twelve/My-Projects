<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800|Poppins:100,200,300,600,700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>

</head>

<style type="text/css">
  .main-menu-more {
    display: none;
  }

  
</style>

<body <?php //body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div id="header-main">
		<nav class="navbar navbar-default bg-light">
		    <div class="top-line" style="width: 100%;">
		      <div class="container">
		        <div class="row">
		          <div class="col-md-12 col-sm-12 col-xs-12 text-right">
		            <p> 
		                <?php if ( is_user_logged_in() ) { ?>
		                      <a href="<?php echo site_url(); ?>/profile"><span>Kundeportal</span></a> 
		                      <a href="<?php echo site_url(); ?>/logout/"><span>Log ud</span></a>
		                <?php } else { ?>
		                      <a href="<?php echo site_url(); ?>/login/"><span>Kundeportal</span></a>
		                <?php } ?>
		              <a href="<?php echo site_url(); ?>/gratis-telefonmode/"><button type="button" class="btn btn-primary">Gratis telefonmøde</button></a>
		            </p>
		          </div>
		        </div>
		      </div>
		    </div>
		</nav>
		<nav class="navbar navbar-expand-md navbar-dark">
		    <div class="container"> <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/Logo-top.png" width="215" height="39" alt="Skattesag"/></a>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"> <span class="navbar-toggler-icon"></span> </button>
		      <!-- <div class="collapse navbar-collapse navbar-right" id="collapsibleNavbar">
		        <ul class="navbar-nav">
		          <li class="nav-item"> <a class="nav-link" href="#">Klage<span>|</span></a></li>
		          <li class="nav-item"> <a class="nav-link" href="#">Domstolene<span>|</span> </a></li>
		          <li class="nav-item"> <a class="nav-link" href="#">Omkostningsgodtgørelse<span>|</span></a></li>
		          <li class="nav-item"> <a class="nav-link" href="#">Artikler<span>|</span></a></li>
		          <li class="nav-item"> <a class="nav-link" href="#contact-us">Kontakt</a></li>
		        </ul>
		      </div> -->

		      <?php
		          // wp_nav_menu( array(
		          //     'theme_location' => 'menu-1'
		          // ) );

		          wp_nav_menu( array(
		            'theme_location'  => 'menu-1',
		            'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
		            'container'       => 'div',
		            'container_class' => 'collapse navbar-collapse navbar-right',
		            'container_id'    => 'collapsibleNavbar',
		            'menu_class'      => 'navbar-nav',
		          //  'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
		            'walker'          => new WP_Bootstrap_Navwalker(),
		          ) );
		       ?>
		    </div>
		</nav>
	</div>
	<nav id="header-scroll" class="navbar navbar-expand-md navbar-dark stk stickt">
	    <div class="container"> 
	    	<a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/Logo-top.png" width="215" height="39" alt="Skattesag"/></a>
	     	<a href="<?php echo site_url(); ?>/gratis-telefonmode/"><button type="button" class="btn btn-primary">Gratis telefonmøde</button></a>
	    </div>
	</nav>
</header>

<script>

	jQuery(document).ready(function() {
		var s = jQuery(".stk");
		var pos = s.position();	
		jQuery(window).scroll(function() {
			var windowpos = jQuery(window).scrollTop();
			if (windowpos >= pos.top) {
				s.removeClass("stickt");
			}

			if (windowpos <= (pos.top+100)) {
				s.addClass("stickt");
			}
		});
	});

	
</script>