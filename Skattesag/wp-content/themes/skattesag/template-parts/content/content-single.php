<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
?>


<section id="payinfo">
	<div class="middle-content">
		<div class="container">
			<div class="payinfo-video blog-img" style="text-align: center;">
				<img src="<?php echo $featured_img_url; ?>">
			</div>
			<div class="blog-description text-center">
				<h1><?php the_title(); ?></h1>
				<p><?php the_content(); ?></p>
			</div>

			<div class="profile-wrap-right">
				<div class="row">
					<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
						<h2><?php echo get_field("help_title", '334'); ?></h2>
					
						<p><?php echo get_field("help_description", '334'); ?></p>
						<a href="<?php echo get_field("help_button_link", '334'); ?>"><button type="button" class="btn btn-primary"><?php echo get_field("help_button_text", '334'); ?></button></a>
					</div>
					<div class="col-md-4"> <img src="<?php echo get_field("help_image", '334'); ?>" alt="" width="100%"> </div>
				</div>
			</div>
		</div>
	</div>
</section>
