<?php 
/*
	Template Name: About Us
*/
get_header();
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $bannerImage = get_field('banner_image');
if(!empty($bannerImage)){
?>
<section class="un-banner">
  <div class="banner-img"> <img src="<?php echo $bannerImage;?>" width="100%" alt="<?php echo get_the_title();?>"/> </div>
  <div class="container">
    <div class="banner-dec">
      <h2><?php echo get_the_title();?></h2>
    </div>
  </div>
</section>
<?php }?>
<section class="about-decription">
  <div class="about-bg">
    <div class="container">
      <div class="row">
        <div class="about-box">
          <?php echo get_field('additional_content');?>
        </div>
		<?php $contentImage = get_field('content_image');
		if(!empty($contentImage)){
		?>
        <div class="about-profile"> <img src="<?php echo $contentImage;?>"  alt="<?php echo get_the_title();?>" /> </div>
      	<?php }?>
	  </div>
    </div>
  </div>
</section>
<section class="un-about-text" >
  <div class="container">
    <div class="decription-text">
      <?php the_content();?>
    </div>
  </div>
</section>
<?php endwhile; endif; ?>
<?php get_footer();?>