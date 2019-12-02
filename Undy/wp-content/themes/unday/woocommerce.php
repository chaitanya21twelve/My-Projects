<?php 
if(is_shop()){
	include_once 'archive-product.php';
}elseif(is_tax('')){
	include_once 'taxonomy-product_cat.php';
}else{
get_header();?>
<?php if (have_posts()) : ?>
<?php
global $wp;
$request = explode( '/', $wp->request );
	// If NOT in My account dashboard page
if( ( end($request) == 'my-account' || is_account_page() ) ){ 
	$className = 'Oplysninger';
}elseif(is_singular('product')){ 
	$className = "pak-sec";
}else{ 
	$className = "woocommerce-pages";
}
?>
<section class="<?php echo $className;?>">
	<div class="container">
		<?php woocommerce_content();?>
	</div>
</section>
<?php endif;?>
<?php get_footer();?>
<?php }?>