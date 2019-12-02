<?php
/*
Template Name: Homepage
*/
get_header();
?>

<section id="banner-hero">
	<div class="img-inner">
		<div class="container">
			<div class="banner-content text-white">
				<h1>
					<?php echo get_field("banner_title"); ?>
				</h1>
				<p>
					<?php echo get_field("banner_content"); ?>
				</p>
				<a href="<?php echo get_field("banner_button_link_1"); ?>"><button type="button" class="btn btn-primary m-m">Gratis telefonmøde</button></a>
				<a href="<?php echo get_field("banner_button_link_2"); ?>"><button type="button" class="btn btn-outline-primary">Et hurtigt overblik</button></a>
			</div>
		</div>
	</div>
</section>
<section id="services">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<div class="m-auto content-title">
					<span>
						<?php echo get_field("tab_title"); ?>
					</span>
					<h2>
						<?php echo get_field("about_title"); ?>
					</h2>
					<p>
						<?php echo get_field("about_content"); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="profile-wrap">
			<div class="row">
				<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
					<h2>
						<?php echo get_field("help_title"); ?>
					</h2>
					<p>
						<?php echo get_field("help_content"); ?>
					</p>
					<a href="<?php echo get_field("help_button_link"); ?>"><button type="button" class="btn btn-outline-primary">Kontakt os i dag</button></a>
				</div>
				<div class="col-md-4"> <img src="<?php echo get_field("right_image"); ?>" width="100%" alt=""/> </div>
			</div>
		</div>
	</div>
</section>
<section id="overview-detail">
	<div class="text-white">
		<div class="container">
			<div class="overview-detail-inner">
				<div class="row">
					<div class="col-md-4">
						<h3>
							<?php echo get_field("overview_title"); ?>
						</h3>
					</div>
					<div class="col-md-4">
						<h6>
							<?php echo get_field("section_1_title"); ?>
						</h6>
						<p>
							<?php echo get_field("section_1_content_1"); ?>
						</p>
						<p>
							<?php echo get_field("section_1_content_2"); ?>
						</p>
					</div>
					<div class="col-md-4">
						<h6>
							<?php echo get_field("section_2_title"); ?>
						</h6>
						<p>
							<?php echo get_field("section_2_content_1"); ?>
						</p>
						<p>
							<?php echo get_field("section_2_content_2"); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="overview-detail-inner m-t">
				<div class="row">
					<div class="col-md-4">
						<h6>
							<?php echo get_field("section_3_title"); ?>
						</h6>
						<p>
							<?php echo get_field("section_3_content_1"); ?>
						</p>
						<p>
							<?php echo get_field("section_3_content_2"); ?>
						</p>
					</div>
					<div class="col-md-4">
						<h6>
							<?php echo get_field("section_4_title"); ?>
						</h6>
						<p>
							<?php echo get_field("section_4_content_1"); ?>
						</p>
						<p>
							<?php echo get_field("section_4_content_2"); ?>
						</p>
					</div>
					<div class="col-md-4">
						<h6>
							<?php echo get_field("section_5_title"); ?>
						</h6>
						<p>
							<?php echo get_field("section_5_content_1"); ?>
						</p>
						<p>
							<?php echo get_field("section_5_content_2"); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="contact-us"> <img src="<?php echo get_template_directory_uri(); ?>/image/contact-banner.jpg" width="100%" alt=""/>
	<div class="container">
		<div class="row">
			<div class="contactbox-wrap">
				<h2>
					<?php echo get_field("contact_title"); ?>
				</h2>
				<p><i class="fa fa-phone p-2" style="color: #0e3248;"></i>
					<a href="#">
						<?php echo get_field("phone"); ?>
					</a>
				</p>
				<p><i class="fa fa-envelope p-2 mb-5" style="color: #0e3248;"></i>
					<a href="mailto:<?php echo get_field("email"); ?>">
						<?php echo get_field("email"); ?>
					</a>
				</p>
				<a href="<?php echo get_field("contact_button_link"); ?>"><button type="button" class="btn btn-primary">Gratis telefonmøde</button></a>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>