<?php

/*

	Template Name: Abonnement

*/
get_header();
?>

<section class="banner">

    <div class="container-fluid">

        <div class="row">

             <div class="item col-md-6 col-sm-6 col-xs-12">

                <div class="banner-right">

                    <div class="banner-text bnr-txt">

					<?php if(!empty(get_field('box_title'))){?>	

                    <h1> <?php echo get_field('box_title');?></h1>

					<?php }?>

                    <div class="banner-progres">
					
                        <?php if(!empty(get_field('box_description'))){?>	

						<?php echo get_field('box_description');?>

						<?php }?>

                    </div>

					<?php if(!empty(get_field('button_text')) && !empty(get_field('button_link'))){?>	

                    <a href="<?php echo get_field('button_link');?>" class="button"><?php echo get_field('button_text');?></a>

					<?php }?>

                    </div>

                </div>

            </div>
            <div class="item  col-md-6 col-sm-6 col-xs-12">

                <div class="banner-left">

                    <img src="<?php echo get_field('banner_image');?>" alt="Product" />
					
                </div>

            </div>

        </div>

    </div>

</section>
<?php //}?>


<div class="reviews">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<!-- TrustBox widget - Mini -->
					<div class="trustpilot-widget" data-locale="da-DK" data-template-id="53aa8807dec7e10d38f59f32" data-businessunit-id="5bcdce3f0448bd0001db6839" data-style-height="150px" data-style-width="100%" data-theme="light">
					  <a href="https://dk.trustpilot.com/review/www.undy.dk" target="_blank">Trustpilot</a>
					</div>
				<!-- End TrustBox widget -->
		</div>
			<div class="col-md-3">
				<ul>
					<li class="img"><img src="<?php echo IMAGES_URL;?>/5stars.png" alt="" />      20. september 2019</li>
					<li class="title">Dejlig nemt og hurtig levering</li></br>
					<li class="desc">Dejlig nemt og hurtig levering. Selv med en lidt besværlig ordre får man det man skal have. Dejlig pasform og kvalitet til prisen </li>
					<li class="author">Nicklas</li>
				</ul>
			</div>
			<div class="col-md-3">
				<ul>
					<li class="img"><img src="<?php echo IMAGES_URL;?>/5stars.png" alt="" />      19. september 2019</li>
					<li class="title">Hurtig service</li>
					<li class="desc">Hurtig service, meget imødekommende og rigtig god kvalitet i underbukser</li>
					<li class="author">Casper Christiansen</li>
				</ul>
			</div>
			<div class="col-md-3">
				<ul>
					<li class="img"><img src="<?php echo IMAGES_URL;?>/5stars.png" alt="" />      16. september 2019</li>
					<li class="title">God kvalitet og god service</li>
					<li class="desc">God kvalitet og god service. 5 stjerner her fra</li></br>
					<li class="author">Daniel</li>
				</ul>
			</div>
		</div>
	</div>

<!--    <img src="<?php echo IMAGES_URL;?>/reviews.png" alt=""/>    -->

</div>



	<section class="abonnement-part">
		<div class="container">
			<div class="row">
				<div class="undy-er-ligetil">
					<h3 class="ligetil">Undy er ligetil</h3>
				</div>

				
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="abonnement-content">
						<img src="<?php echo get_field("box1_image"); ?>" alt="Prov Undy forst"/>
						<h3><?php echo get_field("box1_title"); ?></h3>
						<p><?php echo get_field("box1_description"); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="abonnement-content">
						<img src="<?php echo get_field("box2_image"); ?>" alt="Spar både tid og penge"/>
						<h3><?php echo get_field("box2_title"); ?></h3>
						<p><?php echo get_field("box2_description"); ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="abonnement-content">
						<img src="<?php echo get_field("box3_image"); ?>" alt="Vi har ingen binding"/>
						<h3><?php echo get_field("box3_title"); ?></h3>
					
						<p><?php echo get_field("box3_description"); ?></p>
					</div>
				</div>
			</div>
			<div class="abonnement-btn">
				<a href="<?php echo get_field("section_button_link"); ?>">PRØV I DAG</a>
			</div>
		</div>
	</section>
	<?php 

$args = array(

	'post_type' => 'process',

	'posts_per_page' => -1,

);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ): 

?>

<section class="sadan_virker">

    <div class="container">

        <div class="sadan_virker_box clearfix">

            <div class="sadan_virker-left">

                <div class="sadan_virker_title">

                    <h3>Sådan virker det</h3>

                </div>

                <?php 

				while ( $loop->have_posts() ) : $loop->the_post();

					$icon = types_render_field("process-image",array("url"=>true));

				?>

                <div class="sadan_virker_services">

					

                    

                    <div class="services-icon">

                        <img src="<?php echo $icon;?>" alt="<?php the_title();?>"/>

                    </div>

                    <div class="services-content">

                       <h3><?php the_title();?></h3>

						<?php the_content();?>

                    </div>

                </div>

                <?php endwhile;wp_reset_query();?>

             <?php if(!empty(get_field("sadan_process_image"))){?>   

				<div class="sadan_virker-right">
						<img src="<?php echo get_field("sadan_process_image");?>" alt="">
				</div>

			<?php }?>

            </div>

        </div>

    </div>

</section>

<?php endif; wp_reset_query();?>
	<section class="abonnement_Sadan_virker">
		<!-- <div class="page-title">
			<h2><?php //echo get_field("hit_title"); ?></h2>
		</div> -->
		<div class="pad-tb container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 item">
					<div class="abonnement_Sadan_virker-left">
						<img src="<?php echo get_field("hit_box1_image"); ?>" alt=""/>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 item">
					<div class="abonnement_Sadan_virker-right">
						<h3><?php echo get_field("hit_box1_title"); ?></h3>
						<p><?php echo get_field("hit_box1_description"); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="pad-tb container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 item">
					<div class="abonnement_Sadan_virker-right">
						<h3><?php echo get_field("hit_box2_title"); ?></h3>
						<p><?php echo get_field("hit_box1_description"); ?></p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 item">
					<div class="abonnement_Sadan_virker-left">
						<img src="<?php echo get_field("hit_box2_image"); ?>" alt=""/>
					</div>
				</div>
			</div>
		</div>
		<div class="pad-tb container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 item">
					<div class="abonnement_Sadan_virker-left">
						<img src="<?php echo get_field("hit_box3_image"); ?>" alt=""/>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 item">
					<div class="abonnement_Sadan_virker-right">
						<h3><?php echo get_field("hit_box3_title"); ?></h3>
						<p><?php echo get_field("hit_box3_description"); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="abonnement_gray_bg">
		<div class="container">
			<div class="description">
				<div class="title_icon">
					<img src="<?php echo IMAGES_URL;?>/logo_icon.png" alt=""/>
				</div>
				<p><?php echo get_field("trial_description"); ?> </p>
				<div class="abonnement-btn">
					<a href="<?php echo get_field("trial_button_link"); ?>">PRØV I DAG</a>
				</div>
			</div>
		</div>
	</section>
	<section class="abonnement_faq">
		<div class="container">
			<div class="faq_title"><h3><?php echo get_field("faq_title"); ?><span><a href="<?php echo get_field("faq_link"); ?>">FAQ</a></span></h3></div>
			<?php echo get_field("faqs"); ?>
		</div>

	</section>


<?php get_footer();?>