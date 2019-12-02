<?php get_header();?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section class="un-about-text post-single">
  	<div class="container-fluid post-wrap">
    	<div class="col-sm-8 left-panel">
			<div class="decription-text">
				<h1 class="blog-entry-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
  		</div>
		<div class="col-sm-4 right-panel"><div class="sidebar-wrap"><?php dynamic_sidebar( 'sidebar' ); ?></div></div>
	</div>
</section>

<?php endwhile; endif;?>

<?php get_footer();?>