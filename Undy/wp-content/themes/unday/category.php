<?php
/**
* A Simple Category Template
*/
 
get_header(); ?> 
 
<section class="category_detail">
	<div class="container">

		<?php 
		// Check if there are any posts to display
		if ( have_posts() ) : ?>
		
		<div class="boxerbriefs_min" style="margin-top: 20px;text-align: center;">

			<h1>Kategori: <span><?php single_cat_title(); ?></span></h1>

        </div>
		
		<div class="category_list">

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="category_right">

                        <div class="row">
							

							<?php

							// The Loop
							while ( have_posts() ) : the_post(); 
							$featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
							?>

								<div class="col-md-4 col-sm-4 col-xs-6">

                                <div class="category_min_box">

                                    <div class="category_min_images">

                                        <a href="<?php the_permalink(); ?>">

										<img src="<?php echo $featured_img_url; ?>" alt="" class="main-image">

										
										</a>

                                    </div>

                                    <div class="category_min_text">

                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                       
										
                                    </div>

                                </div>

                            </div>
							
							
							


							<?php endwhile; ?>
						</div>

					

                    </div>

                </div>

            </div>

        </div>
							
		<?php else: ?>
		<p>Sorry, no posts matched your criteria.</p>


		<?php endif; ?>
	</div>
</section>
 
 

<?php get_footer(); ?>