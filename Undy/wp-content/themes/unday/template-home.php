<?php 

/*

	Template Name: Homepage

*/

get_header();?>


<!-- <section class="blue-add">
<div class="container-fluid">
<div class="row">
	
</div>
</div>
</section> -->
<?php
	$desc = get_field('spar_description');
if(!empty($desc )) {?>
<section class="blue-add" style="background-image: url(<?php echo get_field('spar_background_image');?>);">
	<div class="container">
		<div class="row">
		<div class="baa ">
		<a href="<?php echo get_field('spar_redirect_link');?>"><p><?php echo get_field('spar_description');?>
			<img src="<?php echo get_field('image_beside_description');?>" alt=""></p></a>
			
		</div>
		</div>
	</div>
	
</section>
<?php } ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); 

$bannerImage1 = types_render_field("banner-image-1",array("url"=>true));
//$bannerImage2 = types_render_field("banner-image-2",array("url"=>true));



if(!empty($bannerImage1 )){

	$bannerTitle = types_render_field("banner-title",array());

	$bannerContent = types_render_field("banner-content",array("url"=>true));

	$bannerBText = types_render_field("banner-button-text",array());

	$bannerBUrl = types_render_field("banner-button-url",array("output"=>"raw"));

?>

<section class="banner">

    <div class="container">

        <div class="row">

           <!--  <div class="item col-md-6 col-sm-6 col-xs-12">

                <div class="banner-right">

                    <div class="banner-text">

					<?php if(!empty($bannerTitle)){?>	

                    <h1> <?php echo $bannerTitle;?></h1>

					<?php }?>

                    <div class="banner-progres">

                        <?php if(!empty($bannerContent)){?>	

						<?php echo $bannerContent;?>

						<?php }?>

                    </div>

					<?php if(!empty($bannerBText) && !empty($bannerBUrl)){?>	

                    <a href="<?php echo $bannerBUrl;?>" class="button"><?php echo $bannerBText;?></a>

					<?php }?>

                    </div>

                </div>

            </div> -->
			<div class="item  col-md-12 col-sm-12 col-xs-24">

			<div class="banner-left">

				<img src="<?php echo $bannerImage1;?>" alt="Product" />
				<a href="<?php echo $bannerBUrl;?>"><?php echo $bannerBText;?></a>

			</div>

			</div>
          <!--   <div class="item  col-md-6 col-sm-6 col-xs-12">

                <div class="banner-right">

                    <img src="<?php //echo $bannerImage2;?>" alt="Product" />
					<?php if(!empty($bannerBText) && !empty($bannerBUrl)){?>	
					<div class="bnr-btn">

						<a href="<?php echo $bannerBUrl;?>"><?php echo $bannerBText;?></a>

					</div>
					<?php }?>
                </div>

            </div> -->

        </div>

    </div>

</section>

<?php }?>


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





<?php 

$args = array(

	'post_type' => 'feature',

	'posts_per_page' => -1,

);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ): 

?>



<section class="abonnement">

    <div class="container">

        <div class="row">

            <div class="col-xs-12">

                <div class="page-title">

                    <h2>Abonnement hos Undy er ligetil</h2>

                </div>

            </div>

        </div>

        <div class="row">

			<?php 

			while ( $loop->have_posts() ) : $loop->the_post();

				$icon = types_render_field("process-image",array("url"=>true));

			?>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="abonnement-content">

                    <img src="<?php echo $icon;?>" alt="<?php the_title();?>"/>

                    <h3><?php the_title();?></h3>

                    <?php the_content();?>

                </div>

            </div>

			<?php endwhile; ?>

        </div>

        <div class="abonnement-btn">

            <a href="https://undy.dk/proevepakke/">PRØV I DAG</a>

        </div>

        

    </div>

</section> 

<?php endif; wp_reset_query();?>



<?php 



$procesHomeImage = types_render_field("process-home-image",array("url"=>true));



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

                <?php endwhile;?>

             <?php if(!empty($procesHomeImage)){?>   

				<div class="sadan_virker-right">

					<img src="<?php echo $procesHomeImage;?>" alt=""/>

				</div>

			<?php }?>

            </div>

        </div>

    </div>

</section>

<?php endif; wp_reset_query();?>

    

<section class="inviter-section">

    <div class="container-fluid">

        <div class="row">

			<?php $image = get_the_post_thumbnail_url();

			if(!empty($image)){

			?>

            <div class="col-md-6 col-sm-6 col-xs-12 item">

                <div class="inviter-left-img">

                    <img src="<?php echo $image;?>" alt=""/>

                </div>

            </div>

			<?php }?>

            <div class="<?php if(!empty($image)){?>col-md-6 col-sm-6<?php }?> col-xs-12 item">

                <div class="inviter-right-content">

                    <div class="inviter-inner">

                    <?php the_content();?>

                    <div class="abonnement-btn">

                        <a href="https://undy.dk/proevepakke/">PRØV I DAG</a>

                    </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>    



<div class="reviews" style="padding: 0px">

	<section class="instagram-section">

		<div class="container">

			<div class="row">

				<div class="col-xs-12">

					<div class="page-title">

						<h2>Følg os på instagram <span style="color:#AE1917;">@undy.dk</span></h2>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-xs-12">

					<?php //echo do_shortcode('[insta-gallery id="1"]');?>
					<?php echo do_shortcode('[instagram-feed]');?>

				</div>

			</div>

		</div>

	</section>

</div>

<?php endwhile; endif;?>

<?php get_footer();?>