<?php
/*
Template Name: Document Template
*/
get_header();
?>

<section id="banner-profile">
	<div class="img-inner">
		<div class="container">
			<div class="banner-text-white">
				<h3>Kundeportal</h3>
			</div>
		</div>
	</div>
</section>
<section id="dashboard-doc" style="padding: 0px 20px;">
	<div class="overview-detail-inner">
		<div class="row">
			<div class="sidebar col-sm-3 col-md-3 col-lg-2 text-white p-0">
				<ul class="discription-text">
					<a href="<?php echo site_url(); ?>/profile/" style="color: #fff;">
						<li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/icon-home.png" class="img-thumbnail"></span>Hjem</li>
					</a>
					<a href="<?php echo site_url(); ?>/beskeder/" style="color: #fff;">
						<li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/msg-icon.png" class="img-thumbnail"></span>Beskeder</li>
					</a>
					<a href="<?php echo site_url(); ?>/betalingsstatus/" style="color: #fff;">
						<li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/status-icon.png" class="img-thumbnail"></span>Betalingsstatus</li>
					</a>
					<a href="<?php echo site_url(); ?>/dokumenter/" style="color: #fff;">
						<li class="test pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/document-icon.png" class="img-thumbnail"></span>Dokumenter</li>
					</a>
					<a href="<?php echo site_url(); ?>/user-profile/" style="color: #fff;">
                        <li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/profile-icon.png" class="img-thumbnail"></span>Dine oplysninger</li>
                    </a>
				</ul>
			</div>
			<div class="col-sm-9 col-md-9 col-lg-10 uploader-wrap" style="background: #ebebeb; padding: 30px; ">
				<?php echo do_shortcode('[nm-wp-file-uploader]'); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>