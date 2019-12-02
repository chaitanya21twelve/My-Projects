<?php
/*
Template Name: Tax Template
*/
get_header();
?>
<section id="payinfo-banner">
	<div class="img-inner text-right">
		<img src="<?php echo get_field("banner_image"); ?>" alt="">

	</div>
	<div class="left-img d-flex flex-wrap align-content-center">
		<div class="container">
			<div class="title text-white">

				<h2>
					<?php echo get_field("banner_text"); ?>
				</h2>
			</div>
		</div>
	</div>
</section>
<section id="payinfo">
	<div class="middle-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-left">
					<div class="m-auto content-title">
						<?php echo get_field("section_content"); ?>
					</div>
				</div>
			</div>
			<div class="profile-wrap-left">
				<div class="row">
					<div class="col-md-5"> <img src="<?php echo get_field("left_image"); ?>" alt="" width="100%"> </div>
					<div class="profile-text right-text col-md-7">
						<?php echo get_field("right_content"); ?>
					</div>
				</div>
			</div>

			<div class="payinfo-description">
				<?php echo get_field("quote_content"); ?>
			</div>
			<?php $vid = get_field("vimeo_id");
				if(!empty($vid)){
			 ?>
			<div class="payinfo-video mt-5" style="text-align: center;">
				<iframe src="https://player.vimeo.com/video/<?php echo $vid; ?>?autoplay=1" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
			</div>
			<?php } ?>
			<div class="profile-wrap-right">
				<div class="row">
					<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
						<h2>
							<?php echo get_field("help_title"); ?>
						</h2>
						<p>
							<?php echo get_field("help_text"); ?>
						</p>
						<a href="<?php echo get_field("help_button_link"); ?>"><button type="button" class="btn btn-primary"><?php echo get_field("help_button_text"); ?></button></a>
					</div>
					<div class="col-md-4"> <img src="<?php echo get_field("right_image"); ?>" alt="" width="100%"> </div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>