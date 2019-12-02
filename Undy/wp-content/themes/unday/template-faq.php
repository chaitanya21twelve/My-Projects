<?php

/*

	Template Name: Faqs

*/

get_header();

?>

<html>

<body>
	<section class="faq-banner">
		<img src="<?php echo get_field("banner_image"); ?>" width="100%" alt=""/>
		<div class="container">
			<div class="row">
				<div class="banner-description">
					<h1><?php the_title(); ?></h1>
					<h3><?php echo get_field("banner_text"); ?></h3>
				</div>
			</div>
		</div>

	</section>
	<section class="faq-description">
		<div class="container">
			<div class="faq-des">
				

			<div class="col-md-6 col-sm-6 col-xs-12">

				
				
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
					
					<?php
					
						$i = 1;
						$query = new WP_Query( array(
									'post_type' => 'faqs',
									'post_status' => 'publish',
									'order' => 'ASC',
									'posts_per_page' => -1
							) );               

							if ( $query->have_posts() ) : ?>
								<?php while ( $query->have_posts() ) : $query->the_post();
							
							
							if($i%2 != 0){
								//if($i == 1){ $class = "in"; }else{ $class = ""; }
								//if($i == 1){ $class1 = "true"; }else{ $class1 = "false"; }
					?> 
							
					
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne<?php echo $i; ?>">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $i; ?>">
										  <?php the_title(); ?> 
										</a>
									</h4>
								</div>
								
								<div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $i; ?>">
									<div class="panel-body">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
					
					<?php } $i++; endwhile; wp_reset_postdata(); ?>
							<!-- show pagination here -->
					<?php else : ?>
								<!-- show 404 error here -->
					<?php endif; ?>
					
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
					
					
					<?php
					
						$j = 1;
						$query = new WP_Query( array(
									'post_type' => 'faqs',
									'post_status' => 'publish',
									'order' => 'ASC',
									'posts_per_page' => -1
							) );               

							if ( $query->have_posts() ) : ?>
								<?php while ( $query->have_posts() ) : $query->the_post();
							
							
							if($j%2 == 0){
								//if($j == 2){ $class = "in"; }else{ $class = ""; }
								//if($j == 2){ $class1 = "true"; }else{ $class1 = "false"; }
					?> 
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne<?php echo $j; ?>">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne<?php echo $j; ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $j; ?>">
										  <?php the_title(); ?> 
										</a>
									</h4>

								</div>
								<div id="collapseOne<?php echo $j; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $j; ?>">
									<div class="panel-body">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
					
					<?php } $j++; endwhile; wp_reset_postdata(); ?>
							<!-- show pagination here -->
					<?php else : ?>
								<!-- show 404 error here -->
					<?php endif; ?>
					
					
					
				</div>
			</div>
			</div>
		<div class="faq-detail">
			<img src="<?php echo IMAGES_URL;?>/contact_icon.png" alt=""/>
			<h2><?php echo get_field("text_1"); ?></h2>
			<h4><?php echo get_field("text_2"); ?></h4>
			<div class="faq-call">
                                <a href="tel:<?php echo get_field("phone"); ?>"><?php echo get_field("phone"); ?></a>
                                <p><?php echo get_field("time"); ?></p>
            </div>
			<div class="faq-call">
				<a href="mail:<?php echo get_field("email"); ?>"><?php echo get_field("email"); ?></a>
				<p><?php echo get_field("text_3"); ?></p>
            </div>
		</div>
		</div>
	</section>
</body>
</html>


<?php get_footer();?>