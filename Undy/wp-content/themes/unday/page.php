<?php get_header();?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php

global $wp;

$request = explode( '/', $wp->request );

	// If NOT in My account dashboard page

if(is_account_page()){

	the_content();

	$className = '';

}elseif( ( end($request) == 'my-account') ){ 

	$className = 'Oplysninger';

}elseif(is_singular('product')){ 

	$className = "pak-sec";

}else{ 

	$className = "woocommerce-pages un-about-text";

}

if(!empty($className)){

?>

<section class="<?php echo $className;?>">

	<div class="container">

		<?php the_content();?>

	</div>

</section>

<?php }?>

<?php endwhile; endif;?>

<?php get_footer();?>