<?php
/*
Template Name: Payment Info Template
*/
get_header();
?>
<section id="payinfo-banner">
<div class="img-inner text-right">
	<img src="<?php echo get_field("banner_image"); ?>" alt="">
		
</div>
	<div class="left-img d-flex flex-wrap align-content-center">
	<div class="container">
	<div class="text-white">
		
			<h2><?php echo get_field("banner_text"); ?></h2>
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
						<h2><?php echo get_field("section_title"); ?></h2>
						<?php echo get_field("section_content"); ?>
					</div>
				</div>
			</div>
			<div class="profile-wrap-left ">
				<div class="row">
					<div class="col-md-4"> <img src="<?php echo get_field("left_image"); ?>" alt="" width="100%"> </div>
					<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
						<?php echo get_field("right_content"); ?>
					</div>
				</div>
			</div>
			<div class="quotes-wrap">
				<div class="text-center">
					<img src="http://simplewebdesign.dk/skattesag/wp-content/themes/skattesag/image/Quote-icon.png" alt="Quote">
					<h3 class="mt-4"><i><?php echo get_field("quote_text"); ?></i></h3>
				</div>
			</div>
			<div class="payinfo-description">
				<?php echo get_field("quote_content"); ?>
				<span>Nyttige links:</span>
				<?php if(get_field("quote_button_1_link") != ''){ ?><a href="<?php echo get_field("quote_button_1_link"); ?>"><button type="button" class="btn btn-outline-primary"><?php echo get_field("quote_button_1_text"); ?></button></a> <?php } ?>
				<?php if(get_field("quote_button_2_link") != ''){ ?><a href="<?php echo get_field("quote_button_2_link"); ?>"><button type="button" class="btn btn-outline-primary"><?php echo get_field("quote_button_2_text"); ?></button></a> <?php } ?>
			</div>
			<div class="profile-wrap-right">
				<div class="row">
					<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
						<h2><?php echo get_field("help_title"); ?></h2>
						<p><?php echo get_field("help_text"); ?></p>
						<?php if(get_field("help_button_link") != ''){ ?><a href="<?php echo get_field("help_button_link"); ?>"><button type="button" class="btn btn-primary"><?php echo get_field("help_button_text"); ?></button></a> <?php } ?>
					</div>
					<div class="col-md-4"> <img src="<?php echo get_field("right_image"); ?>" alt="" width="100%"> </div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>